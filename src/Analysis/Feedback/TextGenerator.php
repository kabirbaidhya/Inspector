<?php

namespace Inspector\Analysis\Feedback;

use Inspector\Analysis\Output\GeneratorInterface;

/**
 * @author Kabir Baidhya
 */
class TextGenerator implements GeneratorInterface
{


    /**
     * Generates the feedback.
     *
     * @param array $feedback List of the error messages
     * @return string
     */
    public function generate(array $feedback)
    {
        foreach ($feedback as $filename => $messages) {
            dump('File: ' . $filename);
            $index = 1;
            foreach ($messages as $message) {
                $identifier = str_replace('Exception', '', get_class($message));
                $identifier = str_replace('Inspector\\Analysis\\\\', '', $identifier);
                $node = $message->getNode();
                $startLine = $node->getAttribute('startLine');
                $endLine = $node->getAttribute('endLine');

                $lineInfo = ($startLine == $endLine) ? ' at line ' . $startLine : ' from line ' . $startLine . ' to ' . $endLine;
                printf("Issue %d: %s %s\n", $index, $identifier, $lineInfo);
                $index++;
            }
            if (empty($messages)) {
                dump('Code is okay.');
            }
        }

    }
}
