<?php

namespace Weishaypt\LavaRu;

use Illuminate\Support\ServiceProvider;

class LavaRuServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/lavaru.php' => config_path('lavaru.php'),
        ], 'config');

        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/lavaru.php', 'lavaru');

        $this->app->singleton('lavaru', function () {
            return $this->app->make(EnotIo::class);
        });

        $this->app->alias('lavaru', 'LavaRu');

        //
    }
}
