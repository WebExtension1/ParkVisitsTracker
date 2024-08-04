<?php
include_once("includes/setup.php");

$errors = array();

$library = false;

if (isset($_POST['register'])) {
    $gameNameExistsQuery = $mysqli->prepare("SELECT * FROM games WHERE gameName = ?");
    $gameNameExistsQuery->bind_param('s', $_POST['game-name']);
    $gameNameExistsQuery->execute();
    $nameExists = $gameNameExistsQuery->get_result();

    if (mysqli_num_rows($nameExists) > 0) {
        array_push($errors, "Game already exists");
    } else {
        $newGameQuery = $mysqli->prepare("INSERT INTO games (gameName) VALUES (?)");
        $newGameQuery->bind_param('s', $_POST['game-name']);
        $newGameQuery->execute();
        $gameID = mysqli_insert_id($mysqli);
        
        $guidesSQL = "INSERT INTO gameguides (gameID, link, difficulty, hours) VALUES ";
        $guidesValid = false;
        for ($guideID = 0; $guideID < count($_POST['guide-link']); $guideID++) {
            $guideLink = $_POST['guide-link'][$guideID];
            if ($guideLink != "") {
                $guideDifficulty = $_POST['difficulty'][$guideID];
                $guideHours = $_POST['hours'][$guideID];
    
                if ($guideDifficulty == "") {
                    $guideDifficulty = "null";
                }
                if ($guideHours == "") {
                    $guideHours = "null";
                }

                if ($guidesValid == true) {
                    $guidesSQL .= ", ";
                }
                $guidesValid = true;
                $guidesSQL .= "($gameID, '$guideLink', $guideDifficulty, $guideHours)";
            }
        }
        $guidesSQL .= ";";
        if ($guidesValid == true) {
            $mysqli->query($guidesSQL);
        }

        $cexValid = true;
        $ids = array();
        $platforms = array();
        for ($cexID = 0; $cexID < count($_POST['cex-link']); $cexID++) {
            $id = explode("&", explode("id=", $_POST['cex-link'][$cexID])[1])[0];
            $platform = explode("playstation", $_POST['cex-link'][$cexID])[1][0];
            if (in_array($id, $ids) || in_array($platform, $platforms)) {
                $cexValid = false;
            } else {
                array_push($platforms, $platform);
                array_push($ids, $id);
            }
        }
        if ($cexValid == true) {
            $cexSQL = "INSERT INTO gamecex (gameID, id, platformID, cash, voucher) VALUES ";
            $cexValid = false;
            for ($cexLoop = 0; $cexLoop < count($_POST['cex-link']); $cexLoop++) {
                $cexID = $ids[$cexLoop];
                $cexPlatform = $platforms[$cexLoop];
                $cexCash = $_POST['cash'][$cexLoop];
                $cexVoucher = $_POST['voucher'][$cexLoop];
                if ($cexID != "" && $cexPlatform != "" && $cexCash != "" && $cexVoucher != "") {
                    if ($cexValid == true) {
                        $cexSQL .= ", ";
                    }
                    $cexValid = true;
                    $cexSQL .= "($gameID, '$cexID', $cexPlatform, $cexCash, $cexVoucher)";
                }
            }
            $cexSQL .= ";";
            if ($cexValid == true) {
                $mysqli->query($cexSQL);
            }
        } else {
            array_push($errors, "CEX links have duplicate platforms");
        }

        $psnpValid = true;
        $ids = array();
        $platforms = array();
        for ($psnpID = 0; $psnpID < count($_POST['psnp-link']); $psnpID++) {
            $id = explode("-", explode("trophies/", $_POST['psnp-link'][$psnpID])[1])[0];
            $platform = $_POST['psnp-platform'][$psnpID];
            if (in_array($id, $ids) || in_array($platform, $platforms)) {
                $psnpValid = false;
            } else {
                array_push($platforms, $platform);
                array_push($ids, $id);
            }
        }
        if ($psnpValid == true) {
            $psnpSQL = "INSERT INTO gamepsnp (gameID, id, PSN, PSNP, hasPlatinum, attainable, platformID) VALUES ";
            $psnpValid = false;
            for ($psnpLoop = 0; $psnpLoop < count($_POST['psnp-link']); $psnpLoop++) {
                $psnpID = $ids[$psnpLoop];
                $psn = $_POST['psn'][$psnpLoop];
                $psnp = $_POST['psnp'][$psnpLoop];
                if (isset($_POST['platinum'][$psnpLoop])) {
                    $hasPlatinum = 1;
                } else {
                    $hasPlatinum = 0;
                }
                if (isset($_POST['attainable'][$psnpLoop])) {
                    $attainable = 1;
                } else {
                    $attainable = 0;
                }
                $platform = $platforms[$psnpLoop];
                if ($psnpID != "" && $psn != "" && $psnp != "") {
                    if ($psnpValid == true) {
                        $psnpSQL .= "," ;
                    }
                    $psnpValid = true;
                    $psnpSQL .= "($gameID, $psnpID, $psn, $psnp, $hasPlatinum, $attainable, $platform)";
                }
                echo $psnpSQL;
            }
            $psnpSQL .= ";";
            if ($psnpValid == true) {
                $mysqli->query($psnpSQL);
            }
        } else {
            array_push($errors, "PSNP links have duplicate platforms");
        }

        if (!isset($_POST['stay'])) {
            //header("Location: ../games.php");
        }
    }
}

