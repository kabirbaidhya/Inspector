<header class="page-header">
    <h1>Inspector Analysis Report</h1>

    <p class="bg-success">
        Inspection of <span class="text-primary"><?php echo $analyzedPath ?></span>
    </p>

    <ul class="highlights list-unstyled clearfix">
        <li class="rating clearfix">
            Code Rating
            <span class="badge" title="<?php echo $analysis->getRatingDescription() ?>">
                <?php echo $analysis->getCodeRating() ?>
            </span>
            <span class="label label-primary"><?php echo $analysis->getRatingText() ?></span>
        </li>
        <li>Files Scanned <span class="badge"><?php echo $analysis->countFiles() ?></span></li>
        <li>Issues <span class="badge"><?php echo $analysis->countIssues() ?></span></li>
    </ul>
</header>
