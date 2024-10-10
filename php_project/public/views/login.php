<?php
require_once '../includes/functions.php';
require_once '../includes/oauth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (login_user($username, $password)) {
        header('Location: /');
        exit;
    } else {
        $error = "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SD777Slots</title>
</head>
<body>
    <h1>Login</h1>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Login</button>
    </form>
    <h2>Or login with:</h2>
    <a href="<?php echo getOAuthLoginUrl('google'); ?>">Google</a><br>
    <a href="<?php echo getOAuthLoginUrl('facebook'); ?>">Facebook</a>
    <p>Don't have an account? <a href="/signup">Sign up</a></p>
</body>
</html>