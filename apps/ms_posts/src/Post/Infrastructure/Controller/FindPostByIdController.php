<?php

declare(strict_types=1);

namespace Modules\Post\Infrastructure\Controller;

use Modules\Post\Application\Query\FindPostById;
use Modules\Post\Domain\Contract\PostRepository;

final class FindPostByIdController
{
    public function __construct(
        private readonly PostRepository $repository
    ) {
    }

    public function __invoke(int $id)
    {
        $service = new FindPostById($this->repository);

        return $service->__invoke($id);
    }
}
