<?php

declare(strict_types=1);

namespace Modules\Post\Application\Command\Update;

use Modules\Post\Domain\Service\PostUpdater;
use Modules\Post\Domain\ValueObject\PostContent;
use Modules\Post\Domain\ValueObject\PostTitle;
use Illuminate\Support\Str;
use Modules\Shared\Domain\ValueObject\DateTimeValueObject;
use Modules\Shared\Domain\ValueObject\IdValueObject;
use Modules\Shared\Domain\ValueObject\SlugValueObject;

/**
 * Summary of UpdatePostCommandHandler
 */
class UpdatePostCommandHandler
{
    public function __construct(
        private readonly PostUpdater $postUpdater,
    ) {
    }

    /**
     * Summary of handle
     */
    public function __invoke(
        UpdatePostCommand $command
    ): void {

        $this->postUpdater->__invoke(
            $command->id() ? IdValueObject::from($command->id()) : null,
            $command->title() ? PostTitle::from($command->title()) : null,
            $command->slug() ? SlugValueObject::from($command->slug()) : SlugValueObject::from(Str::slug($command->title())),
            $command->content() ? PostContent::from($command->content()) : null,
            DateTimeValueObject::now(),
        );
    }
}
