<?php

declare(strict_types=1);

namespace Modules\Post\Domain\Service;

use Modules\Post\Domain\Contract\PostRepository;
use Modules\Post\Domain\Post;
use Modules\Post\Domain\ValueObject\PostContent;
use Modules\Post\Domain\ValueObject\PostTitle;
use Modules\Shared\Domain\ValueObject\DateTimeValueObject;
use Modules\Shared\Domain\ValueObject\IdValueObject;
use Modules\Shared\Domain\ValueObject\SlugValueObject;

final class PostUpdate
{
    public function __construct(
        private readonly PostRepository $repository,
        private readonly PostFinder $postFinder
    ) {
    }

    public function __invoke(
        IdValueObject $id,
        ?PostTitle $title,
        ?SlugValueObject $slug,
        ?PostContent $content,
        ?DateTimeValueObject $updatedAt
    ): void {
        $resource = $this->postFinder->find($id);
        
        $post = Post::fromPrimitives($resource);

        $post->update(
            $id,
            $title ? $title : $post->title(),
            $slug ? $slug : $post->slug(),
            $content ? $content : $post->content(),
            $updatedAt
        );

        $this->repository->update($post);
    }
}
