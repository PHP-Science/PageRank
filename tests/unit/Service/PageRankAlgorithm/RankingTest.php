<?php

declare(strict_types=1);

namespace PhpScience\PageRank\Service\PageRankAlgorithm;

use PhpScience\PageRank\Data\NodeCollectionInterface;
use PhpScience\PageRank\Data\NodeInterface;
use PhpScience\PageRank\Strategy\NodeDataSourceStrategyInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class RankingTest extends TestCase
{
    private RankingInterface $ranking;

    /**
     * @var MockObject|NodeDataSourceStrategyInterface
     */
    private MockObject $nodeDataStrategy;

    /**
     * @var MockObject|RankComparatorInterface
     */
    private MockObject $rankComparator;

    protected function setUp(): void
    {
        $this->nodeDataStrategy = $this
            ->getMockBuilder(NodeDataSourceStrategyInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->rankComparator = $this
            ->getMockBuilder(RankComparatorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->ranking = new Ranking(
            $this->rankComparator,
            $this->nodeDataStrategy
        );
    }

    public function testCalculateInitialRank(): void
    {
        $nodeCollection = $this
            ->createMock(NodeCollectionInterface::class);

        $node = $this
            ->createMock(NodeInterface::class);

        $nodeCollection
            ->expects($this->once())
            ->method('getNodes')
            ->willReturn([$node]);

        $nodeCollection
            ->expects($this->once())
            ->method('getAllNodeCount')
            ->willReturn(10);

        $node
            ->expects($this->once())
            ->method('setRank')
            ->with(0.1);

        $this->ranking->calculateInitialRank($nodeCollection);
    }

    /**
     * @dataProvider dataProviderCalculateRankPerIteration
     *
     * @param int   $subjectId
     * @param int   $incomingNodeId
     * @param int   $outgoingNodesOfIncomingNode
     * @param float $calculatedNewRank
     * @param bool  $ranksAreEqual
     * @param int   $expected
     */
    public function testCalculateRankPerIteration(
        int $subjectId,
        int $incomingNodeId,
        int $outgoingNodesOfIncomingNode,
        float $calculatedNewRank,
        bool $ranksAreEqual,
        int $expected
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
            ->expects($this->any())
            ->method('getId')
            ->willReturn($subjectId);

        $this
            ->nodeDataStrategy
            ->expects($this->once())
            ->method('getIncomingNodeIds')
            ->with($subjectId)
            ->willReturn([$incomingNodeId]);

        $this
            ->nodeDataStrategy
            ->expects($this->exactly($incomingNodeId))
            ->method('getPreviousRank')
            ->withConsecutive([$incomingNodeId], [$subjectId])
            ->willReturn(0.2, 0.1);

        $this
            ->nodeDataStrategy
            ->expects($this->once())
            ->method('countOutgoingNodes')
            ->with($incomingNodeId)
            ->willReturn($outgoingNodesOfIncomingNode);

        $node
            ->expects($this->once())
            ->method('setRank')
            ->with($calculatedNewRank);

        $node
            ->expects($this->once())
            ->method('getRank')
            ->willReturn(99.123);

        $this
            ->rankComparator
            ->expects($this->once())
            ->method('isEqual')
            ->with(0.1, 99.123)
            ->willReturn($ranksAreEqual);

        $actual = $this->ranking->calculateRankPerIteration($nodeCollection);

        static::assertSame($expected, $actual);
    }

    public function dataProviderCalculateRankPerIteration(): array
    {
        return [
            [
                1, 2, 100, 0.002, true, 1
            ],
            [
                1, 2, 0, 0, true, 1
            ],
            [
                1, 2, 0, 0, false, 0
            ]
        ];
    }
}
