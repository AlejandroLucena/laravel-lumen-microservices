<?php

namespace UnitTest\Post;

use Modules\Post\Domain\Contract\PostRepository;
use Modules\Post\Domain\Exception\NotFound;
use Modules\Post\Domain\Service\PostUpdater;
use Modules\Post\Domain\Post;
use Mockery\MockInterface;
use Modules\Post\Domain\Exception\AlreadyExists;
use Modules\Post\Domain\Exception\AlreadyExistsSlug;
use Modules\Post\Domain\Service\PostFinder;
use Modules\Shared\Domain\ValueObject\IdValueObject;
use Modules\Shared\Domain\ValueObject\SlugValueObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class PostTestCase extends TestCase
{
    protected PostRepository|MockInterface $postRepository;
    protected PostFinder|MockInterface $postFinder;

    public function shouldSaveRepository(): void
    {
        $this->postRepository
            ->shouldReceive('save')
            ->once();
    }

    public function shouldUpdateRepository(): void
    {
        $this->postRepository
            ->shouldReceive('update')
            ->once();
    }

    public function shouldNotSaveRepository(): void
    {
        $this->postRepository
            ->shouldReceive('save')
            ->andThrow(BadRequestException::class);
    }
    
    public function shouldFind(Post $post): void
    {
        $this->postRepository
            ->shouldReceive('find')
            ->andReturn($post->toPrimitives());
    }
    
    public function shouldFindSlugFails(): void
    {
        $this->postRepository
            ->shouldReceive('findBySlug')
            ->andThrow(AlreadyExists::class);
    }
    
    public function shouldNotFind(): void
    {
        $this->postRepository
            ->shouldReceive('find')
            ->andThrow(NotFound::class);
    }
    
    public function shouldFindOrFail(Post $post): void
    {
        $this->postRepository
            ->shouldReceive('findOrFail')
            ->with($post->id())
            ->andReturn($post->toPrimitives());
    }

    public function shouldNotFindOrFail(IdValueObject $id): void
    {
        $this->postRepository
            ->shouldReceive('findOrFail')
            ->andThrow(NotFound::with($id));
    }

    public function shouldFindOtherSlug(SlugValueObject $slug): void
    {
        $this->postRepository
            ->shouldReceive('findBySlug')
            ->andThrow(AlreadyExistsSlug::with($slug));
    }

    public function shouldNotFindOtherSlug(): void
    {
        $this->postRepository
            ->shouldReceive('findBySlug')
            ->andReturnNull();
    }


    public function shouldDelete(): void
    {
        $this->postRepository
            ->shouldReceive('delete')
            ->once();
    }
}