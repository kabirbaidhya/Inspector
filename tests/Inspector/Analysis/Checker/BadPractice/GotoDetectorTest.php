<?php

namespace Inspector\Test\Analysis\Checker\BadPractice;

use PhpParser\Node;
use Inspector\Test\TestCase;
use Inspector\Analysis\Checker\BadPractice\GotoDetector;
use Inspector\Analysis\Exception\GotoDetectedException;

class GotoDetectorTest extends TestCase
{

    /**
     * @var GotoDetector
     */
    protected $checker;

    protected function _before()
    {
        $this->checker = new GotoDetector();
    }

    public function testGotoDetectorDoestntDoAnythingForNormalNode()
    {
        $node = $this->getMock(Node::class);
        $this->checker->check($node);
    }

    public function testGotoDetectorThrowsExceptionIfGotoNode()
    {
        $this->setExpectedException(GotoDetectedException::class);
        $this->checker->check(new Node\Stmt\Goto_('abc'));
    }

}
