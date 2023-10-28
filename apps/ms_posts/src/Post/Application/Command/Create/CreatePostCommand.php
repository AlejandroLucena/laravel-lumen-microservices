<?php

declare(strict_types=1);

namespace Modules\Post\Application\Command\Create;

use Illuminate\Support\Str;
use Modules\Shared\Services\Commands\Command;

/**
 * Summary of CreatePostCommand
 */
class CreatePostCommand extends Command
{
    /**
     * Summary of __construct
     */
    public function __construct(
        private readonly string $title,
        private readonly ?string $slug,
        private readonly ?string $content,
    ) {
    }

    /**
     * Summary of title
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * Summary of slug
     */
    public function slug(): string
    {
        return $this->slug ? $this->slug : Str::slug($this->title);
    }

    /**
     * Summary of postcategoryId
     */
    public function content(): ?string
    {
        return $this->content ? $this->content : '';
    }
}
