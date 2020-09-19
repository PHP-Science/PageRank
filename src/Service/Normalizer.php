<?php

declare(strict_types=1);

namespace PhpScience\PageRank\Service;

use PhpScience\PageRank\Data\NodeCollectionInterface;

class Normalizer implements NormalizerInterface
{
    private float $min;
    private float $max;

    public function __construct(
        float $min = 1,
        float $max = 10
    ) {
        $this->min = $min;
        $this->max = $max;
    }

    public function normalize(
        NodeCollectionInterface $nodeCollection,
        float $lowestRank,
        float $highestRank
    ): void {
        foreach ($nodeCollection->getNodes() as $node) {
            $rank = $this->getRank($node->getRank(), $lowestRank, $highestRank);
            $node->setRank($rank);
        }
    }

    private function getRank(float $value, float $min, float $max): float
    {
        $normalized = ($value - $min) / ($max - $min);
        $scaled = ($normalized * ($this->max - $this->min)) + $this->min;

        return $scaled;
    }
}
