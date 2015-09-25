<li>
    <p><?php echo $issue->getMessage(); ?></p>
    <pre class="code-block prettyprint linenums:<?php echo $issue->startingLine() ?> lang-php">
        <code><?php echo $issue->getCodePart() ?></code>
    </pre>
</li>
