<?php
include_once("includes/setup.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Game</title>
    <link rel="stylesheet" href="css/mobile.css" />
    <link rel="stylesheet" href="css/desktop.css" media="only screen and (min-width : 790px)"/>
</head>
<body>
    <?php
    include_once("includes/header.php");
    if (isset($_GET['gameName'])) {
        $gameName =  $_GET['gameName'];
        $gameName = str_replace("'", "''", $gameName);
        $gameToEditQuery = $mysqli->query("SELECT * FROM Games WHERE gameName = '$gameName'");
        if (mysqli_num_rows($gameToEditQuery) > 0) {
            $gameToEdit = $gameToEditQuery->fetch_object();
            echo "<h1>$gameName</h1>";
        } else {
            echo "<p>Game not found</p>";
        }
    } else {
        echo "<p>Game not found</p>";
    }
    ?>
</body>
</html>