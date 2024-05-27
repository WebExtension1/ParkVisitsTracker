<?php
include_once("includes/setup.php");

$errors = array();

if (isset($_POST['game-name'])) {
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
        echo $gameID;
        
        if (!isset($_POST['stay'])) {
            header("Location: ../games.php");
        }
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
                        <label for="cex-platform">Platform</label>
                        <select name="platform[]" id="cex-platform">
                        <?php
                            $platformsQuery = $mysqli->query("SELECT * FROM gameplatforms");
                            $index = 0;
                            while ($platform = $platformsQuery->fetch_object()) {
                                echo "<option value='$index'>$platform->platformName</option>";
                                $index++;
                            }
                        ?>
                        </select>
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
                        <select name="platform[]" id="psnp-platform">
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
                        <label for="attainable">Attainable</label>
                        <input type="checkbox" name="attainable[]" id="attainable">
                        <img src="../images/Red-Circle-Transparent.png" alt="Img" style="width: 15px; height: 15px; display: none;" class="remove psnp-remove">
                    </div>
                </div>
                <p class="add-new-psnp">+ Add New</p>
                
                <label for="stay">Keep Adding</label>
                <input type="checkbox" name="stay" id="stay" <?php if (isset($_POST['stay'])) { echo "checked"; } ?>>
                <button>Register</button>

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
            ?>
            <h1>Add Game To Library</h1>
            <form method="post">
                
            </form>
            <?php
        } else {
            echo "Wrong";
        }
    } else {

    }
    ?>
</body>
</html>