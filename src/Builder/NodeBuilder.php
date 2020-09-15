<?php

declare(strict_types=1);

namespace PhpScience\PageRank\Builder;

use PhpScience\PageRank\Data\Node;
use PhpScience\PageRank\Data\NodeInterface;

class NodeBuilder
{
    public const FIELD_ID   = 'id';
    public const FIELD_RANK = 'rank';

    public function build(array $nodeData): NodeInterface
    {
        $node = new Node();

        $node->setId($nodeData[self::FIELD_ID]);

        if (!empty($nodeData[self::FIELD_RANK])) {
            $node->setRank($nodeData[self::FIELD_RANK]);
        }

        return $node;
    }
}
