<?php
// This is a very basic OAuth implementation and should not be used in production without proper security measures

function generateOAuthState() {
    return bin2hex(random_bytes(16));
}

function getOAuthLoginUrl($provider) {
    $state = generateOAuthState();
    $_SESSION['oauth_state'] = $state;
    
    // Replace these with actual OAuth provider details
    $client_id = 'your_client_id';
    $redirect_uri = 'https://enginelabs-2wc78kcc.fly.dev/oauth_callback.php';
    
    if ($provider === 'google') {
        return "https://accounts.google.com/o/oauth2/v2/auth?response_type=code&client_id={$client_id}&redirect_uri={$redirect_uri}&scope=openid%20email&state={$state}";
    } elseif ($provider === 'facebook') {
        return "https://www.facebook.com/v11.0/dialog/oauth?client_id={$client_id}&redirect_uri={$redirect_uri}&state={$state}&scope=email";
    }
}

function handleOAuthCallback($provider) {
    if (!isset($_GET['state']) || $_GET['state'] !== $_SESSION['oauth_state']) {
        return false;
    }
    
    if (!isset($_GET['code'])) {
        return false;
    }
    
    $code = $_GET['code'];
    
    // Exchange code for token (this would typically involve making an API call to the OAuth provider)
    // For demonstration purposes, we'll just assume it's successful
    $user_info = getOAuthUserInfo($provider, $code);
    
    if ($user_info) {
        // Check if user exists, if not, create a new user
        $user_id = getUserByEmail($user_info['email']);
        if (!$user_id) {
            $user_id = createUserFromOAuth($user_info);
        }
        
        // Log the user in
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $user_info['name'];
        return true;
    }
    
    return false;
}

function getOAuthUserInfo($provider, $code) {
    // In a real implementation, this would make API calls to the OAuth provider
    // For demonstration, we'll return mock data
    return [
        'email' => 'user@example.com',
        'name' => 'John Doe',
    ];
}

function getUserByEmail($email) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :email");
    $stmt->execute(['email' => $email]);
    $result = $stmt->fetch();
    return $result ? $result['id'] : null;
}

function createUserFromOAuth($user_info) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
    $stmt->execute([
        'username' => $user_info['email'],
        'password' => password_hash(bin2hex(random_bytes(16)), PASSWORD_DEFAULT), // Random password
    ]);
    return $pdo->lastInsertId();
}