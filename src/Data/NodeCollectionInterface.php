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
     * @return int
     */
    public function getAllNodeCount(): int;

    /**
     * @param int $maxSize
     */
    public function setAllNodeCount(int $maxSize): void;
}