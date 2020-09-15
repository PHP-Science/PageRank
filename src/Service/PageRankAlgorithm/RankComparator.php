<?php

declare(strict_types=1);

namespace PhpScience\PageRank\Service\PageRankAlgorithm;

class RankComparator implements RankComparatorInterface
{
    public function isEqual(float $rank1, float $rank2): bool
    {
        return abs($rank1 - $rank2) < PHP_FLOAT_EPSILON;
    }
}
