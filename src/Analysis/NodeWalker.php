<?php

namespace Inspector\Analysis;

use PhpParser\Node;
use Inspector\Analysis\Exception\AnalysisException;

/**
 * Walks/Traverses through each Node in a Abstract Syntax Tree recursively
 * triggering a callback for each node.
 */
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

        // Ensure that it is an array of nodes
        $ast = $this->ensureArray($ast);

        $errors = [];

        $this->foreachNode($ast, function (Node $node) use (&$errors, $callback) {

            $errors = array_merge($errors, $this->triggerCallback($callback, $node));

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
        });

        return $errors;
    }

    /**
     * Triggers the callback for the walker and catches errors
     *
     * @param callable $callback
     * @param $node
     * @return array
     */
    protected function triggerCallback(callable $callback, Node $node)
    {
        $errors = [];
        try {
            $callback($node);
        } catch (AnalysisException $e) {
            $errors[] = $e;
        }

        return $errors;
    }

    /**
     * @param $ast
     * @return array
     */
    protected function ensureArray($ast)
    {
        return ($ast instanceof Node) ? [$ast] : $ast;
    }

    /**
     * Loops through the AST for each Node (linearly) and triggers the callback for it.
     *
     * @param Node[]|null $ast
     * @param callable $callback
     */
    protected function foreachNode($ast, callable $callback)
    {
        foreach ($ast as $node) {
            if (!($node instanceof Node)) {
                continue;
            }

            $callback($node);
        }
    }
}
