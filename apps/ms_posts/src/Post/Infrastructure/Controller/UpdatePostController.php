<?php

declare(strict_types=1);

namespace Modules\Post\Infrastructure\Controller;

use Modules\Post\Application\Command\Update\UpdatePostCommand;
use Illuminate\Http\Request;
use Modules\Shared\Infrastructure\Controller;
use Modules\Shared\Services\Commands\CommandBus;

class UpdatePostController extends Controller
{
    public function __construct(
        private readonly CommandBus $commandBus
    ) {
    }

    public function __invoke(Request $request, int $id)
    {
        $title = $request->input('title');
        $slug = $request->input('slug');
        $postcategoryId = intval($request->input('postcategory'));
        $content = $request->input('content') ? $request->input('content') : '';

        $this->commandBus->dispatch(new UpdatePostCommand(
            $id,
            $title,
            $slug,
            $postcategoryId,
            $content,
        ));

    }
}
