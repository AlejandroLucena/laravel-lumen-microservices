<?php

declare(strict_types=1);

namespace Modules\Post\Domain\Service;

use Modules\Post\Domain\Exception\NotFound;
use Modules\Post\Domain\Contract\PostRepository;
use Modules\Shared\Domain\ValueObject\IdValueObject;
use Modules\Shared\Domain\ValueObject\SlugValueObject;

final class PostFinder
{
    public function __construct(
        private readonly PostRepository $repository,
    ) {
    }

    public function findAll(): ?array
    {
        $post = $this->repository->findAll();

        return $post;
    }

    public function find(IdValueObject $id): ?array
    {
        $post = $this->repository->find($id);

        return $post;
    }

    public function findBySlugOrFail(SlugValueObject $slug): array
    {
        $post = $this->repository->FindBySlug($slug);

        if (! $post) {
            throw NotFound::withSlug($slug);
        }

        return $post;
    }
}
