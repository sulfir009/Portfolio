<?php
require_once 'C:\OSPanel\domains\mmk\config\database.php';

class GalleryModel {
    public static function getAllImages() {
        try {
            $pdo = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWORD']);
            $stmt = $pdo->query("SELECT * FROM images ORDER BY creation_date DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public static function likeImage($image_id, $user_id) {
        try {
            $pdo = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWORD']);
            $stmt = $pdo->prepare("INSERT INTO likes (image_id, user_id) VALUES (?, ?)");
            $stmt->execute([$image_id, $user_id]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public static function addComment($image_id, $user_id, $comment) {
        try {
            $pdo = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWORD']);
            $stmt = $pdo->prepare("INSERT INTO comments (image_id, user_id, comment) VALUES (?, ?, ?)");
            $stmt->execute([$image_id, $user_id, $comment]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
