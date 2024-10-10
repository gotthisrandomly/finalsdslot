<?php
require_once '../includes/functions.php';
require_once '../includes/validation.php';

session_start();

if (is_logged_in()) {
    header('Location: /');
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'])) {
        $errors[] = "Invalid CSRF token";
    } else {
        $username = sanitize_input($_POST['username']);
        $password = $_POST['password'];

        if (empty($username) || empty($password)) {
            $errors[] = "Username and password are required.";
        } else {
            if (login_user($username, $password)) {
                header('Location: /');
                exit;
            } else {
                $errors[] = "Invalid username or password.";
            }
        }
    }
}

$csrf_token = generate_csrf_token();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SD777Slots</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 20px; }
        .container { max-width: 400px; margin: 0 auto; }
        .error { color: red; }
        .success { color: green; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <?php
        if (!empty($errors)) {
            echo "<ul class='error'>";
            foreach ($errors as $error) {
                echo "<li>$error</li>";
            }
            echo "</ul>";
        }
        if (isset($_SESSION['success_message'])) {
            echo "<p class='success'>" . $_SESSION['success_message'] . "</p>";
            unset($_SESSION['success_message']);
        }
        ?>
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br>
            
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="/signup">Sign up</a></p>
    </div>
</body>
</html>