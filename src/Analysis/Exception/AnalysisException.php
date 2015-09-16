<?php

namespace Analyzer\Analysis\Exception;

use Analyzer\Application\Exception\Exception;
use PhpParser\Node;

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
     * @param Node $node
     * @return $this
     */
    public function setNode(Node $node)
    {
        $this->node = $node;

        return $this;
    }

}
