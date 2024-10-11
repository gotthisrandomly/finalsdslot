<?php
require_once '../includes/functions.php';
require_once '../includes/blackjack.php';
require_once '../includes/validation.php';

session_start();

if (!is_logged_in()) {
    header('Location: /login');
    exit;
}

$user_id = $_SESSION['user_id'];
$balance = get_user_balance($user_id);

$result = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'])) {
        $error = "Invalid CSRF token";
    } else {
        $bet_amount = floatval($_POST['bet_amount']);
        $bet_error = validate_bet_amount($bet_amount, $balance);
        
        if ($bet_error) {
            $error = $bet_error;
        } else {
            $result = play_blackjack($user_id, $bet_amount);
            $balance = get_user_balance($user_id); // Update balance after the game
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
    <title>Blackjack - SD777Slots</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        .card { display: inline-block; width: 80px; height: 120px; border: 1px solid #000; border-radius: 5px; margin: 5px; padding: 5px; text-align: center; }
        .error { color: red; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Blackjack</h1>
        <p>Your balance: $<?php echo number_format($balance, 2); ?></p>
        
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        
        <?php if ($result): ?>
            <h2><?php echo $result['message']; ?></h2>
            
            <h3>Your Hand:</h3>
            <div class="hand">
                <?php foreach ($result['player_hand'] as $card): ?>
                    <div class="card">
                        <?php echo $card['value'] . ' of ' . $card['suit']; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <h3>Dealer's Hand:</h3>
            <div class="hand">
                <?php foreach ($result['dealer_hand'] as $card): ?>
                    <div class="card">
                        <?php echo $card['value'] . ' of ' . $card['suit']; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <?php if ($result['result'] == 'win'): ?>
                <p>You won $<?php echo number_format($result['winnings'], 2); ?>!</p>
            <?php elseif ($result['result'] == 'push'): ?>
                <p>Your bet of $<?php echo number_format($result['winnings'], 2); ?> has been returned.</p>
            <?php endif; ?>
        <?php endif; ?>
        
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
            <label for="bet_amount">Bet Amount:</label>
            <input type="number" id="bet_amount" name="bet_amount" step="0.01" min="1" max="<?php echo $balance; ?>" required><br>
            
            <button type="submit">Play Blackjack</button>
        </form>
        
        <p><a href="/">Back to Home</a></p>
    </div>
</body>
</html>