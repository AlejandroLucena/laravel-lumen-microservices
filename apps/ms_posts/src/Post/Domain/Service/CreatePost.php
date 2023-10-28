<?php

declare(strict_types=1);

namespace Modules\Post\Domain\Service;

use Modules\Post\Domain\Contract\PostRepository;
use Modules\Post\Domain\Post;
use Modules\Post\Domain\ValueObject\PostContent;
use Modules\Post\Domain\ValueObject\PostTitle;
use Modules\Shared\Domain\ValueObject\DateTimeValueObject;
use Modules\Shared\Domain\ValueObject\SlugValueObject;

final class CreatePost
{
    public function __construct(
        private readonly PostRepository $repository,
    ) {
    }

    public function __invoke(
        PostTitle $title,
        SlugValueObject $slug,
        PostContent $content,
        DateTimeValueObject $createdAt
    ): void {
        $post = new Post(
            null,
            $title,
            $slug,
            $content,
            $createdAt
        );

        $this->repository->save($post);
    }
}
