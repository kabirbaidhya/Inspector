<ul class="file-list list-unstyled">
    <?php
    $fileNumber = 1;
    foreach ($analysis->getFiles() as $index => $file) {
        require __DIR__ . '/file.php';

        $fileNumber++;
    }
    ?>
</ul>
