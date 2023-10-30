<?php

namespace UnitTest\Post;

use Modules\Post\Domain\Contract\PostRepository;
use Modules\Post\Domain\Exception\NotFound;
use Modules\Post\Domain\Service\PostUpdate;
use Modules\Post\Domain\Post;
use Mockery\MockInterface;
use Modules\Shared\Domain\ValueObject\IdValueObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class PostTestCase extends TestCase
{
    protected PostRepository|MockInterface $repository;

    protected PostUpdate|MockInterface $updateService;

    public function shouldSaveRepository(): void
    {
        $this->repository
            ->shouldReceive('save')
            ->once();
    }

    public function shouldUpdateRepository(): void
    {
        $this->repository
            ->shouldReceive('update')
            ->once();
    }

    public function shouldNotSaveRepository(): void
    {
        $this->repository
            ->shouldReceive('save')
            ->andThrow(BadRequestException::class);
    }
    
    public function shouldFind(array $primitives): void
    {
        $this->repository
            ->shouldReceive('find')
            ->andReturn($primitives);
    }
    
    public function shouldNotFind(): void
    {
        $this->repository
            ->shouldReceive('findOrFail')
            ->andThrow(BadRequestException::class);
    }
    
    public function shouldFindOrFail(Post $post): void
    {
        $this->repository
            ->shouldReceive('findOrFail')
            ->with($post->id())
            ->andReturn($post->toPrimitives());
    }

    public function shouldNotFindOrFail(IdValueObject $id): void
    {
        $this->repository
            ->shouldReceive('findOrFail')
            ->andThrow(NotFound::with($id));
    }

    public function shouldDelete(): void
    {
        $this->repository
            ->shouldReceive('delete')
            ->once();
    }
}