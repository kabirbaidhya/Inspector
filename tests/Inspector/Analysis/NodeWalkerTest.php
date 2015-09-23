<?php

namespace Inspector\Test\Analysis;

use PhpParser\Node;
use Inspector\Test\TestCase;
use Inspector\Analysis\NodeWalker;
use Inspector\Analysis\Exception\AnalysisException;

class NodeWalkerTest extends TestCase
{

    /**
     * @dataProvider getTestFilesAndNodes
     * @param $filename
     * @param $expectedNodes
     */
    public function testWalkerWalksThroughEveryNodeRecursively($filename, $expectedNodes)
    {
        $ast = $this->parseSource(file_get_contents($filename));

        $result = [];
        $walker = new NodeWalker();
        $walker->walk($ast, function (Node $node) use (&$result) {
            $result[] = get_class($node);
        });

        $this->assertEquals($expectedNodes, $result);
    }

    public function testWalkerCapturesAllAnalysisExceptionsAndReturnsThem()
    {
        $ast = $this->parseSource(file_get_contents(STUBPATH . '/walk/class_2.php'));

        $walker = new NodeWalker();

        $errors = $walker->walk($ast, function (Node $node) {
            throw AnalysisException::withNode($node);
        });

        $this->assertCount(9, $errors);
        $this->assertArrayOf(AnalysisException::class, $errors);
    }

    public function getTestFilesAndNodes()
    {

        return [
            [
                STUBPATH . '/walk/class_1.php',
                [
                    'PhpParser\Node\Stmt\Namespace_',
                    'PhpParser\Node\Name',
                    'PhpParser\Node\Stmt\Class_',
                    'PhpParser\Node\Stmt\ClassMethod',
                    'PhpParser\Node\Stmt\If_',
                    'PhpParser\Node\Expr\BinaryOp\Identical',
                    'PhpParser\Node\Expr\Variable',
                    'PhpParser\Node\Scalar\LNumber',
                    'PhpParser\Node\Stmt\Foreach_',
                    'PhpParser\Node\Expr\Variable',
                    'PhpParser\Node\Expr\Variable',
                    'PhpParser\Node\Stmt\Foreach_',
                    'PhpParser\Node\Expr\Variable',
                    'PhpParser\Node\Expr\Variable',
                    'PhpParser\Node\Stmt\Foreach_',
                    'PhpParser\Node\Expr\Variable',
                    'PhpParser\Node\Expr\Variable',
                    'PhpParser\Node\Stmt\ElseIf_',
                    'PhpParser\Node\Expr\BinaryOp\Identical',
                    'PhpParser\Node\Expr\Variable',
                    'PhpParser\Node\Scalar\LNumber',
                ]
            ]
        ];
    }

}
