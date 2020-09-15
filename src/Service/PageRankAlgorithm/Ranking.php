<?php

declare(strict_types=1);

namespace PhpScience\PageRank\Service\PageRankAlgorithm;

use PhpScience\PageRank\Data\NodeCollectionInterface;
use PhpScience\PageRank\Strategy\NodeDataStrategyInterface;

class Ranking implements RankingInterface
{
    private NodeDataStrategyInterface $nodeDataStrategy;
    private RankComparatorInterface   $rankComparator;

    public function __construct(
        RankComparatorInterface $rankComparator,
        NodeDataStrategyInterface $nodeDataStrategy
    ) {
        $this->nodeDataStrategy = $nodeDataStrategy;
        $this->rankComparator = $rankComparator;
    }

    public function calculateInitialRank(
        NodeCollectionInterface $nodeCollection
    ): void {
        foreach ($nodeCollection->getNodes() as $item) {
            $item->setRank(1 / $nodeCollection->getAllNodeCount());
        }
    }

    public function calculateRankPerIteration(
        NodeCollectionInterface $nodeCollection
    ): int {
        $nonRepresentableDifference = 0;

        foreach ($nodeCollection->getNodes() as $node) {
            $rank = $this->calculateRank($node->getId());
            $node->setRank($rank);

            $isEqual = $this->rankComparator->isEqual(
                $this->nodeDataStrategy->getPreviousRank($node->getId()),
                $node->getRank()
            );

            if ($isEqual) {
                $nonRepresentableDifference++;
            }
        }

        return $nonRepresentableDifference;
    }

    private function calculateRank(int $nodeId): float
    {
        $rank = .0;

        $incomingNodeIds = $this
            ->nodeDataStrategy
            ->getIncomingNodeIds($nodeId);

        foreach ($incomingNodeIds as $incomingNodeId) {
            $incomingNodePreviousRank = $this
                ->nodeDataStrategy
                ->getPreviousRank($incomingNodeId);

            $countOutgoingNodesOfIncomingNode = $this
                ->nodeDataStrategy
                ->countOutgoingNodes($incomingNodeId);

            if (0 === $countOutgoingNodesOfIncomingNode) {
                continue;
            }

            $rank += $incomingNodePreviousRank
                / $countOutgoingNodesOfIncomingNode;
        }

        return $rank;
    }
}
