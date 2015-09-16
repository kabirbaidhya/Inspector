<?php

namespace Analyzer\Test;

use PhpParser\Node;
use Analyzer\Analysis\FlawDetection\GotoDetector;
use Analyzer\Analysis\Exception\GotoDetectedException;

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
