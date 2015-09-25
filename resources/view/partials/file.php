<li data-filename="<?php echo $file->getFilename() ?>"
    data-has-issues="<?php echo $file->isOkay() ? 'false' : 'true'; ?>">
    <h4 id="file<?php echo $fileNumber ?>">
        <a href="#file<?php echo $fileNumber ?>">
            <span class="number"><?php printf('#%d', $fileNumber) ?>.</span>
            <span class="filename"><?php echo highlight_filename($file->getRelativeFilename($analyzedPath)) ?></span>
        </a>
        <span class="quality quality-a"><?php echo $file->getQualityRating() ?></span>
    </h4>
    <?php include __DIR__ . '/issue-list.php' ?>
</li>
