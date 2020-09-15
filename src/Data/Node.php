<?php

declare(strict_types=1);

namespace PhpScience\PageRank\Data;

class Node implements NodeInterface
{
    private int $id;
    private float $rank;

    /**
     * @inheritDoc
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @inheritDoc
     */
    public function getRank(): float
    {
        return $this->rank;
    }

    /**
     * @inheritDoc
     */
    public function setRank(float $rank): void
    {
        $this->rank = $rank;
    }
}
