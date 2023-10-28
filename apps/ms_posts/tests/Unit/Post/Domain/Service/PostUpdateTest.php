<?php

namespace UnitTest\Post\Domain\Service;

use Mockery;
use Mockery\MockInterface;
use UnitTest\Post\PostMother;
use UnitTest\Post\PostTestCase;
use Modules\Post\Domain\Service\PostFinder;
use Modules\Post\Domain\Service\PostUpdate;
use Modules\Post\Domain\Contract\PostRepository;
use UnitTest\Post\Domain\ValueObject\PostTitleMother;
use UnitTest\Post\Domain\ValueObject\PostContentMother;
use UnitTest\Shared\Domain\ValueObject\IdValueObjectMother;
use UnitTest\Shared\Domain\ValueObject\DateTimeValueObjectMother;
use UnitTest\Shared\Domain\ValueObject\SlugValueObjectMother;



/**
 * Summary of PostUpdateTest
 */
class PostUpdateTest extends PostTestCase
{
    /**
     * Summary of service
     * @var PostUpdate
     */
    protected PostUpdate $service;
    protected PostRepository|MockInterface $repository;
    protected PostFinder $finder;

    public function setUp(): void
    {
        unset($this->service, $this->repository, $this->finder);

        $this->repository = Mockery::mock(PostRepository::class);
        $this->finder = new PostFinder($this->repository);
        $this->service = new PostUpdate(
            $this->repository,
            $this->finder
        );

        parent::setUp();
    }

    /**
     * @doesNotPerformAssertions
     */
    public function shouldUpdatePostOk(): void
    {

        $unit = PostMother::dummy();

        $this->shouldFindOrFail($unit);
        $this->shouldFind($unit->toPrimitives());
        $this->shouldUpdateRepository();

        $this->service->__invoke(
            IdValueObjectMother::dummy(),
            PostTitleMother::dummy(),
            SlugValueObjectMother::dummy(),
            PostContentMother::dummy(),
            DateTimeValueObjectMother::dummy(),
        );
    }
}
