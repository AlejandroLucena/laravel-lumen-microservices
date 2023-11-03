<?php

declare(strict_types=1);

namespace Modules\Post\Domain\Service;

use Modules\Post\Domain\Contract\PostRepository;
use Modules\Post\Domain\Exception\AlreadyExists;
use Modules\Post\Domain\Post;
use Modules\Post\Domain\ValueObject\PostContent;
use Modules\Post\Domain\ValueObject\PostTitle;
use Modules\Shared\Domain\ValueObject\DateTimeValueObject;
use Modules\Shared\Domain\ValueObject\SlugValueObject;

class PostCreator
{
    public function __construct(
        private readonly PostRepository $postRepository,
        private readonly PostFinder $postFinder
    ) {
    }

    public function __invoke(
        PostTitle $title,
        SlugValueObject $slug,
        PostContent $content,
        DateTimeValueObject $createdAt
    ): void {

        $this->ensureDoesNotExistsSlug($slug);

        $post = new Post(
            null,
            $title,
            $slug,
            $content,
            $createdAt
        );

        $this->postRepository->save($post);
    }

    private function ensureDoesNotExistsSlug(SlugValueObject $slug): void
    {
        $post = $this->postFinder->findBySlug($slug);
        if ($post) {
            throw new AlreadyExists("". $slug ."");
        }
    }
}
