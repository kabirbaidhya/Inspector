<ul class="file-list list-unstyled">
    <?php
    foreach ($analysis->getFiles() as $file) {
        require __DIR__ . '/file.php';
    }
    ?>
</ul>
