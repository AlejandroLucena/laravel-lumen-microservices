<?php

declare(strict_types=1);

use Mockery\MockInterface;
use Modules\Post\Application\Command\Update\UpdatePostCommand;
use UnitTest\Post\PostTestCase;
use Modules\Post\Domain\Service\PostUpdater;
use Modules\Post\Application\Command\Update\UpdatePostCommandHandler;
use Modules\Shared\Domain\Exception\InvalidValueException;
use UnitTest\Post\Domain\ValueObject\PostContentMother;
use UnitTest\Post\Domain\ValueObject\PostTitleMother;
use UnitTest\Shared\Domain\ValueObject\IdValueObjectMother;
use UnitTest\Shared\Domain\ValueObject\SlugValueObjectMother;

class UpdatePostCommandHandlerTest extends PostTestCase
{
    /**
     * Summary of postUpdater
     * @var UpdatePostCommandHandler
     */
    protected UpdatePostCommand|MockInterface $updatePostCommand;
    protected UpdatePostCommandHandler $updatePostCommandHandler;
    protected PostUpdater|MockInterface $postUpdater;

    public function setUp(): void
    {
        $this->postUpdater = $this->getMockBuilder(
            PostUpdater::class,
        )->disableOriginalConstructor()->getMock();

        parent::setUp();
    }

    /**
     * @test
     * @dataProvider validValues
     * @return void
     */
    public function testHandlerOk($validValues): void
    {
        $payload = json_decode($validValues, true, 512, JSON_THROW_ON_ERROR);

        $this->updatePostCommandHandler = new UpdatePostCommandHandler($this->postUpdater);
        
        $this->expectNotToPerformAssertions();
        
        $this->updatePostCommandHandler->__invoke(new UpdatePostCommand(
            ...$payload
        ));
    }
    
    public static function validValues()
    {
        return [
            [
                json_encode([
                    'id' => IdValueObjectMother::dummy()->value(),
                    'title' => PostTitleMother::dummy()->value(),
                    'slug' => SlugValueObjectMother::dummy()->value(),
                    'content' => PostContentMother::dummy()->value(),
                ])
            ],
            [
                json_encode([
                    'id' => IdValueObjectMother::dummy()->value(),
                    'title' => PostTitleMother::dummy()->value(),
                    'slug' => SlugValueObjectMother::dummy()->value(),
                    'content' => PostContentMother::empty()->value(),
                ])
            ],
        ];
    }

}