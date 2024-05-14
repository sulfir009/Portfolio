<?php
require_once '../config/database.php';

class UserModel {
    public static function register($username, $email, $password) {
        try {
            $pdo = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWORD']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // Перевірка наявності електронної пошти або імені користувача
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            if ($stmt->rowCount() > 0) {
                return false; // Користувач уже існує
            }
    
            // Хешування паролю
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
            // Додавання користувача до бази даних
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, confirmed) VALUES (?, ?, ?, 1)");
            $stmt->execute([$username, $email, $hashedPassword]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    public static function login($username, $password) {
        try {
            $pdo = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWORD']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($user && password_verify($password, $user['password'])) {
                return $user; // Авторизація пройшла успішно
            } else {
                return false; // Невірні дані
            }
        } catch (PDOException $e) {
            return false;
        }
    }
    
}
