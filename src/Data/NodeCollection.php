<?php

declare(strict_types=1);

namespace PhpScience\PageRank\Data;

class NodeCollection implements NodeCollectionInterface
{
    private array $nodes;
    private int   $allNodeCount;

    public function getNodes(): array
    {
        return $this->nodes;
    }

    public function setNodes(array $nodes): void
    {
        $this->nodes = $nodes;
    }

    public function getAllNodeCount(): int
    {
        return $this->allNodeCount;
    }

    public function setAllNodeCount(int $allNodeCount): void
    {
        $this->allNodeCount = $allNodeCount;
    }
}
