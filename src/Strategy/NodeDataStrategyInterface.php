<?php

declare(strict_types=1);

namespace PhpScience\PageRank\Strategy;

use PhpScience\PageRank\Data\NodeCollectionInterface;

interface NodeDataStrategyInterface
{
    /**
     * It returns all of the incoming node ids of the subject node.
     *
     * @param int $nodeId
     *
     * @return int[]
     */
    public function getIncomingNodeIds(int $nodeId): array;

    /**
     * It returns the count of the outgoing nodes from the subject node.
     *
     * @param int $nodeId
     *
     * @return int
     */
    public function countOutgoingNodes(int $nodeId): int;

    /**
     * It returns the rank of the previous node. The previous node is the
     * previous one in the iteration of power method.
     *
     * @param int $nodeId
     *
     * @return float
     */
    public function getPreviousRank(int $nodeId): float;

    /**
     * It updates the nodes in the storage for further calculations.
     *
     * @param NodeCollectionInterface $collection
     */
    public function updateNodes(NodeCollectionInterface $collection): void;

    /**
     * It returns the node collection.
     *
     * @return NodeCollectionInterface
     */
    public function getNodeCollection(): NodeCollectionInterface;
}
