<?php

namespace UnitTest\Post\Domain\Service;

use Mockery;
use Mockery\MockInterface;
use UnitTest\Post\PostMother;
use UnitTest\Post\PostTestCase;
use Modules\Post\Domain\Service\PostFinder;
use Modules\Post\Domain\Service\PostUpdater;
use Modules\Post\Domain\Contract\PostRepository;
use Modules\Post\Domain\Exception\AlreadyExistsSlug;
use Modules\Post\Domain\Exception\NotFound;
use UnitTest\Post\Domain\ValueObject\PostTitleMother;
use UnitTest\Post\Domain\ValueObject\PostContentMother;
use UnitTest\Shared\Domain\ValueObject\IdValueObjectMother;
use UnitTest\Shared\Domain\ValueObject\DateTimeValueObjectMother;
use UnitTest\Shared\Domain\ValueObject\SlugValueObjectMother;



/**
 * Summary of PostUpdaterTest
 */
class PostUpdaterTest extends PostTestCase
{
    /**
     * Summary of postUpdater
     * @var PostUpdater
     */
    protected PostUpdater $postUpdater;
    protected PostRepository|MockInterface $postRepository;
    protected PostFinder|MockInterface $postFinder;

    public function setUp(): void
    {
        unset($this->postUpdater, $this->postRepository, $this->postFinder);

        $this->postRepository = Mockery::mock(PostRepository::class);
        $this->postFinder = new PostFinder($this->postRepository);
        $this->postUpdater = new PostUpdater(
            $this->postRepository,
            $this->postFinder
        );

        parent::setUp();
    }

    
    /**
     * @test
     * @return void
     */
    public function shouldUpdatePostOk(): void
    {
        $post = PostMother::dummy();

        $this->shouldFind($post);
        $this->shouldNotFindOtherSlug();
        $this->shouldUpdateRepository();

        $this->expectNotToPerformAssertions();

        $this->postUpdater->__invoke(
            $post->id(),
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
    public function shouldUpdatePostKo(): void
    {
        $this->shouldNotFind();

        $this->expectException(NotFound::class);

        $this->postUpdater->__invoke(
            IdValueObjectMother::dummy(),
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
    public function shouldUpdatePostKoOtherSameSlug(): void
    {
        $post = PostMother::dummy();

        $this->shouldFind($post);
        $this->shouldFindOtherSlug($post->slug());

        $this->expectException(AlreadyExistsSlug::class);

        $this->postUpdater->__invoke(
            IdValueObjectMother::dummy(),
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
    public function shouldUpdatePostOkWithoutAllFields(): void
    {
        $post = PostMother::dummy();

        $this->shouldFind($post);
        $this->shouldNotFindOtherSlug();

        $this->shouldUpdateRepository();
        $this->expectNotToPerformAssertions();

        $this->postUpdater->__invoke(
            IdValueObjectMother::dummy(),
            PostTitleMother::dummy(),
            SlugValueObjectMother::dummy(),
            PostContentMother::empty(),
            DateTimeValueObjectMother::dummy(),
        );
    }
}
