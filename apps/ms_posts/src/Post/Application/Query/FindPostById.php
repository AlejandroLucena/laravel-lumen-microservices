<?php

declare(strict_types=1);

namespace Modules\Post\Application\Query;

use Modules\Post\Domain\Contract\PostRepository;
use Modules\Shared\Domain\ValueObject\IdValueObject;

final class FindPostById
{
    public function __construct(private readonly PostRepository $repository)
    {
    }

    public function __invoke(int $id): ?array
    {
        $id = IdValueObject::from((int) $id);

        return $this->repository->find($id);
    }
}
