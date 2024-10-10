<?php
require_once '../includes/functions.php';
require_once '../includes/roulette.php';

session_start();

if (!is_logged_in()) {
    header('Location: /login');
    exit;
}

$user_id = $_SESSION['user_id'];
$balance = get_user_balance($user_id);

$result = null;
$win_amount = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bet_amount = floatval($_POST['bet_amount']);
    $bet_type = $_POST['bet_type'];
    $bet_value = $_POST['bet_value'];

    if ($bet_amount > 0 && $bet_amount <= $balance) {
        $game_result = playRoulette($user_id, $bet_amount, $bet_type, $bet_value);
        $result = $game_result['result'];
        $win_amount = $game_result['win_amount'];
        $balance = get_user_balance($user_id); // Update balance after the game
    } else {
        $error = "Invalid bet amount";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roulette - SD777Slots</title>
</head>
<body>
    <h1>Roulette</h1>
    <p>Your balance: $<?php echo number_format($balance, 2); ?></p>
    
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    
    <?php if ($result !== null): ?>
        <h2>Result: <?php echo $result; ?></h2>
        <p>You <?php echo ($win_amount > 0) ? "won $" . number_format($win_amount, 2) : "lost"; ?></p>
    <?php endif; ?>
    
    <form method="POST">
        <label for="bet_amount">Bet Amount:</label>
        <input type="number" id="bet_amount" name="bet_amount" step="0.01" min="1" max="<?php echo $balance; ?>" required><br>
        
        <label for="bet_type">Bet Type:</label>
        <select id="bet_type" name="bet_type" required>
            <option value="number">Number</option>
            <option value="color">Color</option>
            <option value="even_odd">Even/Odd</option>
        </select><br>
        
        <label for="bet_value">Bet Value:</label>
        <input type="text" id="bet_value" name="bet_value" required><br>
        
        <button type="submit">Spin</button>
    </form>
    
    <p><a href="/">Back to Home</a></p>
</body>
</html>