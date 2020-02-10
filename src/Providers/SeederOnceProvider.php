<?php

namespace Kdabrow\SeederOnce\Providers;

use Illuminate\Support\ServiceProvider;
use Kdabrow\SeederOnce\Commands\InstallCommand;
use Kdabrow\SeederOnce\Commands\OnceCommand;
use Kdabrow\SeederOnce\Contracts\FilesLogRepositoryInterface;
use Kdabrow\SeederOnce\Repositories\SeederRepository;

class SeederOnceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . \DIRECTORY_SEPARATOR . 'seederonce.php',
            'seederonce'
        );

        $this->app->singleton(
            FilesLogRepositoryInterface::class,
            function ($app) {
                return new SeederRepository($app['db'], $app['config']['seederonce.table_name']);
            }
        );
    }

    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallCommand::class,
                OnceCommand::class,
            ]);
        }
    }
}
