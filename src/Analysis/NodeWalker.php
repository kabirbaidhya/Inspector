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
        $ast = $this->harmonizeNodes($ast);

        $errors = [];

        $this->foreachNode($ast, function (Node $node) use (&$errors, $callback) {

            $errors = array_merge($errors, $this->triggerCallback($callback, $node));

            $this->foreachSubNodes($node, function (array $subNodes) use (&$errors, $callback) {
                $moreErrors = $this->walk($subNodes, $callback);
                $errors = array_merge($errors, $moreErrors);
            });
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
     * Makes it a consistent array of node even if it is just a single instance of Node.
     *
     * @param mixed $ast
     * @return array
     */
    protected function harmonizeNodes($ast)
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

    /**
     * Checks and goes through each list of sub nodes a given Node has,
     * and triggers the callback for each of those sub nodes (Node[])
     *
     * @param Node $node
     * @param callable $callback
     */
    protected function foreachSubNodes(Node $node, callable $callback)
    {
        foreach ($node->getSubNodeNames() as $subNodeName) {
            $subNodeList = $node->{$subNodeName};

            $subNodeList = $this->harmonizeNodes($subNodeList);

            if (!is_array($subNodeList)) {
                continue;
            }

            // Node[] $subNodeList
            $callback($subNodeList);
        }
    }
}
