<?php

namespace Uploadify\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Contracts\Filesystem\Factory as Storage;
use Illuminate\Config\Repository as Config;
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

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
		$this->app->singleton(UploadManager::class, function ($app) {
            return new UploadManager($app->make(Storage::class));
        });
    }
}
