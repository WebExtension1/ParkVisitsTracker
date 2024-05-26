<?php
include_once("includes/setup.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game</title>
    <link rel="stylesheet" href="css/mobile.css" />
    <link rel="stylesheet" href="css/desktop.css" media="only screen and (min-width : 790px)"/>
    <script src="js/allGames.js" defer></script>
</head>
<body>
    <?php
    include_once("includes/header.php");
    if (isset($_GET['game'])) {
        $gameName = $_GET['game'];
        $gameQuery = $mysqli->query("SELECT gameID FROM Games WHERE gameName = '$gameName'");
        if (mysqli_num_rows($gameQuery) > 0) {
            // Game Details Page
        } else {
            // Invalid Name
            echo "<p>Game not found!</p>";
        }
    } else {
        // Game Overview Page
        ?>
        <div class="games-view-option">
            <p class="games-view-option-1">View Games In Library</p>
            <p class="games-view-option-2">View All Games</p>
        </div>
        <div class="games-in-library">
            <a href="new-game/library">Add Game</a>
            <table class="gameList">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Platform</th>
                        <th>PSNP%</th>
                        <th>PSN%</th>
                        <th>Difficulty</th>
                        <th>Hours</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $games = $mysqli->query("SELECT * FROM GameInLibrary, Games, GamePlatforms WHERE Games.gameID = GameInLibrary.gameID AND GameInLibrary.platformID = GamePlatforms.platformID ORDER BY gameName ASC");
                        while ($game = $games->fetch_object()) {
                            echo "<tr><td>$game->gameName</td><td>$game->platformName</td>";
                            $percentages = $mysqli->query("SELECT * FROM GamePercentages, GamePlatforms WHERE GamePercentages.gameID = $game->gameID AND GamePercentages.platformID = GamePlatforms.platformID");
                            if (mysqli_num_rows($percentages) > 0) {
                                $percentage = $percentages->fetch_object();
                                echo "<td>$percentage->PSNP</td><td>$percentage->PSN</td>";
                            } else {
                                echo "<td></td><td></td>";
                            }
                            $guides = $mysqli->query("SELECT * FROM GameGuides WHERE gameID = $game->gameID");
                            if (mysqli_num_rows($guides) > 0) {
                                $guide = $guides->fetch_object();
                                echo "<td>$guide->difficulty/10</td><td>$guide->hours</td>";
                            } else {
                                echo "<td></td><td></td>";
                            }
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="all-games">
            <a href="new-game/register">Register Game</a>
            <table class="gamelist">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Guides</th>
                        <th>Owned</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $games = $mysqli->query("SELECT * FROM Games ORDER BY gameName ASC");
                        while ($game = $games->fetch_object()) {
                            echo "<tr><td>$game->gameName</td>";
                            $amount = mysqli_num_rows($mysqli->query("SELECT * FROM Games, GameGuides WHERE Games.gameID = GameGuides.gameID"));
                            echo "<td>$amount</td>";
                            $amount = mysqli_num_rows($mysqli->query("SELECT * FROM Games, GameInLibrary WHERE Games.gameID = GameInLibrary.gameID"));
                            echo "<td>$amount</td><td>Add To Library</td>";
                            echo "</tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    <?php
    }
    ?>
</body>
</html>