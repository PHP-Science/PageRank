<?php

declare(strict_types=1);

namespace PhpScience\PageRank\Service\PageRankAlgorithm;

use PhpScience\PageRank\Data\NodeCollectionInterface;

interface RankingInterface
{
    /**
     * @param NodeCollectionInterface $nodeCollection
     */
    public function calculateInitialRank(
        NodeCollectionInterface $nodeCollection
    ): void;

    /**
     * @param NodeCollectionInterface $nodeCollection
     *
     * @return int
     */
    public function calculateRankPerIteration(
        NodeCollectionInterface $nodeCollection
    ): int;
}
