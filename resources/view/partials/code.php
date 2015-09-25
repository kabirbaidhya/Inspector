<?php
echo
    '<pre class="code-block prettyprint linenums:' . $file->getIssueCodeStartLine($issue) . ' lang-php">' .
    '<code>' . $file->getCodeForIssue($issue) . '</code>' .
    '</pre>';

