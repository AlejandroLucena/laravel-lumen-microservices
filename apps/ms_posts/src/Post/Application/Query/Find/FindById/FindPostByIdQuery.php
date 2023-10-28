<?php

declare(strict_types=1);

namespace Modules\Post\Application\Query\Find\FindById;

/**
 * Summary of FindPostByIdQuery
 */
class FindPostByIdQuery
{
    public function __construct(
        private readonly int $id
    ) {
    }

    /**
     * Summary of id
     */
    public function id(): int
    {
        return $this->id;
    }
}
