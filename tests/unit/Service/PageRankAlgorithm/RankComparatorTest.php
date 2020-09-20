<?php

declare(strict_types=1);

namespace PhpScience\PageRank\Service\PageRankAlgorithm;

use PHPUnit\Framework\TestCase;

class RankComparatorTest extends TestCase
{
    private RankComparator $rankComparator;

    protected function setUp(): void
    {
        $this->rankComparator = new RankComparator();
    }

    /**
     * @dataProvider dataProviderIsEqual
     *
     * @param float $rank1
     * @param float $rank2
     * @param bool  $expected
     */
    public function testIsEqual(
        float $rank1,
        float $rank2,
        bool $expected
    ): void {
        $actual = $this->rankComparator->isEqual($rank1, $rank2);

        static::assertSame($expected, $actual);
    }

    public function dataProviderIsEqual(): array
    {
        return [
            'not_equal'                                          => [
                .1, .2, false
            ],
            'equal'                                              => [
                .1, .1, true
            ],
            'absolute_value_of_minus'                            => [
                .1, .2, false
            ],
            'absolute_of_minus_one_is_bigger_than_float_epsilon' => [
                1, 2, false
            ],
            'smallest_representable_difference'                  => [
                1, 1 + PHP_FLOAT_EPSILON, false
            ],
            'non_representable_difference'                       => [
                1, 1 + 2.2204460492503e-17, true
            ]
        ];
    }
}
