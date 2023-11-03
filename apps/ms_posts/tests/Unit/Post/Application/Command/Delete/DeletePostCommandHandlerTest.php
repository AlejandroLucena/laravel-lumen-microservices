<?php

declare(strict_types=1);

use Mockery\MockInterface;
use Modules\Post\Application\Command\Delete\DeletePostCommand;
use UnitTest\Post\PostTestCase;
use Modules\Post\Domain\Service\PostRemover;
use Modules\Post\Application\Command\Delete\DeletePostCommandHandler;
use Modules\Shared\Domain\Exception\InvalidValueException;
use UnitTest\Post\Domain\ValueObject\PostContentMother;
use UnitTest\Post\Domain\ValueObject\PostTitleMother;
use UnitTest\Shared\Domain\ValueObject\SlugValueObjectMother;
use InvalidArgumentException;
use UnitTest\Shared\Domain\ValueObject\IdValueObjectMother;

class DeletePostCommandHandlerTest extends PostTestCase
{
    /**
     * Summary of postRemover
     * @var DeletePostCommandHandler
     */
    protected DeletePostCommand|MockInterface $deletePostCommand;
    protected DeletePostCommandHandler $deletePostCommandHandler;
    protected PostRemover|MockInterface $postRemover;

    public function setUp(): void
    {
        $this->postRemover = $this->getMockBuilder(
            PostRemover::class,
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

        $this->deletePostCommandHandler = new DeletePostCommandHandler($this->postRemover);

        $this->expectNotToPerformAssertions();

        $this->deletePostCommandHandler->__invoke(new DeletePostCommand(
            ...$payload
        ));
    }


    public static function validValues()
    {
        return [
            [
                json_encode([
                    'id' => IdValueObjectMother::dummy()->value(),
                ])
            ],
        ];
    }
}
