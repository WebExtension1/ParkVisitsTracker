<header>
    <div id="banner">
        <a href='../../../../../' id="site-name">webextension</h1>
        <a href='../../../../../login' id="logout">Logout</a>
    </div>
    <div id="sub-header">
        <div id="nav">
            <?php
            if (isset($signedInUser)) {
                echo "<a href='../../../../../'>Home</a><a href='../..//discography.php'>Discographies</a>";
                if ($signedInUser->username == "WebExtension") {
                    echo "<a href='../../../../../rides.php'>Rides</a>";
                }
                if ($signedInUser->username == "ImKelton" || $signedInUser->username == "WebExtension") {
                    echo "<a href='../../../../../games.php'>Games</a>";
                }
                if ($signedInUser->username == "KeithJenner" || $signedInUser->username == "WebExtension") {
                    echo "<a href='../../../../../concerts.php'>Concerts</a>";
                }
                if ($signedInUser->username == "ImKelton" || $signedInUser->username == "WebExtension") {
                    echo "<a href='../../../../../humanity.php'>Cards</a>";
                }
                if ($signedInUser->username == "KathThornton" || $signedInUser->username == "WebExtension") {
                    echo "<a href='../../../../../invoices.php'>Invoices</a>";
                }
            }
            $location = basename($_SERVER['SCRIPT_FILENAME']);
            // Public Files:
            // index.php
            // login.php
            // signup.php
            $return = false;
            if (($location == "edit-game.php" || $location == "game.php" || $location == "new-game.php" || $location == "remove-game.php" || "wishligh-game.php") && ($signedInUser->username != "WebExtension" && $signedInUser != "ImKelton")) {
                $return = true;
            }
            if (($location == "humanity.php") && ($signedInUser != "WebExtension" && $signedInUser != "ImKelton")) {
                $return = true;
            }
            if (($location == "invoices.php") && ($signedInUser != "WebExtension" && $signedInUser != "KathThornton")) {
                $return = true;
            }
            if (($location == "rides.php") && ($signedInUser != "WebExtension")) {
                $return = true;
            }
            if (($location == "user.php") && ($signedInUser != "WebExtension")) {
                $return = true;
            }
            if ($return == true) {
                header("../../../../../");
            }
            ?>
        </div>
    </div>
</header>