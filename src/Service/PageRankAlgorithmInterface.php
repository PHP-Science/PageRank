<?php

declare(strict_types=1);

namespace PhpScience\PageRank\Service;

use PhpScience\PageRank\Data\NodeCollectionInterface;

interface PageRankAlgorithmInterface
{
    /**
     * @param int $powerMethodIterationCount
     *
     * @return NodeCollectionInterface
     */
    public function run(int $powerMethodIterationCount): NodeCollectionInterface;
}
