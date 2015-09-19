<?php

namespace Inspector\Test;

use PhpParser\Node;
use Inspector\Analysis\FlawDetection\DieDetector;
use Inspector\Analysis\Exception\DieDetectedException;

class DieDetectorTest extends TestCase
{

    /**
     * @var DieDetector
     */
    protected $checker;

    protected function _before()
    {
        $this->checker = new DieDetector();
    }

    public function testDieDetectorThrowsExceptionForExitNode()
    {
        $this->setExpectedException(DieDetectedException::class);
        $this->checker->check(new Node\Expr\Exit_());
    }

    public function testDieDetectorDoesntDoAnythingForOtherNode()
    {
        $node = $this->getMock(Node::class);
        $this->checker->check($node);
    }

}