if (isset($_POST['add-to-library'])) {
    if ($_POST['gameName'] != 0) {
        $game = $_POST['gameName'];
        $platform = $_POST['gamePlatform'];
        $format = $_POST['gameFormat'];
        $owner = $_POST['gameOwner'];
        $libraryGame = $mysqli->prepare("INSERT INTO gameInLibrary (gameID, platformID, formatID, owner) VALUES (?, ?, ?, ?)");
        $libraryGame->bind_param("ssss", $game, $platform, $format, $owner);
        $libraryGame->execute();
        if ($_POST['gameFormat'] == 1) {
            $insertID = mysqli_insert_id($mysqli);
            $holder = $_POST['gameHolder'];
            $gameHolder = $mysqli->prepare("INSERT INTO physicalGameOwner VALUES (?, ?)");
            $gameHolder->bind_param("ss", $insertID, $holder);
            $gameHolder->execute();
        }
        header("Location: ../../../ParkVisitsTracker/game.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Game</title>
    <link rel="stylesheet" href="../css/mobile.css" />
    <link rel="stylesheet" href="../css/desktop.css" media="only screen and (min-width : 790px)"/>
</head>
<body>
    <?php
    include_once("includes/header.php");
    if (isset($_GET['type'])) {
        $type = $_GET['type'];
        if ($type == "register") {
            ?>
            <script src="../js/newGameRegister.js" defer></script>
            <h1>New Game</h1>
            <form method="post">
                <label for="game-name">Game Name</label>
                <input type="text" name="game-name" id="game-name" required>
                
                <h3>Add Guide Information (Optional)</h3>
                <div class="guide-sections">
                    <div class="guide-section">
                        <label for="guide-link">Link</label>
                        <input type="text" name="guide-link[]" id="guide-link">
                        <label for="difficulty">Difficulty</label>
                        <input type="text" name="difficulty[]" id="difficulty">
                        <label for="hours">Hours</label>
                        <input type="text" name="hours[]" id="hours">
                        <img src="../images/Red-Circle-Transparent.png" alt="Img" style="width: 15px; height: 15px; display: none;" class="remove guide-remove">
                    </div>
                </div>
                <p class="add-new-guide">+ Add New</p>
                
                <h3>Add CEX Information (Optional)</h3>
                <div class="cex-sections">
                    <div class="cex-section">
                        <label for="cex-link">Link</label>
                        <input type="text" name="cex-link[]" id="cex-link">
                        <label for="cash">Cash</label>
                        <input type="text" name="cash[]" id="cash">
                        <label for="voucher">Voucher</label>
                        <input type="text" name="voucher[]" id="voucher">
                        <img src="../images/Red-Circle-Transparent.png" alt="Img" style="width: 15px; height: 15px; display: none;" class="remove cex-remove">
                    </div>
                </div>
                <p class="add-new-cex">+ Add New</p>

                <h3>Add PSNP Information (Optional)</h3>
                <div class="psnp-sections">
                    <div class="psnp-section">
                        <label for="psnp-link">Link</label>
                        <input type="text" name="psnp-link[]" id="psnp-link">
                        <label for="psnp-platform">Platform</label>
                        <select name="psnp-platform[]" id="psnp-platform">
                        <?php
                            $platformsQuery = $mysqli->query("SELECT * FROM gameplatforms");
                            $index = 0;
                            while ($platform = $platformsQuery->fetch_object()) {
                                echo "<option value='$index'>$platform->platformName</option>";
                                $index++;
                            }
                        ?>
                        </select>
                        <label for="psn">PSN %</label>
                        <input type="text" name="psn[]" id="psn">
                        <label for="psnp">PSNP %</label>
                        <input type="text" name="psnp[]" id="psnp">
                        <label for="platinum">Platinum</label>
                        <input type="checkbox" name="platinum[]" id="platinum">
                        <label for="attainable">Attainable</label>
                        <input type="checkbox" name="attainable[]" id="attainable">
                        <img src="../images/Red-Circle-Transparent.png" alt="Img" style="width: 15px; height: 15px; display: none;" class="remove psnp-remove">
                    </div>
                </div>
                <p class="add-new-psnp">+ Add New</p>
                
                <label for="stay">Keep Adding</label>
                <input type="checkbox" name="stay" id="stay" <?php if (isset($_POST['stay'])) { echo "checked"; } ?>>
                <button name="register">Register</button>

                <?php
                if (count($errors) > 0) {
                    foreach ($errors as $error) {
                        echo "<p class='error-message'>$error</p>";
                    }
                }
                ?>
            </form>
            <?php
        } else if ($type == "library") {
            $library = true;
        } else {
            header("Location:../../../ParkVisitsTracker/games.php");
        }
    } else if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $gameFromID = $mysqli->query("SELECT * FROM games WHERE gameID = $id");
        if (mysqli_num_rows($gameFromID) == 1 ) {
            $gameToLibrary = $gameFromID->fetch_object();
            $library = true;
        } else {
            header("Location:../../../ParkVisitsTracker/games.php");
        }
    }
    if ($library == true) {
        echo "<h1>Add Game To Library</h1>";
        echo "<script src='../../../ParkVisitsTracker/js/newGameLibrary.js' defer></script>";
        if (isset($gameToLibrary)) {
            $gameName = $gameToLibrary->gameName;
        } else {
            $gameName = "";
        }
        ?>
        <form method="post">
            <label for='game-name'>Game</label>
            <select name="gameName" id='game-name'>
                <?php
                $allGames = $mysqli->query("SELECT * FROM games");
                echo "<option value='0'></option>";
                while ($game = $allGames->fetch_object()) {
                    $selected = "";
                    if ($game->gameName == $gameName) {
                        $selected = "selected";
                    }
                    echo "<option value='$game->gameID' $selected>$game->gameName</option>";
                }
                ?>
            </select>
            <label for="platform">Platform</label>
            <select name="gamePlatform" id="platform">
                <?php
                $allPlatforms = $mysqli->query("SELECT * FROM gamePlatforms");
                while ($platform = $allPlatforms->fetch_object()) {
                    echo "<option value='$platform->platformID'>$platform->platformName</option>";
                }
                ?>
            </select>
            <label for="format">Format</label>
            <select name="gameFormat" id="format">
                <?php
                $allFormats = $mysqli->query("SELECT * FROM gameFormats");
                while ($format = $allFormats->fetch_object()) {
                    echo "<option value='$format->formatID'>$format->formatName</option>";
                }
                ?>
            </select>
            <label for="owner">Owner</label>
            <select name="gameOwner" id="owner">
                <option value="1">Robert</option>
                <option value="2">Kelton</option>
            </select>
            <div id='format-holder-div'>
                <label for="holder">Holder</label>
                <select name="gameHolder" id="holder">
                    <option value="1">Robert</option>
                    <option value="2">Kelton</option>
                </select>
            </div>
            <button name='add-to-library'>Add to Library</button>
        </form>
        <?php
    }
    ?>
</body>
</html>