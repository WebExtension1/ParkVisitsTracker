<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$localhost = false;
if (gethostname() == "RobsPC" || gethostname() == "RobsLaptop") {
    $localhost = true;
}

// Establishs database connection.
if ($localhost) {
    $host_name = '127.0.0.1';
    $database = 'website';
    $user_name = 'root';
    $password = '';

    $mysqli = new mysqli($host_name, $user_name, $password, $database);
} else {
    $host_name = 'db5016240611.hosting-data.io';
    $database = 'dbs13218947';
    $user_name = 'dbu537197';
    $password = '4qginJK6bMRSv3s';
  
    $mysqli = new mysqli($host_name, $user_name, $password, $database);
}

$directoryString = "../../../../";
if ($localhost) {
    $directoryString .= "ParkVisitsTracker/";
}

if ($mysqli->connect_error) {
    die('<p>Failed to connect to MySQL: '. $mysqli->connect_error .'</p>');
} else {
    $currentPage = basename($_SERVER['PHP_SELF']);
    if (str_contains($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], "index.php")) {
        $newURL = str_replace("index.php", "", $_SERVER['REQUEST_URI']);
        header("Location: $newURL");
    } else if (str_contains($_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], ".php")) {
        $newURL = str_replace(".php", "", $_SERVER['REQUEST_URI']);
        header("Location: $newURL");
    }

    // Redirects to login if not signed in.
    if (isset($_SESSION['userID'])) {  //List of pages that are exempt
        $signedInUser = $mysqli->query("SELECT * FROM Users WHERE userID = " . $_SESSION['userID'])->fetch_object();
    } else if ($currentPage != "index.php" && $currentPage != "login.php" && $currentPage != "signup.php") {
        header("Location: index.php");
    }
}
?>