<?php

declare(strict_types=1);

namespace PhpScience\PageRank\Service\PageRankAlgorithm;

interface RankComparatorInterface
{
    /**
     * @param float $rank1
     * @param float $rank2
     *
     * @return bool
     */
    public function isEqual(float $rank1, float $rank2): bool;
}
