<?php
session_start();
require_once __DIR__ . '/../src/controller/userController.php';


// Визначаємо запитувану сторінку
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

// Керування сторінками
switch ($page) {
    case 'register':
        UserController::register();
        break;
    case 'login':
        UserController::login();
        break;
    case 'logout':
        UserController::logout();
        break;
    default:
        UserController::home();
        break;
}
