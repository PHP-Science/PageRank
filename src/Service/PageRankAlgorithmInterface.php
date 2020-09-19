<?php

declare(strict_types=1);

namespace PhpScience\PageRank\Service;

use PhpScience\PageRank\Data\NodeCollectionInterface;

/**
 * General PageRank interface that calculates the ranks of nodes. The scheduling
 * and scalability depend on the implementation of the
 * NodeDataSourceStrategyInterface.
 *
 * @see     \PhpScience\PageRank\Strategy\NodeDataSourceStrategyInterface
 * @package PhpScience\PageRank\Service
 */
interface PageRankAlgorithmInterface
{
    /**
     * It Calculates the initial ranks and then It calculates the ranks of the
     * It performs the calculation over and over again until it reaches the
     * maxIterate number. However, the running stops when the ranks are accurate
     * enough even if the max iteration didn't reach its limit.
     *
     * @param int $maxIterate
     *
     * @return NodeCollectionInterface
     */
    public function run(int $maxIterate): NodeCollectionInterface;

    /**
     * It runs the algorithm at first time, calculates the initial ranks. All
     * nodes will have the same rank at this point.
     *
     * @return NodeCollectionInterface
     */
    public function initiateRanking(): NodeCollectionInterface;

    /**
     * It can calculate the ranks of the nodes after the method initiateRanking
     * executed. It performs the calculation over and over again until it
     * reaches the maxIterate number. However, the running stops when the ranks
     * are accurate enough even if the max iteration didn't reach its limit.
     *
     * @param int $maxIterate
     *
     * @return NodeCollectionInterface
     */
    public function runBatch(int $maxIterate): NodeCollectionInterface;

    /**
     * After the pagerank calculation, the ranks have wide range of minus and
     * plus values. This method adjusts the ranks between a minimum and a
     * maximum value.
     *
     * @return NodeCollectionInterface
     */
    public function normalize(): NodeCollectionInterface;
}
