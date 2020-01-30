<?php

namespace Kdabrow\SeederOnce\Providers;

use Illuminate\Support\ServiceProvider;
use Kdabrow\SeederOnce\Commands\SeedOnceCommand;
use Kdabrow\SeederOnce\Contracts\SeederRepositoryInterface;
use Kdabrow\SeederOnce\Repositories\SeederRepository;
use Kdabrow\SeederOnce\Seeder;

class SeederOnceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            SeederRepositoryInterface::class,
            SeederRepository::class
        );
    }

    public function boot()
    {
        $this->loadMigrationsFrom(
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'migrations'
        );

        if ($this->app->runningInConsole()) {
            $this->commands([
                SeedOnceCommand::class
            ]);
        }
    }
}
