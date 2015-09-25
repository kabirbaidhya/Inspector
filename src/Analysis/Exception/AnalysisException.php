<?php

namespace Inspector\Analysis\Exception;

use PhpParser\Node;
use Inspector\Application\Exception\Exception;

class AnalysisException extends Exception
{

    /**
     * @var Node
     */
    protected $node;

    /**
     * @return Node
     */
    public function getNode()
    {
        return $this->node;
    }

    /**
     * @return int|array
     */
    public function getLineNumber()
    {
        $startLine = $this->node->getAttribute('startLine');
        $endLine = $this->node->getAttribute('endLine');

        return ($startLine === $endLine) ? $startLine : [$startLine, $endLine];
    }

    /**
     * @param Node $node
     * @return $this
     */
    public function setNode(Node $node)
    {
        $this->node = $node;

        return $this;
    }

    /**
     * Returns a new Exception instance with node.
     *
     * @param Node $node
     * @return AnalysisException
     */
    public static function withNode(Node $node)
    {
        return (new static())->setNode($node);
    }

}
