<?php if (!$file->isOkay()): ?>
    <ol class="issues">
        <?php foreach ($file->getIssues() as $issue): ?>
            <li>
                <p><?php echo $issue->getMessage(); ?></p>
                <?php require 'code.php' ?>
            </li>
        <?php endforeach; ?>
    </ol>
<?php endif; ?>

