<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SD777Slots</title>
</head>
<body>
    <h1>Welcome to SD777Slots</h1>
    <?php if (is_logged_in()): ?>
        <p>Welcome, <?php echo $_SESSION['username']; ?>!</p>
        <p>Your balance: $<?php echo get_user_balance($_SESSION['user_id']); ?></p>
        <a href="/slot-machine">Play Slot Machine</a>
        <a href="/logout">Logout</a>
    <?php else: ?>
        <a href="/login">Login</a>
        <a href="/signup">Sign Up</a>
    <?php endif; ?>
</body>
</html>