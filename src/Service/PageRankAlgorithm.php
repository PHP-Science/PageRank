<?php

declare(strict_types=1);

namespace PhpScience\PageRank\Service;

use PhpScience\PageRank\Data\NodeCollectionInterface;
use PhpScience\PageRank\Service\PageRankAlgorithm\RankingInterface;
use PhpScience\PageRank\Strategy\NodeDataStrategyInterface;

class PageRankAlgorithm implements PageRankAlgorithmInterface
{
    private NodeDataStrategyInterface $nodeDataStrategy;
    private RankingInterface          $ranking;

    public function __construct(
        RankingInterface $ranking,
        NodeDataStrategyInterface $nodeDataStrategy
    ) {
        $this->nodeDataStrategy = $nodeDataStrategy;
        $this->ranking = $ranking;
    }

    public function run(int $powerMethodIterationCount): NodeCollectionInterface
    {
        $nodeCollection = $this->nodeDataStrategy->getNodeCollection();

        $this->ranking->calculateInitialRank($nodeCollection);
        $this->nodeDataStrategy->updateNodes($nodeCollection);
        $this->powerIterate($nodeCollection, $powerMethodIterationCount);

        return $nodeCollection;
    }

    private function powerIterate(
        NodeCollectionInterface $nodeCollection,
        int $powerMethodIterationCount
    ): void {
        $noneRepresentableDiffCount = 0;
        $i = 0;

        while (
            $i < $powerMethodIterationCount
            && $noneRepresentableDiffCount < $nodeCollection->getAllNodeCount()
        ) {
            $i++;

            $noneRepresentableDiffCount = $this
                ->ranking
                ->calculateRankPerIteration($nodeCollection);

            $this->nodeDataStrategy->updateNodes($nodeCollection);
        }
    }
}
