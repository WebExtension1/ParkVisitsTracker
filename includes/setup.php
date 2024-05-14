<?php
session_start();
// Establishs database connection.
$mysqli = new mysqli("127.0.0.1", "root", "", "website");

/*
// Redirects to login if not signed in.
$currentPage = basename($_SERVER['PHP_SELF']);
if ($currentPage != "login.php" && $currentPage != "signup.php") {  //List of pages that are exempt
    if (isset($_SESSION['userID'])) {
        $signedInUser = $mysqli->query("SELECT * FROM users WHERE userID = " . $_SESSION['userID'])->fetch_object();
    } else {
        header("Location: ../../../webextension.info/login");
    }
}
*/

if (str_contains($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], "index.php")) {
    $newURL = str_replace("index.php", "", $_SERVER['REQUEST_URI']);
    header("Location: $newURL");
} else if (str_contains($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], ".php")) {
    $newURL = str_replace(".php", "", $_SERVER['REQUEST_URI']);
    header("Location: $newURL");
}
?>