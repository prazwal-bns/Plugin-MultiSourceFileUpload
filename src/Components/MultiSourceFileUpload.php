<?php

namespace Przwl\MultiSourceFileUpload\Components;

use Closure;
use Filament\Forms\Components\Component;

class MultiSourceFileUpload extends Component
{
    // Configurable properties
    protected string $fileFieldName = '';
    protected string $urlFieldName = '';
    protected bool | Closure $required = false;
    protected bool | Closure $imageOnly = false;

    
    
    // factory method
    public static function make(string $fileFieldName, string $urlFieldName): static
    {
        $instance = app(static::class);

        $instance->fileFieldName = $fileFieldName;
        $instance->urlFieldName = $urlFieldName;

        return $instance;
    }
}