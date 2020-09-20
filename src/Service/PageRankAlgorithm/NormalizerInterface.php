<?php

declare(strict_types=1);

namespace PhpScience\PageRank\Service\PageRankAlgorithm;

use PhpScience\PageRank\Data\NodeCollectionInterface;

interface NormalizerInterface
{
    /**
     * It normalizes and scales the ranks in the node collection.
     *
     * @param NodeCollectionInterface $nodeCollection
     * @param float                   $lowestRank
     * @param float                   $highestRank
     */
    public function normalize(
        NodeCollectionInterface $nodeCollection,
        float $lowestRank,
        float $highestRank
    ): void;
}
