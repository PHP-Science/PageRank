<?php

declare(strict_types=1);

namespace PhpScience\PageRank\Strategy;

use PhpScience\PageRank\Builder\NodeBuilder;
use PhpScience\PageRank\Builder\NodeCollectionBuilder;
use PhpScience\PageRank\Data\NodeCollectionInterface;

class MemorySourceStrategy implements NodeDataSourceStrategyInterface
{
    private NodeBuilder           $nodeBuilder;
    private NodeCollectionBuilder $nodeCollectionBuilder;

    private array $previousRanks = [];
    private array $nodeListMap;
    private ?NodeCollectionInterface $nodeCollection = null;

    public function __construct(
        NodeBuilder $nodeBuilder,
        NodeCollectionBuilder $nodeCollectionBuilder,
        array $nodeListMap
    ) {
        $this->nodeBuilder = $nodeBuilder;
        $this->nodeCollectionBuilder = $nodeCollectionBuilder;
        $this->nodeListMap = $nodeListMap;
    }

    public function getIncomingNodeIds(int $nodeId): array
    {
        return $this->nodeListMap[$nodeId]['in'];
    }

    public function countOutgoingNodes(int $nodeId): int
    {
        return count($this->nodeListMap[$nodeId]['out']);
    }

    public function getPreviousRank(int $nodeId): float
    {
        return $this->previousRanks[$nodeId];
    }

    public function updateNodes(NodeCollectionInterface $collection): void
    {
        foreach ($collection->getNodes() as $item) {
            $this->previousRanks[$item->getId()] = $item->getRank();
        }
    }

    public function getNodeCollection(): NodeCollectionInterface
    {
        if (null === $this->nodeCollection) {
            $nodes = [];

            foreach ($this->nodeListMap as $nodeMap) {
                $nodes[] = $this->nodeBuilder->build($nodeMap);
            }

            $this->nodeCollection = $this->nodeCollectionBuilder->build($nodes);
        }

        return $this->nodeCollection;
    }

    public function getHighestRank(): float
    {
        $highest = null;

        foreach ($this->getNodeCollection()->getNodes() as $node) {
            if (
                null === $highest
                || $node->getRank() > $highest
            ) {
                $highest = $node->getRank();
            }
        }

        return $highest;
    }

    public function getLowestRank(): float
    {
        $lowest = null;

        foreach ($this->getNodeCollection()->getNodes() as $node) {
            if (
                null === $lowest
                || $node->getRank() < $lowest
            ) {
                $lowest = $node->getRank();
            }
        }

        return $lowest;
    }
}
