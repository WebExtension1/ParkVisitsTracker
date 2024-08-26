<?php
include_once("includes/setup.php");

if (!isset($_COOKIE['selectedTab'])) {
    setcookie("selectedTab", "left");
}
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
    $valid = true;
    if (!isset($_SESSION['userID'])) {
        $valid = false;
    }
    if ($valid == true) {
        if (isset($_GET['game'])) {
            $gameName = $_GET['game'];
            $gameName = str_replace("'", "''", $gameName);
            $gameQuery = $mysqli->query("SELECT * FROM Games WHERE gameName = '$gameName'");
            if (mysqli_num_rows($gameQuery) == 1) {
                // Game Details Page
                $game = $gameQuery->fetch_object();
                echo "<h1>$game->gameName</h1>";

                $guides = $mysqli->query("SELECT * FROM GameGuides WHERE gameID = $game->gameID");
                echo "<div class='guides'>";
                if (mysqli_num_rows($guides) > 0) {
                    echo "<h2>Guides</h2>";
                } else {
                    echo "<h3>No guides found</h3>";
                }
                if (mysqli_num_rows($guides) > 0) {
                    while ($guide = $guides->fetch_object()) {
                        $url = str_replace("www.", "", $guide->link);
                        $url = explode("://", $url)[1];
                        $url = explode(".", $url)[0];
                        echo "<p><a href='$guide->link' target='_blank'>$url</a></p>";
                    }
                }
                echo "</div>";
    
                $cexs = $mysqli->query("SELECT * FROM GameCEX, GamePlatforms WHERE gameID = $game->gameID AND GameCEX.platformID = GamePlatforms.platformID");
                echo "<div class='cexs'>";
                if (mysqli_num_rows($cexs) > 0) {
                    echo "<h2>CEXs</h2>";
                } else {
                    echo "<h3>No CEX links found</h3>";
                }
                if (mysqli_num_rows($cexs) > 0) {
                    while ($cex = $cexs->fetch_object()) {
                        $gameOwned = $mysqli->query("SELECT * FROM GameInLibrary WHERE gameID = $game->gameID AND platformID = $cex->platformID");
                        $platform = str_replace(" ", "", $cex->platformName);
                        if (mysqli_num_rows($gameOwned) > 0) {
                            $extension = "sell/product-detail?id=$cex->id&categoryName=$platform-games";
                        } else {
                            $extension = "product-detail?id=$cex->id&categoryName=$platform-games";
                        }
                        echo "<p><a href='https://uk.webuy.com/$extension' target='_blank'>$cex->platformName</a></p>";
                    }
                }
            } else {
                // Invalid Name
                echo "<p>Game not found!</p>";
            }
        } else {
            // Game Overview Pages
            ?>
            <div class="games-view-option">
                <p class="games-view-option-1" onclick="left()">View Games In Library</p>
                <p class="games-view-option-2" onclick="right()">View All Games</p>
            </div>
            <div class="games-container">
                <div class="games-in-library">
                    <a href="new-game/library">Add Game</a>
                    <table class="game-list">
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
                                $iteration = 1;
                                $hidden = "";
                                while ($game = $games->fetch_object()) {
                                    if ($iteration == 11) {
                                        echo "<tr class='load-more-all-games-row'><td><button class='load-more-all-games'>Load More</button></td></tr>";
                                        $hidden = "style='display:none;' class='all-games-hidden'";
                                    }
                                    $gameName = str_replace(" ", "+", $game->gameName);
                                    echo "<tr $hidden><td><a href=\"game/$gameName\">$game->gameName</a></td><td>$game->platformName</td>";
                                    $percentages = $mysqli->query("SELECT GamePSNP.PSNP, GamePSNP.PSN FROM GamePSNP, GamePlatforms WHERE GamePSNP.gameID = $game->gameID");
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
                                    $iteration++;
                                }
                                if ($iteration > 10) {
                                    echo "</div>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="all-games">
                    <a href="new-game/register">Register Game</a>
                    <table class="game-list">
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
                                $iteration = 1;
                                $hidden = "";
                                while ($game = $games->fetch_object()) {
                                    if ($iteration == 11) {
                                        echo "<tr class='load-more-all-games-row'><td><button class='load-more-all-games'>Load More</button></td></tr>";
                                        $hidden = "style='display:none;' class='all-games-hidden'";
                                    }
                                    $gameName = str_replace(" ", "+", $game->gameName);
                                    echo "<tr $hidden ><td><a href=\"game/$gameName\">$game->gameName</a></td>";
                                    $amount = mysqli_num_rows($mysqli->query("SELECT * FROM GameGuides WHERE GameGuides.gameID = $game->gameID"));
                                    echo "<td>$amount</td>";
                                    $amount = mysqli_num_rows($mysqli->query("SELECT * FROM Games, GameInLibrary WHERE Games.gameID = GameInLibrary.gameID"));
                                    echo "<td>$amount</td><td><a href='new-game/library/$game->gameID'>Add To Library</a></td>";
                                    echo "<td><a href=\"edit-game/$gameName\">Edit</a></td>";
                                    echo "</tr>";
                                    $iteration++;
                                }
                                if ($iteration > 10) {
                                    echo "</div>";
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php
        }
    } else {
        ?>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Platform</th>
                </tr>
            </thead>
            <tbody>
        <?php
        $gamesQuery = $mysqli->query("SELECT * FROM gameInLibrary, games, gamePlatforms WHERE gameInLibrary.gameID = games.gameID AND gameInLibrary.platformID = gamePlatforms.platformID");
        while ($game = $gamesQuery->fetch_object()) {
            echo "<tr><td>$game->gameName</td><td>$game->platformName</td></tr>";
        }
        ?>
        </tbody>
        </table>
        <?php
    }
    ?>
</body>
</html>