<?php

namespace UserManagementModule\Providers;

use Illuminate\Support\ServiceProvider;
use Nikitinuser\LaravelMakeAllExtended\Commands\MakeAllCommand;

class LaravelMakeAllExtendedProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //   
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeAllCommand::class,
            ]);
        }
    }
}
