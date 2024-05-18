<?php include_once("includes/setup.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game</title>
</head>
<body>
    <?php
    if (isset($_GET['game'])) {
        $gameName = $_GET['game'];
        $gameQuery = $mysqli->query("SELECT gameID FROM Games WHERE gameName = '$gameName'");
        if (mysqli_num_rows($gameQuery) > 0) {
            $game = $gameQuery->fetch_object();
            echo "<p>$game->gameID</p>";
        } else {
            echo "<p>Game not found!</p>";
        }
    } else {
        ?>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>PSNP%</th>
                    <th>Difficulty</th>
                    <th>Hours</th>
                    <th>Platform</th>

                </tr>
            </thead>
            <tbody>
                <?php
                    $games = $mysqli->query("SELECT * FROM GameInLibrary");
                    while ($game = $games->fetch_object()) {
                        echo "<p>$game->gameName</p>";
                    }
                ?>
            </tbody>
        </table>
    <?php
    }
    ?>
</body>
</html>