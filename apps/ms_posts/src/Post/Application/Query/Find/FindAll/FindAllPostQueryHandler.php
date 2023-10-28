<?php

declare(strict_types=1);

namespace Modules\Post\Application\Query\Find\FindAll;

use Modules\Post\Domain\Service\PostFinder;

class FindAllPostQueryHandler
{
    public function __construct(
        private readonly PostFinder $postFinder
    ) {
    }

    public function handle(): ?array
    {
        $resource = $this->postFinder->findAll();

        return $resource;
    }
}
