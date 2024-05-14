<?php
require 'database.php';

try {
    // Створення підключення до бази даних
    $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Створення таблиць
    $queries = [
        "CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL UNIQUE,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            confirmed BOOLEAN DEFAULT FALSE
        )",
        "CREATE TABLE IF NOT EXISTS images (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            image_path VARCHAR(255) NOT NULL,
            creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )",
        "CREATE TABLE IF NOT EXISTS comments (
            id INT AUTO_INCREMENT PRIMARY KEY,
            image_id INT,
            user_id INT,
            comment TEXT,
            creation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )",
        "CREATE TABLE IF NOT EXISTS likes (
            id INT AUTO_INCREMENT PRIMARY KEY,
            image_id INT,
            user_id INT
        )"
    ];

    foreach ($queries as $query) {
        $pdo->exec($query);
    }
    echo "Database and tables created successfully.";
} catch (PDOException $e) {
    die("DB ERROR: " . $e->getMessage());
}
