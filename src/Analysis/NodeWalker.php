<?php

namespace Inspector\Analysis;

use Inspector\Analysis\Exception\AnalysisException;
use PhpParser\Node;

class NodeWalker
{

    /**
     * @param Node[]|null $ast
     * @param callable $callback
     * @return array
     */
    public function walk($ast, callable $callback)
    {
        if (empty($ast)) {
            return [];
        }

        if ($ast instanceof Node) {
            $ast = [$ast];
        }

        $errors = [];
        foreach ($ast as $node) {
            if (!($node instanceof Node)) {
                continue;
            }

            try {
                $callback($node);
            } catch (AnalysisException $e) {
                $errors[] = $e;
            }

            foreach ($node->getSubNodeNames() as $subNodeName) {
                $subNode = $node->{$subNodeName};

                if ($subNode instanceof Node) {
                    $subNode = [$subNode];
                }

                if (is_array($subNode)) {
                    $moreErrors = $this->walk($subNode, $callback);
                    $errors = array_merge($errors, $moreErrors);
                }
            }
        }

        return $errors;
    }
}
