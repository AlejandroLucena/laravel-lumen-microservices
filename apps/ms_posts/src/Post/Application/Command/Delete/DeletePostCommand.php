<?php

declare(strict_types=1);

namespace Modules\Post\Application\Command\Delete;

class DeletePostCommand
{
    public function __construct(
        private readonly int $id,
    ) {
    }

    public function id(): int
    {
        return $this->id;
    }
}
