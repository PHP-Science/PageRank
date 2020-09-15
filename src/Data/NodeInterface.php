<?php

declare(strict_types=1);

namespace PhpScience\PageRank\Data;

interface NodeInterface
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @param int $id
     */
    public function setId(int $id): void;

    /**
     * @return float
     */
    public function getRank(): float;

    /**
     * @param float $rank
     */
    public function setRank(float $rank): void;
}
