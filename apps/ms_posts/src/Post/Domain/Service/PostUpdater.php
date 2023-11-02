<?php

declare(strict_types=1);

namespace Modules\Post\Domain\Service;

use Illuminate\Support\Facades\Log;
use Modules\Post\Domain\Contract\PostRepository;
use Modules\Post\Domain\Exception\AlreadyExists;
use Modules\Post\Domain\Exception\NotFound;
use Modules\Post\Domain\Post;
use Modules\Post\Domain\ValueObject\PostContent;
use Modules\Post\Domain\ValueObject\PostTitle;
use Modules\Shared\Domain\ValueObject\DateTimeValueObject;
use Modules\Shared\Domain\ValueObject\IdValueObject;
use Modules\Shared\Domain\ValueObject\SlugValueObject;

final class PostUpdater
{
    public function __construct(
        private readonly PostRepository $postRepository,
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

        $post = $this->ensureExists($id); //find
        
        $this->ensureDoesNotExistsSlug($slug); //findBySlug

        $post->update(
            $id,
            $title ? $title : $post->title(),
            $slug ? $slug : $post->slug(),
            $content ? $content : $post->content(),
            $updatedAt
        );

        $this->postRepository->update($post);
    }

    private function ensureExists(IdValueObject $id): ?Post
    {
        $response = $this->postFinder->find($id);
        if (!$response) {
            throw NotFound::with($id);
        }

        return Post::fromValueObjects($response);
    }

    private function ensureDoesNotExistsSlug(SlugValueObject $slug): void
    {
        $response = $this->postFinder->findBySlug($slug);
        if ($response) {
            throw new AlreadyExists("" . $slug . "");
        }
    }
}
