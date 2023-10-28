<?php

declare(strict_types=1);

namespace Modules\Post\Infrastructure\Controller;

use Modules\Post\Application\Query\FindAllPosts;
use Modules\Post\Domain\Contract\PostRepository;

final class FindAllPostsController
{
    public function __construct(
        private readonly PostRepository $repository
    ) {
    }

    public function __invoke()
    {
        $service = new FindAllPosts($this->repository);

        return $service->__invoke();
    }
}
