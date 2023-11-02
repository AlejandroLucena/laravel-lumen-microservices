<?php

declare(strict_types=1);

namespace Modules\Post\Application\Command\Create;

use Modules\Post\Domain\Service\PostCreator;
use Modules\Post\Domain\ValueObject\PostContent;
use Modules\Post\Domain\ValueObject\PostTitle;
use Illuminate\Support\Str;
use Modules\Shared\Domain\ValueObject\DateTimeValueObject;
use Modules\Shared\Domain\ValueObject\SlugValueObject;

/**
 * Summary of CreatePostCommandHandler
 */
class CreatePostCommandHandler
{
    public function __construct(
        private readonly PostCreator $postCreator
    ) {
    }

    /**
     * Summary of handle
     *
     * @return void
     */
    public function __invoke(
        CreatePostCommand $command
    ): void {
        $this->postCreator->__invoke(
            PostTitle::from($command->title()),
            $command->slug() ? SlugValueObject::from($command->slug()) : SlugValueObject::from(Str::slug($command->title())),
            PostContent::from($command?->content()),
            DateTimeValueObject::now()
        );
    }
}
