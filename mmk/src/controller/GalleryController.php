<?php
require_once 'C:\OSPanel\domains\mmk\src\model\GalleryModel.php';

class GalleryController{
    public static function showGallery() {
        $images = GalleryModel::getAllImages();
        include '../view/gallery.php';
    }
    public static function likeImages($image_id, $user_id) {
        if (GalleryModel::likeImage($image_id, $user_id)){
            echo "Image liked succes";
        }else{
            echo "Faild liked";
        }
    }
    public static function addComment($image_id, $user_id, $comment) {
        if(GalleryModel::addComment($image_id, $user_id, $comment)){
            echo "Comment added"
        }else{
            echo "Comment faild";
        }
    }

}