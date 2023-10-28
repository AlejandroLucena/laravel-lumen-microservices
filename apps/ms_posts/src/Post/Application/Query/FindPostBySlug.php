<?php

declare(strict_types=1);

namespace Modules\Post\Application\Query;

use Modules\Post\Domain\Contract\PostRepository;
use Modules\Shared\Domain\ValueObject\SlugValueObject;

final class FindPostBySlug
{
    public function __construct(
        private readonly PostRepository $repository
    ) {
    }

    public function __invoke(string $slug): ?array
    {
        $slugValue = SlugValueObject::from($slug);

        return $this->repository->findBySlug($slugValue);
    }
}
