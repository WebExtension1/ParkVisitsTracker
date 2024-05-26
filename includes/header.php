<header>
    <div class="public-header">

    </div>
    <div class="private-header">
        <?php
        echo "<a href='../../ParkVisitsTracker/index.php'>Rides</a>";
        if ($signedInUser->username == "ImKelton" || $signedInUser->username == "WebExtension") {
            echo "<a href='../../ParkVisitsTracker/games.php'>Games</a>";
        }
        if ($signedInUser->username == "PamJenner" || $signedInUser->username == "WebExtension") {
            echo "<a href='../../ParkVisitsTracker/recipes.php'>Recipes</a>";
        }
        if ($signedInUser->username == "KeithJenner" || $signedInUser->username == "WebExtension") {
            echo "<a href='../../ParkVisitsTracker/concerts.php'>Concerts</a>";
        }
        ?>
    </div>
</header>