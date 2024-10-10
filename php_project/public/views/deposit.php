<?php
require_once '../includes/functions.php';
require_once '../includes/cashapp.php';

session_start();

if (!is_logged_in()) {
    header('Location: /login');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = floatval($_POST['amount']);
    if ($amount > 0) {
        $payment_url = initiateCashAppPayment($amount);
        header("Location: $payment_url");
        exit;
    } else {
        $error = "Invalid amount";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deposit - SD777Slots</title>
</head>
<body>
    <h1>Deposit</h1>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form method="POST">
        <input type="number" name="amount" step="0.01" min="1" placeholder="Amount" required><br>
        <button type="submit">Deposit with CashApp</button>
    </form>
    <p><a href="/">Back to Home</a></p>
</body>
</html>