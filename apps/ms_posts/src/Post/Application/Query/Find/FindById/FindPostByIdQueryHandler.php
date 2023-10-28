<?php

declare(strict_types=1);

namespace Modules\Post\Application\Query\Find\FindById;

use Modules\Post\Domain\Resource\PostResource;
use Modules\Post\Domain\Service\PostFinder;
use Modules\Shared\Domain\ValueObject\IdValueObject;

class FindPostByIdQueryHandler
{
    public function __construct(
        private readonly PostFinder $postFinder
    ) {
    }

    public function handle(FindPostByIdQuery $findPostByIdQuery): ?PostResource
    {
        $resource = $this->postFinder->find(
            IdValueObject::from($findPostByIdQuery->id())
        );

        return $resource;
    }
}
