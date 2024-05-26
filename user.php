<?php
include_once("includes/setup.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User</title>
</head>
<body>
    <?php
    include_once("includes/header.php");
    $username = $_GET['username'];
    $query = $mysqli->query("SELECT * FROM users WHERE username = '$username'");
    echo $query->fetch_object()->email;
    ?>
</body>
</html>