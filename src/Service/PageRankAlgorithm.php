<?php

declare(strict_types=1);

namespace PhpScience\PageRank\Service;

use PhpScience\PageRank\Data\NodeCollectionInterface;
use PhpScience\PageRank\Service\PageRankAlgorithm\RankingInterface;
use PhpScience\PageRank\Strategy\NodeDataSourceStrategyInterface;

class PageRankAlgorithm implements PageRankAlgorithmInterface
{
    private NodeDataSourceStrategyInterface $nodeDataStrategy;
    private RankingInterface                $ranking;

    public function __construct(
        RankingInterface $ranking,
        NodeDataSourceStrategyInterface $nodeDataStrategy
    ) {
        $this->nodeDataStrategy = $nodeDataStrategy;
        $this->ranking = $ranking;
    }

    public function run(int $maxIterate): NodeCollectionInterface
    {
        $this->initiateRanking();

        return $this->runBatch($maxIterate);
    }

    public function initiateRanking(): NodeCollectionInterface
    {
        $nodeCollection = $this->nodeDataStrategy->getNodeCollection();

        $this->ranking->calculateInitialRank($nodeCollection);
        $this->nodeDataStrategy->updateNodes($nodeCollection);

        return $nodeCollection;
    }

    public function runBatch(int $maxIterate): NodeCollectionInterface
    {
        $nodeCollection = $this->nodeDataStrategy->getNodeCollection();

        $this->powerIterate($nodeCollection, $maxIterate);

        return $nodeCollection;
    }

    private function powerIterate(
        NodeCollectionInterface $nodeCollection,
        int $maxIterate
    ): void {
        $noneRepresentableDiffCount = 0;
        $i = 0;

        while (
            $i < $maxIterate
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
