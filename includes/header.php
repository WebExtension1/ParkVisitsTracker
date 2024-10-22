<header>
    <?php
        $location = basename($_SERVER['SCRIPT_FILENAME']);
        if ($location != "portfolio.php") {
    ?>
    <div id="banner">
        <a href='<?php echo $directoryString; ?>' id="site-name">webextension</a>
        <a href='<?php echo $directoryString; ?>login' id="logout">Logout</a>
    </div>
    <div id="sub-header">
        <div id="nav">
            <?php
            if (isset($signedInUser) && $location != "portfolio.php") {
                echo "<a href='$directoryString'>Home</a><a href='{$directoryString}discography.php'>Discographies</a>";
                if ($signedInUser->username == "WebExtension") {
                    echo "<a href='{$directoryString}rides.php'>Rides</a>";
                }
                if ($signedInUser->username == "ImKelton" || $signedInUser->username == "WebExtension") {
                    echo "<a href='{$directoryString}games.php'>Games</a>";
                }
                if ($signedInUser->username == "KeithJenner" || $signedInUser->username == "WebExtension") {
                    echo "<a href='{$directoryString}concerts.php'>Concerts</a>";
                }
                if ($signedInUser->username == "ImKelton" || $signedInUser->username == "WebExtension") {
                    echo "<a href='{$directoryString}humanity.php'>Cards</a>";
                }
            }
            $return = true;
            if ($location == "discography.php" || $location == "index.php" || $location == "portfolio.php") {
                $return = false;
            }
            if (($location == "rides.php") && ($signedInUser->username == "WebExtension")) {
                $return = false;
            }
            if (($location == "edit-game.php" || $location == "game-file.php" || $location == "new-game-file.php" || $location == "remove-game.php" || $location == "wishligh-game.php") && ($signedInUser->username == "WebExtension" || $signedInUser->username == "ImKelton")) {
                $return = false;
            }
            if (($location == "concerts.php") && ($signedInUser->username == "WebExtension" || $signedInUser->username == "KeithJenner")) {
                $return = false;
            }
            if (($location == "humanity.php") && ($signedInUser->username == "WebExtension" || $signedInUser->username == "ImKelton")) {
                $return = false;
            }
            if (($location == "user.php") && ($signedInUser->username == "WebExtension")) {
                $return = false;
            }
            if ($return == true) {
                echo "<p>Error loading resource, you don't have access to this page.</p>";
                exit();
            }
            ?>
        </div>
    </div>
    <?php } ?>
</header>