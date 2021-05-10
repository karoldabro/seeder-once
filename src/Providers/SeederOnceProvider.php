<?php

namespace Kdabrow\SeederOnce\Providers;

use Illuminate\Support\ServiceProvider;
use Kdabrow\SeederOnce\Commands\InstallCommand;
use Kdabrow\SeederOnce\Contracts\SeederOnceRepositoryInterface;
use Kdabrow\SeederOnce\Repositories\SeederRepository;

class SeederOnceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom($this->pathToConfig() . 'seederonce.php', 'seederonce');

        $this->app->singleton(
            SeederOnceRepositoryInterface::class,
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
            ]);
        }

        $this->publishes([
            $this->pathToConfig() . 'seederonce.php' => $this->app->configPath('seederonce.php'),
        ], 'seederonce.config');
    }

    private function pathToConfig()
    {
        return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR;
    }
}
