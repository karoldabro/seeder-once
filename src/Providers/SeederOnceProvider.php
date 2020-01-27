<?php

namespace Kdabrow\SeederOnce\Providers;

use Illuminate\Support\ServiceProvider;
use Kdabrow\SeederOnce\Commands\SeedOnceCommand;

class SeederOnceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                SeedOnceCommand::class
            ]);
        }
    }
}
