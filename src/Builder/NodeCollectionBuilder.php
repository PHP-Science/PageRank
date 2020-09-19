<?php

declare(strict_types=1);

namespace PhpScience\PageRank\Builder;

use PhpScience\PageRank\Data\NodeCollection;
use PhpScience\PageRank\Data\NodeCollectionInterface;

class NodeCollectionBuilder
{
    /**
     * @param mixed[] $nodes
     *
     * @return NodeCollectionInterface
     */
    public function build(array $nodes): NodeCollectionInterface
    {
        $pageRankTransferObject = new NodeCollection();

        $pageRankTransferObject->setNodes($nodes);
        $pageRankTransferObject->setAllNodeCount(count($nodes));

        return $pageRankTransferObject;
    }
}
