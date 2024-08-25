<?php

namespace Nikitinuser\LaravelMakeAllExtended\Providers;

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
        $this->publishes([
            __DIR__ . '/../make_all_extended.php' => config_path('make_all_extended.php'),
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeAllCommand::class,
            ]);
        }
    }
}
