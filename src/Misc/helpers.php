<?php

function highlight_filename($path)
{
    $basename = basename($path);
    $format = '<span class="highlight">%s</span>';

    return str_replace($basename, sprintf($format, $basename), $path);
}
