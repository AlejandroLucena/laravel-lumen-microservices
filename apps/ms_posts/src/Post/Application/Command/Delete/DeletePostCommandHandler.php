<?php

declare(strict_types=1);

namespace Modules\Post\Application\Command\Delete;

use Modules\Post\Domain\Service\PostDelete;
use Modules\Shared\Domain\ValueObject\IdValueObject;

/**
 * Summary of DeletePostCommandHandler
 */
class DeletePostCommandHandler
{
    public function __construct(
        private readonly PostDelete $postDelete,
    ) {
    }

    /**
     * Summary of handle
     *
     * @return IdValueObject
     */
    public function __invoke(
        DeletePostCommand $command
    ): void {
        $this->postDelete->__invoke(
            IdValueObject::from($command->id()),
        );
    }
}
