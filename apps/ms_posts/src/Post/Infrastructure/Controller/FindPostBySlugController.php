<?php

declare(strict_types=1);

namespace Modules\Post\Infrastructure\Controller;

use Modules\Post\Application\Query\FindPostBySlug;
use Modules\Post\Domain\Contract\PostRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

final class FindPostBySlugController
{
    public function __construct(
        private readonly PostRepository $repository
    ) {
    }

    public function __invoke(Request $request)
    {
        $slug = $request->input('slug') ? $request->input('slug') : Str::slug($request->input('title'));
        $service = new FindPostBySlug($this->repository);

        return $service->__invoke(
            $slug
        );
    }
}
