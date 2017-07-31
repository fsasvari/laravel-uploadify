<?php

namespace Uploadify\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Contracts\Filesystem\Factory as Storage;
use Uploadify\Upload\UploadManager;

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
        ]);
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

        $this->app->singleton(UploadManager::class, function ($app) {
            return new UploadManager($app->make(Storage::class));
        });
    }
}
