<?php

declare(strict_types=1);

namespace PhpScience\PageRank\Data;

interface NodeCollectionInterface
{
    /**
     * @return NodeInterface[]
     */
    public function getNodes(): array;

    /**
     * @param NodeInterface[] $nodes
     */
    public function setNodes(array $nodes): void;

    /**
     * It returns the count of all nodes, not only the count of the nodes in the
     * current collection.
     *
     * @return int
     */
    public function getAllNodeCount(): int;

    /**
     * The count of all nodes, not only the count of the nodes in the current
     * collection.
     *
     * @param int $maxSize
     */
    public function setAllNodeCount(int $maxSize): void;
}