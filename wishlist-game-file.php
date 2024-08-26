<?php
include_once("includes/setup.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist Game</title>
    <link rel="stylesheet" href="css/mobile.css" />
    <link rel="stylesheet" href="css/desktop.css" media="only screen and (min-width : 790px)"/>
</head>
<body>
    <?php
    include_once("includes/header.php");

    $gameNameValid = false;
    if (isset($_GET['gameName'])) {
        $gameNameValid = true;
        $gameNameFromGET = $_GET['gameName'];
        $gameNameFromGET = str_replace("+", " ", $gameNameFromGET);
        $gameNameQuery = $mysqli->query("SELECT * FROM games WHERE gameName = '$gameNameFromGET'");
        if (mysqli_num_rows($gameNameQuery) > 0) {<?php
            include_once("includes/setup.php");
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Wishlist Game</title>
                <link rel="stylesheet" href="css/mobile.css" />
                <link rel="stylesheet" href="css/desktop.css" media="only screen and (min-width : 790px)"/>
            </head>
            <body>
                <?php
                include_once("includes/header.php");
            
                $gameNameValid = false;
                if (isset($_GET['gameName'])) {
                    $gameNameValid = true;
                    $gameNameFromGET = $_GET['gameName'];
                    $gameNameFromGET = str_replace("+", " ", $gameNameFromGET);
                    $gameNameQuery = $mysqli->query("SELECT * FROM games WHERE gameName = '$gameNameFromGET'");
                    if (mysqli_num_rows($gameNameQuery) > 0) {
                        $gameName = $gameNameFromGET;
                    } else {
                        $gameNameQuery = $mysqli->query("SELECT * FROM games WHERE gameID = '$gameNameFromGET'");
                        if (mysqli_num_rows($gameNameQuery) > 0) {
                            $gameName = $gameNameQuery->fetch_object()->gameName;
                        } else {
                            $gameNameValid = false;
                        }
                    }
                }
            
                if (!isset($gameName)) {
                    $gameName = "";
                }
                ?>
                <form method="post">
                    <label for="game-name">Game Name</label>
                    <select name="gameName" id="game-name">
                        <option value="0"></option>
                        <?php
                        $allGames = $mysqli->query("SELECT * FROM games");
                        while ($game = $allGames->fetch_object()) {
                            $selected = "";
                            if ($game->gameName == $gameName) {
                                $selected = "selected";
                            }
                            echo "<option value='$game->gameID' $selected>$game->gameName</option>";
                        }
                        ?>
                    </select>
                    <label for="game-platform">Platform</label>
                    
                    <label for="game-format">Format</label>
                </form>
            </body>
            </html>
            $gameName = $gameNameFromGET;
        } else {
            $gameNameQuery = $mysqli->query("SELECT * FROM games WHERE gameID = '$gameNameFromGET'");
            if (mysqli_num_rows($gameNameQuery) > 0) {
                $gameName = $gameNameQuery->fetch_object()->gameName;
            } else {
                $gameNameValid = false;
            }
        }
    }

    if (!isset($gameName)) {
        $gameName = "";
    }
    ?>
    <form method="post">
        <label for="game-name">Game Name</label>
        <select name="gameName" id="game-name">
            <option value="0"></option>
            <?php
            $allGames = $mysqli->query("SELECT * FROM games");
            while ($game = $allGames->fetch_object()) {
                $selected = "";
                if ($game->gameName == $gameName) {
                    $selected = "selected";
                }
                echo "<option value='$game->gameID' $selected>$game->gameName</option>";
            }
            ?>
        </select>
        <label for="game-platform">Platform</label>
        
        <label for="game-format">Format</label>
    </form>
</body>
</html>