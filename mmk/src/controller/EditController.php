<?php
require_once '../model/EditModel.php';

class EditController {
    public static function displayEditor() {
        $overlays = EditModel::getOverlays();
        include '../view/editor.php';
    }

    public static function saveImage() {
        $user_id = $_SESSION['user_id'];
        $overlay = $_POST['overlay'];
        $imageData = $_POST['imageData'] ?? null;
        $fileInput = $_FILES['fileInput'] ?? null;
    
        if ($imageData) {
            // Збереження знімка з веб-камери
            if (EditModel::saveSnapshot($user_id, $imageData, $overlay)) {
                echo "Snapshot saved successfully.";
            } else {
                echo "Failed to save the snapshot.";
            }
        } elseif ($fileInput && $fileInput['error'] == UPLOAD_ERR_OK) {
            // Збереження завантаженого файлу
            if (EditModel::saveUploadedFile($user_id, $fileInput['tmp_name'], $overlay)) {
                echo "File uploaded successfully.";
            } else {
                echo "Failed to upload file.";
            }
        } else {
            echo "No valid data provided.";
        }
    }
    
}
