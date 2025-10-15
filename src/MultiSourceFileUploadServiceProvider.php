<?php

namespace Przwl\MultiSourceFileUpload;

class MultiSourceFileUploadServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'multi-source-file-upload');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/multi-source-file-upload'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../config/multi-source-file-upload.php' => config_path('multi-source-file-upload.php'),
        ], 'config');

        $this->mergeConfigFrom(
            __DIR__.'/../config/multi-source-file-upload.php', 'multi-source-file-upload'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}