<?php

declare(strict_types=1);

namespace Modules\Post\Application\Query;

use Modules\Post\Domain\Contract\PostRepository;

final class FindAllPostsSelector
{
    public function __construct(private readonly PostRepository $repository)
    {
    }

    public function __invoke()
    {
        return $this->repository->findAllSelector();
    }
}
