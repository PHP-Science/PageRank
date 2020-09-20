<?php

declare(strict_types=1);

namespace PhpScience\PageRank\Service\PageRankAlgorithm;

use PhpScience\PageRank\Data\NodeCollectionInterface;
use PhpScience\PageRank\Data\NodeInterface;
use PHPUnit\Framework\TestCase;

class NormalizerTest extends TestCase
{
    /**
     * @dataProvider dataProviderNormalize
     *
     * @param float $originalRank
     * @param float $scaleBottom
     * @param float $scaleTop
     * @param float $lowestRank
     * @param float $highestRank
     * @param float $expectedRank
     */
    public function testNormalize(
        float $originalRank,
        float $scaleBottom,
        float $scaleTop,
        float $lowestRank,
        float $highestRank,
        float $expectedRank
    ): void {
        $nodeCollection = $this
            ->createMock(NodeCollectionInterface::class);
        $node = $this
            ->createMock(NodeInterface::class);

        $nodeCollection
            ->expects($this->once())
            ->method('getNodes')
            ->willReturn([$node]);

        $node
            ->expects($this->once())
            ->method('getRank')
            ->willReturn($originalRank);

        $node
            ->expects($this->once())
            ->method('setRank')
            ->with($expectedRank);

        $normalizer = new Normalizer(
            $scaleBottom,
            $scaleTop
        );

        $normalizer->normalize(
            $nodeCollection,
            $lowestRank,
            $highestRank
        );
    }

    public function dataProviderNormalize(): array
    {
        return [
            'realistic'                 => [
                1.234,
                1.0,
                10.0,
                -5.0,
                5.0,
                6.6106
            ],
            'division_by_zero'          => [
                5,
                1.0,
                10.0,
                5.0,
                5.0,
                1.0
            ],
            'division_by_float_epsilon' => [
                5,
                1.0,
                10.0,
                5.0,
                5.0 + PHP_FLOAT_EPSILON,
                1.0
            ],
            'scale_from_minus'          => [
                0.12577,
                -5,
                5,
                100,
                1000,
                -6.109713666666667
            ]
        ];
    }
}
