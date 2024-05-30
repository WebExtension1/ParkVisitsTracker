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
        $gameName = str_replace("'", "''", $gameName);
        $gameQuery = $mysqli->query("SELECT * FROM Games WHERE gameName = '$gameName'");
        if (mysqli_num_rows($gameQuery) == 1) {
            // Game Details Page
            $game = $gameQuery->fetch_object();
            echo "<h1>$game->gameName</h1>";
            ?>
                <?php
                $guides = $mysqli->query("SELECT * FROM GameGuides WHERE gameID = $game->gameID");
                if (mysqli_num_rows($guides) > 1) {
                    echo "<div class='guides'><h2>Guides</h2>";
                } else if (mysqli_num_rows($guides) == 1) {
                    echo "<div class='guides'><h2>Guide</h2>";
                } else {
                    echo "<div class='guides'><h3>No guides found</h3>";
                }
                if (mysqli_num_rows($guides) > 0) {
                    while ($guide = $guides->fetch_object()) {
                        $url = str_replace("www.", "", $guide->link);
                        $url = explode("://", $url)[1];
                        $url = explode(".", $url)[0];
                        echo "<p><a href='$guide->link' target='_blank'>$url</a></p>";
                    }
                    echo "</div>";
                }

                $platforms = $mysqli->query("SELECT * FROM gamePlatforms WHERE platformID IN (SELECT platformID FROM gameCEX WHERE gameID = $game->gameID) OR platformID IN (SELECT platformID FROM gamePSNP WHERE gameID = $game->gameID)");
                if (mysqli_num_rows($platforms) > 1) {
                    echo "<div class='platforms'><h2>Platforms</h2></div>";
                } else if (mysqli_num_rows($platforms) == 1) {
                    echo "<div class='platforms'><h2>Platform</h2></div>";
                } else {
                    echo "<div class='platforms'><h3>No external information linked</h3></div>";
                }
                if (mysqli_num_rows($platforms) > 0) {
                    while ($platform = $platforms->fetch_object()) {
                        echo "<p>$platform->platformName</p>";
                    }
                }
                ?>
            <?php
        } else {
            // Invalid Name
            echo "<p>Game not found!</p>";
        }
    } else {
        // Game Overview Pages
        ?>
        <div class="games-view-option">
            <p class="games-view-option-1" style="background-color: gray;">View Games In Library</p>
            <p class="games-view-option-2" style="background-color: lightgray;">View All Games</p>
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
                            $gameName = str_replace(" ", "+", $game->gameName);
                            echo "<tr><td><a href=\"game/$gameName\">$game->gameName</a></td><td>$game->platformName</td>";
                            $percentages = $mysqli->query("SELECT * FROM GamePSNP, GamePlatforms WHERE GamePSNP.gameID = $game->gameID AND GamePSNP.platformID = GamePlatforms.platformID");
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
                            $gameName = str_replace(" ", "+", $game->gameName);
                            echo "<tr><td><a href=\"game/$gameName\">$game->gameName</a></td>";
                            $amount = mysqli_num_rows($mysqli->query("SELECT * FROM GameGuides WHERE GameGuides.gameID = $game->gameID"));
                            echo "<td>$amount</td>";
                            $amount = mysqli_num_rows($mysqli->query("SELECT * FROM Games, GameInLibrary WHERE Games.gameID = GameInLibrary.gameID"));
                            echo "<td>$amount</td><td><a href=''>Add To Library</a></td>";
                            echo "<td><a href=\"edit-game/$gameName\">Edit</a></td>";
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