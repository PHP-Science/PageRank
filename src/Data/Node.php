<?php

declare(strict_types=1);

namespace PhpScience\PageRank\Data;

class Node implements NodeInterface
{
    private int   $id;
    private float $rank;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getRank(): float
    {
        return $this->rank;
    }

    public function setRank(float $rank): void
    {
        $this->rank = $rank;
    }
}
