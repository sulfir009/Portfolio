<?php
require_once 'C:\OSPanel\domains\mmk\src\model\userModel.php';

class UserController {
    public static function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
    
            if (UserModel::register($username, $email, $password)) {
                echo "Registration successful. You can now login.";
            } else {
                echo "Registration failed. User might already exist or there was an error.";
            }
        } else {
            // Показати форму реєстрації
            include '../view/register.php';
        }
    }
    
    public static function home() {
        include '../view/home.php';
    }
    

    public static function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
    
            if ($user = UserModel::login($username, $password)) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                // Перенаправлення до галереї
                header("Location: /path_to_gallery.php"); // Оновіть шлях до вашої сторінки галереї
                exit;
            } else {
                echo "Login failed. Please check your username and password.";
            }
        } else {
            include '../view/login.php';
        }
    }
    
    
    public static function logout() {
        session_unset();
        session_destroy();
        echo "You have been logged out.";
    }
    
}
