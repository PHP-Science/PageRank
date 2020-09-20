<?php

declare(strict_types=1);

namespace PhpScience\PageRank\Builder;

use PHPUnit\Framework\TestCase;

class NodeBuilderTest extends TestCase
{
    private NodeBuilder $nodeBuilder;

    protected function setUp(): void
    {
        $this->nodeBuilder = new NodeBuilder();
    }

    public function testBuild(): void
    {
        $expected = 0.25;

        $data = [
            'id'   => 1,
            'rank' => $expected
        ];

        $actual = $this->nodeBuilder->build($data);

        static::assertSame($expected, $actual->getRank());
    }
}
