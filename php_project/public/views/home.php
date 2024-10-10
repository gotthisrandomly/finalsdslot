<?php
require_once '../includes/functions.php';

session_start();

$is_logged_in = is_logged_in();
$is_admin = $is_logged_in && is_admin();

if ($is_logged_in) {
    $user_id = $_SESSION['user_id'];
    $balance = get_user_balance($user_id);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SD777Slots - Home</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        .nav { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .nav a { text-decoration: none; color: #333; padding: 5px 10px; }
        .nav a:hover { background-color: #f4f4f4; }
        .games { display: flex; justify-content: space-around; margin-top: 20px; }
        .game-link { text-decoration: none; color: #fff; background-color: #007bff; padding: 10px 20px; border-radius: 5px; }
        .game-link:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <div class="nav">
            <h1>SD777Slots</h1>
            <?php if ($is_logged_in): ?>
                <div>
                    <span>Balance: $<?php echo number_format($balance, 2); ?></span>
                    <a href="/deposit">Deposit</a>
                    <?php if ($is_admin): ?>
                        <a href="/admin">Admin Panel</a>
                    <?php endif; ?>
                    <a href="/logout">Logout</a>
                </div>
            <?php else: ?>
                <div>
                    <a href="/login">Login</a>
                    <a href="/signup">Sign Up</a>
                </div>
            <?php endif; ?>
        </div>

        <h2>Welcome to SD777Slots</h2>
        
        <?php if ($is_logged_in): ?>
            <p>Ready to play? Choose a game below:</p>
            <div class="games">
                <a href="/slot-machine" class="game-link">Slot Machine</a>
                <a href="/roulette" class="game-link">Roulette</a>
            </div>
        <?php else: ?>
            <p>Please log in or sign up to start playing!</p>
        <?php endif; ?>
    </div>
</body>
</html>