<?php

declare(strict_types=1);

namespace Modules\Post\Infrastructure\Controller;

use Modules\Post\Application\Command\Create\CreatePostCommand;
use Illuminate\Http\Request;
use Modules\Shared\Infrastructure\Controller;
use Modules\Shared\Services\Commands\CommandBus;

/**
 * Summary of CreatePostControlled
 */
class CreatePostController extends Controller
{
    public function __construct(
        private readonly CommandBus $commandBus
    ) {
    }

    /**
     * Summary of __invoke
     */
    public function __invoke(Request $request): void
    {
        $this->commandBus->dispatch(new CreatePostCommand(
            json_decode($request->getContent())->title,
            json_decode($request->getContent())->slug,
            json_decode($request->getContent())->content
        ));
    }
}
