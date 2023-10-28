<?php

declare(strict_types=1);

namespace Modules\Post\Domain\Service;

use Modules\Post\Domain\Contract\PostRepository;
use Modules\Post\Domain\Exception\NotFound;
use Modules\Shared\Domain\ValueObject\IdValueObject;

final class PostDelete
{
    public function __construct(
        private readonly PostRepository $repository,
        private readonly PostFinder $postFinder
    ) {
    }

    public function __invoke(
        IdValueObject $id,
    ): void {
        $this->ensurePostExists($id);

        $this->repository->delete($id);
    }

    public function ensurePostExists(IdValueObject $id): void
    {
        $response = $this->repository->find($id);

        if (! $response) {
            throw NotFound::with($id);
        }
    }
}
