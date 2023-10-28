<?php

declare(strict_types=1);

namespace Modules\Shared\Infrastructure\Persistence\Provider;

use Modules\Post\Domain\Contract\PostRepository;
use Illuminate\Support\ServiceProvider;

class PersistenceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            'Modules\Post\Domain\Contract\PostRepository',
            'Modules\Post\Infrastructure\Persistence\Eloquent\EloquentPostRepository'
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            PostRepository::class,
        ];
    }
}
