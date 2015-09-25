<li>
    <h4 id="file1">
        <a href="#file1">
            <span class="number"><?php printf('#%d', $fileNumber) ?>.</span>
            <span class="filename"><?php echo $file->getFilename() ?></span></a>
        <span class="quality quality-a"><?php echo $file->getQualityRating() ?></span>
    </h4>
    <?php include __DIR__ . '/issue-list.php' ?>
</li>
