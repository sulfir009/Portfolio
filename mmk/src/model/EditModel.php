<?php
require_once '../config/database.php';

class EditModel {
    public static function getOverlays() {
        $overlayDir = '../overlays'; // Вкажіть вірний шлях до папки з накладними зображеннями
        $files = scandir($overlayDir);
        
        // Фільтрація, щоб повернути лише файли зображень
        return array_filter($files, function($file) use ($overlayDir) {
            return is_file($overlayDir . '/' . $file) && in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['png', 'jpg', 'jpeg']);
        });
    }

    public static function saveImage($user_id, $image_data) {
        try {
            $pdo = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWORD']);
            $stmt = $pdo->prepare("INSERT INTO images (user_id, image_path) VALUES (?, ?)");
            $stmt->execute([$user_id, $image_data]);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
    public static function saveSnapshot($user_id, $imageData, $overlay) {
        try {
            $pdo = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWORD']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // Видалення заголовка Data URL і декодування зображення
            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
    
            // Завантаження зображення
            $src = imagecreatefromstring($imageData);
            if (!$src) {
                return false; // Не вдалось обробити зображення
            }
    
            // Застосування накладення, якщо необхідно
            if ($overlay) {
                $overlayPath = '../overlays/' . $overlay;
                if (file_exists($overlayPath)) {
                    $overlayImg = imagecreatefrompng($overlayPath);
                    imagecopy($src, $overlayImg, 0, 0, 0, 0, imagesx($overlayImg), imagesy($overlayImg));
                    imagedestroy($overlayImg);
                }
            }
    
            // Збереження зображення
            $savePath = '../uploads/' . uniqid($user_id . '_') . '.png';
            imagepng($src, $savePath);
            imagedestroy($src);
    
            // Додавання шляху до зображення у базу даних
            $stmt = $pdo->prepare("INSERT INTO images (user_id, image_path) VALUES (?, ?)");
            $stmt->execute([$user_id, $savePath]);
    
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    
    public static function saveUploadedFile($user_id, $filePath, $overlay) {
        try {
            $pdo = new PDO($GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWORD']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            // Завантаження зображення з файлу
            $src = imagecreatefromstring(file_get_contents($filePath));
            if (!$src) {
                return false; // Не вдалось обробити зображення
            }
    
            // Застосування накладення, якщо воно є
            if ($overlay) {
                $overlayPath = '../overlays/' . $overlay;
                if (file_exists($overlayPath)) {
                    $overlayImg = imagecreatefrompng($overlayPath);
                    imagecopy($src, $overlayImg, 0, 0, 0, 0, imagesx($overlayImg), imagesy($overlayImg));
                    imagedestroy($overlayImg);
                }
            }
    
            // Збереження зображення
            $savePath = '../uploads/' . uniqid($user_id . '_') . '.png';
            imagepng($src, $savePath);
            imagedestroy($src);
    
            // Додавання шляху до зображення у базу даних
            $stmt = $pdo->prepare("INSERT INTO images (user_id, image_path) VALUES (?, ?)");
            $stmt->execute([$user_id, $savePath]);
    
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    
    public static function applyOverlay($baseImage, $overlayImage) {
        // Завантаження основного зображення
        $src = imagecreatefromstring(base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $baseImage)));
    
        // Завантаження накладного зображення
        $overlay = imagecreatefrompng($overlayImage);
    
        // Накладення зображення
        imagecopy($src, $overlay, 0, 0, 0, 0, imagesx($overlay), imagesy($overlay));
    
        // Збереження результату
        ob_start();
        imagepng($src);
        $finalImage = ob_get_clean();
    
        return $finalImage;
    }
    
}
