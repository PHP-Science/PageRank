<?php

declare(strict_types=1);

namespace PhpScience\PageRank\Service\PageRankAlgorithm;

use PhpScience\PageRank\Data\NodeCollectionInterface;

class Normalizer implements NormalizerInterface
{
    private float $scaleBottom;
    private float $scaleTop;

    public function __construct(
        float $scaleBottom = 1,
        float $scaleTop = 10
    ) {
        $this->scaleBottom = $scaleBottom;
        $this->scaleTop = $scaleTop;
    }

    public function normalize(
        NodeCollectionInterface $nodeCollection,
        float $lowestRank,
        float $highestRank
    ): void {
        $divider = $this->getDivider($lowestRank, $highestRank);

        foreach ($nodeCollection->getNodes() as $node) {
            $rank = $this->getScaledRank(
                $node->getRank(),
                $lowestRank,
                $divider
            );
            $node->setRank($rank);
        }
    }

    private function getDivider(float $lowestRank, float $highestRank): float
    {
        $divider = $highestRank - $lowestRank;

        if (.0 === $divider) {
            $divider = 1;
        }

        return $divider;
    }

    private function getScaledRank(
        float $value,
        float $lowestRank,
        float $divider
    ): float {
        $normalized = ($value - $lowestRank) / $divider;
        $multiplier = $this->scaleTop - $this->scaleBottom;

        return ($normalized * $multiplier) + $this->scaleBottom;
    }
}
