<?php

declare(strict_types=1);

namespace Modules\Post\Domain\Exception;

use InvalidArgumentException;
use Modules\Shared\Domain\ValueObject\IdValueObject;
use Modules\Shared\Domain\ValueObject\SlugValueObject;

final class NotFound extends InvalidArgumentException
{
    public static function with(IdValueObject $id): NotFound
    {
        return new self(\sprintf('Post with id %s cannot be found.', $id->value()));
    }

    public static function withSlug(SlugValueObject $slug): NotFound
    {
        return new self(\sprintf('Post with slug %s cannot be found.', $slug->value()));
    }
}
