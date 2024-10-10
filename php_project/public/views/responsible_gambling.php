<?php
require_once '../includes/functions.php';
require_once '../includes/responsible_gambling.php';

session_start();

if (!is_logged_in()) {
    header('Location: /login');
    exit;
}

$user_id = $_SESSION['user_id'];
$deposit_limit = get_deposit_limit($user_id);
$self_exclusion = check_self_exclusion($user_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['set_deposit_limit'])) {
        $new_limit = floatval($_POST['deposit_limit']);
        set_deposit_limit($user_id, $new_limit);
        $deposit_limit = $new_limit;
    } elseif (isset($_POST['set_self_exclusion'])) {
        $duration = intval($_POST['self_exclusion_duration']);
        $end_date = date('Y-m-d H:i:s', strtotime("+$duration days"));
        set_self_exclusion($user_id, $end_date);
        $self_exclusion = $end_date;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsible Gambling - SD777Slots</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Responsible Gambling Settings</h1>
        
        <h2>Deposit Limit</h2>
        <p>Current deposit limit: $<?php echo $deposit_limit ? number_format($deposit_limit, 2) : 'Not set'; ?></p>
        <form method="POST">
            <label for="deposit_limit">Set new deposit limit (per 24 hours):</label>
            <input type="number" id="deposit_limit" name="deposit_limit" step="0.01" min="0" required>
            <button type="submit" name="set_deposit_limit">Set Limit</button>
        </form>

        <h2>Self-Exclusion</h2>
        <?php if ($self_exclusion): ?>
            <p>You are currently self-excluded until: <?php echo $self_exclusion; ?></p>
        <?php else: ?>
            <form method="POST">
                <label for="self_exclusion_duration">Set self-exclusion period (in days):</label>
                <input type="number" id="self_exclusion_duration" name="self_exclusion_duration" min="1" required>
                <button type="submit" name="set_self_exclusion">Set Self-Exclusion</button>
            </form>
        <?php endif; ?>

        <h2>Responsible Gambling Resources</h2>
        <ul>
            <li><a href="https://www.begambleaware.org/" target="_blank">BeGambleAware</a></li>
            <li><a href="https://www.gamcare.org.uk/" target="_blank">GamCare</a></li>
            <li><a href="https://www.gamblingtherapy.org/" target="_blank">Gambling Therapy</a></li>
        </ul>

        <p><a href="/">Back to Home</a></p>
    </div>
</body>
</html>