<?php

declare(strict_types=1);

namespace PhpScience\PageRank\Service;

use PhpScience\PageRank\Builder\NodeBuilder;
use PhpScience\PageRank\Builder\NodeCollectionBuilder;
use PhpScience\PageRank\Service\PageRankAlgorithm\RankComparator;
use PhpScience\PageRank\Service\PageRankAlgorithm\Ranking;
use PhpScience\PageRank\Strategy\MemorySourceStrategy;
use PHPUnit\Framework\TestCase;

class PageRankAlgorithmTest extends TestCase
{
    private PageRankAlgorithm $pageRankAlgorithm;

    protected function setUp(): void
    {
        $dataSource = $this->getDataSource();

        $nodeBuilder = new NodeBuilder();
        $nodeCollectionBuilder = new NodeCollectionBuilder();
        $strategy = new MemorySourceStrategy(
            $nodeBuilder,
            $nodeCollectionBuilder,
            $dataSource
        );

        $rankComparator = new RankComparator();
        $ranking = new Ranking(
            $rankComparator,
            $strategy
        );

        $this->pageRankAlgorithm = new PageRankAlgorithm(
            $ranking,
            $strategy
        );
    }

    /**
     * @dataProvider dataProviderExpectedRanks
     *
     * @param float[] $expectedRanks
     */
    public function testRun(array $expectedRanks): void
    {
        $nodeCollection = $this
            ->pageRankAlgorithm
            ->run(2);

        static::assertSame(4, $nodeCollection->getAllNodeCount());

        foreach ($nodeCollection->getNodes() as $node) {
            $expectedRank = $expectedRanks[$node->getId()];
            $actualRank = $node->getRank();

            static::assertSame($expectedRank, $actualRank);
        }
    }

    public function dataProviderExpectedRanks(): array
    {
        return [
            'scenario_1' => [
                'expectedRanks' => [
                    1 => 0.125,
                    2 => 0.16666666666667,
                    3 => 0.375,
                    4 => 0.33333333333333
                ]
            ]
        ];
    }

    private function getDataSource(): array
    {
        return [
            1 => [
                'id'  => 1,
                'out' => [2, 3],
                'in'  => [3]
            ],
            2 => [
                'id'  => 2,
                'out' => [4],
                'in'  => [1, 3]
            ],
            3 => [
                'id'  => 3,
                'out' => [1, 2, 4],
                'in'  => [1, 4]
            ],
            4 => [
                'id'  => 4,
                'out' => [3],
                'in'  => [3, 2]
            ]
        ];
    }
}
