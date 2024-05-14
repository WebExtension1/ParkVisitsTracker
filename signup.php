<?php
include_once("includes/setup.php");

if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConfirm = $_POST['passwordConfirm'];

    $errors = array();

    $usernameQuery = $mysqli->query("SELECT * FROM users WHERE username = '$username'");
    if (mysqli_num_rows($usernameQuery) > 0) {
        array_push($errors, "Username is taken.");
    }

    $emailQuery = $mysqli->query("SELECT * FROM users WHERE email = '$email'");
    if (mysqli_num_rows($emailQuery) > 0) {
        array_push($errors, "Email is taken.");
    }

    if (strlen($password) < 8 || strlen($password) < 8) {
        array_push($errors, "Passwords must be at least 8 characters.");
    }

    if ($password != $passwordConfirm) {
        array_push($errors, "Passwords don't match.");
    }

    if (count($errors) == 0) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $newUserQuery = $mysqli->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $newUserQuery->bind_param("sss", $username, $email, $passwordHash);
        $newUserQuery->execute();
        $_SESSION['userID'] = $newUserQuery->insert_id;
        header("Location: ../../webextension.info");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
</head>
<body>
    <?php include_once("includes/header.php"); ?>
    <div class="signup-container">
        <h1>Create your account</h1>
        <form method="post">
            <p>Username</p>
            <input type="text" name="username" required>
            <p>Email</p>
            <input type="email" name="email" required>
            <p>Password</p>
            <input type="password" name="password" required>
            <p>Password</p>
            <input type="password" name="passwordConfirm" required>
            <button name="signup">Create Account</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here!</a></p>
    </div>
    <?php include_once("includes/footer.php"); ?>
</body>
</html>