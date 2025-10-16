<?php

namespace Przwl\MultiSourceFileUpload;

use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Support\ServiceProvider;


class MultiSourceFileUploadServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        
        $this->registerTabMacro();

        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'multi-source-file-upload');

        // $this->publishes([
        //     __DIR__.'/../resources/views' => resource_path('views/vendor/multi-source-file-upload'),
        // ], 'views');

        // $this->publishes([
        //     __DIR__.'/../config/multi-source-file-upload.php' => config_path('multi-source-file-upload.php'),
        // ], 'config');

        // $this->mergeConfigFrom(
        //     __DIR__.'/../config/multi-source-file-upload.php', 'multi-source-file-upload'
        // );
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

    public function registerTabMacro()
    {
        Tab::macro('monitorFileUpload', function (?string $tabToHide = null, int $pollInterval = 50) {
            return $this->extraAttributes(function() use($tabToHide, $pollInterval){
                $targetLabel = $tabToHide ?? $this->getLabel();

                return [
                    'x-init' => "setInterval(() => { 
                        const f = document.querySelector('.filepond--file'); 
                        const t = Array.from(document.querySelectorAll('button[role=\\'tab\\']'))
                            .find(b => b.textContent.includes('{$targetLabel}')); 
                        if (t) t.style.display = f ? 'none' : 'flex'; 
                    }, $pollInterval)",
                ];
            });
        });
    }
}