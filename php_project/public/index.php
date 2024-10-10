<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

// Router
$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/':
        require __DIR__ . '/views/home.php';
        break;
    case '/login':
        require __DIR__ . '/views/login.php';
        break;
    case '/signup':
        require __DIR__ . '/views/signup.php';
        break;
    case '/admin':
        require __DIR__ . '/views/admin.php';
        break;
    case '/slot-machine':
        require __DIR__ . '/views/slot-machine.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;
}
