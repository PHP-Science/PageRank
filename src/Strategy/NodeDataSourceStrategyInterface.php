<?php

declare(strict_types=1);

namespace PhpScience\PageRank\Strategy;

use PhpScience\PageRank\Data\NodeCollectionInterface;

/**
 * This data source strategy is responsible to handle all of the possible io
 * operations. If the pagerank calculation has to be able to run in multiple
 * batches then this strategy is responsible to feed the algorithm with the
 * correct node data and update the changes in the storage.
 *
 * @package PhpScience\PageRank\Strategy
 */
interface NodeDataSourceStrategyInterface
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

    /**
     * It returns the highest rank from the node collection.
     *
     * @return float
     */
    public function getHighestRank(): float;

    /**
     * It returns the lowest rank from the node collection.
     *
     * @return float
     */
    public function getLowestRank(): float;
}
