<?php foreach ($images as $image): ?>
    <div>
        <img src="<?php echo $image['image_path']; ?>" alt="User Image">
        <p>Uploaded on: <?php echo $image['creation_date']; ?></p>
        <!-- Лайки та коментарі можуть бути додані тут -->
    </div>
<?php endforeach; ?>
