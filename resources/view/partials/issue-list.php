<?php if (!$file->isOkay()): ?>
    <ol class="issues">
        <?php
        foreach ($file->getIssues() as $issue) {
            include __DIR__ . '/issue.php';
        } ?>
    </ol>
<?php endif; ?>

