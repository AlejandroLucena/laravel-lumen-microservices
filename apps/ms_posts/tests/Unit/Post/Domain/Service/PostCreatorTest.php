<?php

namespace UnitTest\Post\Domain\Service;

use Mockery;
use Mockery\MockInterface;
use UnitTest\Post\PostMother;
use UnitTest\Post\PostTestCase;
use Modules\Post\Domain\Service\PostFinder;
use Modules\Post\Domain\Service\PostCreator;
use Modules\Post\Domain\Contract\PostRepository;
use Modules\Post\Domain\Exception\AlreadyExists;
use Modules\Post\Domain\Exception\AlreadyExistsSlug;
use Modules\Post\Domain\Exception\NotFound;
use Modules\Shared\Domain\Exception\InvalidValueException;
use UnitTest\Post\Domain\ValueObject\PostTitleMother;
use UnitTest\Post\Domain\ValueObject\PostContentMother;
use UnitTest\Shared\Domain\ValueObject\IdValueObjectMother;
use UnitTest\Shared\Domain\ValueObject\DateTimeValueObjectMother;
use UnitTest\Shared\Domain\ValueObject\SlugValueObjectMother;



/**
 * Summary of PostCreatorTest
 */
class PostCreatorTest extends PostTestCase
{
    /**
     * Summary of postCreator
     * @var PostCreator
     */
    protected PostCreator $postCreator;
    protected PostRepository|MockInterface $postRepository;
    protected PostFinder|MockInterface $postFinder;

    public function setUp(): void
    {
        unset($this->postCreator, $this->postRepository, $this->postFinder);

        $this->postRepository = Mockery::mock(PostRepository::class);
        $this->postFinder = new PostFinder($this->postRepository);
        $this->postCreator = new PostCreator(
            $this->postRepository,
            $this->postFinder
        );

        parent::setUp();
    }

    /**
     * @test
     * @return void
     */
    public function shouldCreatePostOk(): void
    {
        $this->shouldNotFindOtherSlug();

        $this->shouldSaveRepository();

        $this->expectNotToPerformAssertions();

        $this->postCreator->__invoke(
            PostTitleMother::dummy(),
            SlugValueObjectMother::dummy(),
            PostContentMother::dummy(),
            DateTimeValueObjectMother::dummy(),
        );
    }

    /**
     * @test
     * @return void
     */
    public function shouldCreatePostOkWithoutSlug(): void
    {
        $this->shouldNotFindOtherSlug();

        $this->expectException(InvalidValueException::class);

        $this->postCreator->__invoke(
            PostTitleMother::dummy(),
            SlugValueObjectMother::empty(),
            PostContentMother::dummy(),
            DateTimeValueObjectMother::dummy(),
        );
    }
    
    /**
     * @test
     * @return void
     */
    public function shouldCreatePostKoWithoutTitle(): void
    {
        $this->shouldNotFindOtherSlug();

        $this->expectException(InvalidValueException::class);

        $this->postCreator->__invoke(
            PostTitleMother::empty(),
            SlugValueObjectMother::empty(),
            PostContentMother::dummy(),
            DateTimeValueObjectMother::dummy(),
        );
    }

    /**
     * @test
     * @return void
     */
    public function shouldCreatePostKoAlreadyExistsSlug(): void
    {
        $this->shouldFindSlugFails();

        $this->expectException(AlreadyExists::class);

        $this->postCreator->__invoke(
            PostTitleMother::dummy(),
            SlugValueObjectMother::dummy(),
            PostContentMother::dummy(),
            DateTimeValueObjectMother::dummy(),
        );
    }

    
}
