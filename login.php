<?php
include_once("includes/setup.php");

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $userQuery = $mysqli->query("SELECT userID, password FROM users WHERE username = '$username'");
    $user = $userQuery->fetch_object();
    if (isset($user)) {
        if (password_verify($password, $user->password)) {
            $_SESSION['userID'] = $user->userID;
            header("Location: index.php");
        } else {
            $error = "Password is incorrect";
        }
    } else {
        $error = "Username not found";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <?php include_once("includes/header.php"); ?>
    <div class="login-container">
        <h1>Login</h1>
        <form method="post">
            <p>Username</p>
            <input type="text" name="username" required>
            <p>Password</p>
            <input type="password" name="password" required>
            <button name="login">Login</button>
        </form>
        <a href="">Forgotten Password?</a>
        <p>Not got an account? <a href="signup.php">Sign up here!</a></p>
        <?php if (isset($error)) { echo "<p>$error</p>"; } ?>
    </div>
    <?php include_once("includes/footer.php"); ?>
</body>
</html>