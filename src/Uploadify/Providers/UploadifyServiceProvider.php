<?php

namespace Uploadify\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Contracts\Filesystem\Factory as Storage;
use Illuminate\Config\Repository as Config;
use Uploadify\Upload\Uploadify;

class UploadifyServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/uploadify.php' => config_path('uploadify.php'),
        ], 'uploadify');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/uploadify.php', 'uploadify'
        );

        $this->app->singleton(Uploadify::class, function ($app) {
            $config = $app->make(Config::class);

            return new Uploadify($app->make(Storage::class), $config->get('uploadify'));
        });
    }
}
