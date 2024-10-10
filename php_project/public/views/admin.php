<?php
require_once '../includes/functions.php';

session_start();

if (!is_logged_in() || !is_admin()) {
    header('Location: /login');
    exit;
}

function is_admin() {
    global $pdo;
    $stmt = $pdo->prepare("SELECT is_admin FROM users WHERE id = :user_id");
    $stmt->execute(['user_id' => $_SESSION['user_id']]);
    $result = $stmt->fetch();
    return $result && $result['is_admin'];
}

function get_all_users() {
    global $pdo;
    $stmt = $pdo->query("SELECT id, username, balance, is_admin FROM users");
    return $stmt->fetchAll();
}

function get_recent_transactions($limit = 20) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT t.*, u.username FROM transactions t JOIN users u ON t.user_id = u.id ORDER BY t.created_at DESC LIMIT :limit");
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

$users = get_all_users();
$transactions = get_recent_transactions();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - SD777Slots</title>
</head>
<body>
    <h1>Admin Panel</h1>
    
    <h2>Users</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Balance</th>
            <th>Admin</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?php echo $user['id']; ?></td>
            <td><?php echo htmlspecialchars($user['username']); ?></td>
            <td>$<?php echo number_format($user['balance'], 2); ?></td>
            <td><?php echo $user['is_admin'] ? 'Yes' : 'No'; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    
    <h2>Recent Transactions</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Amount</th>
            <th>Type</th>
            <th>Date</th>
        </tr>
        <?php foreach ($transactions as $transaction): ?>
        <tr>
            <td><?php echo $transaction['id']; ?></td>
            <td><?php echo htmlspecialchars($transaction['username']); ?></td>
            <td>$<?php echo number_format($transaction['amount'], 2); ?></td>
            <td><?php echo $transaction['type']; ?></td>
            <td><?php echo $transaction['created_at']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    
    <p><a href="/">Back to Home</a></p>
</body>
</html>