<?php

namespace Przwl\MultiSourceFileUpload\Components;

use Closure;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Tabs;

class MultiSourceFileUpload extends Component
{
    // Configurable properties
    protected string $fileFieldName = '';
    protected string $urlFieldName = '';
    protected bool | Closure $required = false;
    protected bool | Closure $imageOnly = false;

    
    public static function make(string $fileFieldName, string $urlFieldName): static
    {
        $instance = app(static::class);

        $instance->fileFieldName = $fileFieldName;
        $instance->urlFieldName = $urlFieldName;

        return $instance;
    }


    // Fluent API methods (return $this for chaining)
    public function image(bool $condition = true): static
    {
        $this->imageOnly = $condition;
        return $this;
    }
    

    public function required(bool | Closure $condition = true): static
    {
        $this->required = $condition;
        return $this;
    }


    protected function getChildComponents(): array
    {
        $fileFieldName = $this->fileFieldName;
        $urlFieldName = $this->urlFieldName;
        $required = $this->evaluate($this->required);
        $imageOnly = $this->evaluate($this->imageOnly);

        $fileUpload = FileUpload::make($fileFieldName)
                ->required(fn($get) => empty($get($urlFieldName)) && $required);

        if ($imageOnly) {
            $fileUpload->image();
        }

        return [
            Tabs::make('upload_options')
                ->tabs([
                    Tabs\Tab::make('file_tab')
                        ->label(config('multi-source-file-upload.labels.file_upload'))
                        ->icon(config('multi-source-file-upload.icons.file_upload'))
                        ->schema([
                            $fileUpload,
                        ])
                        ->live(),
                    Tabs\Tab::make('url_tab')
                        ->label(config('multi-source-file-upload.labels.url_upload'))
                        ->icon(config('multi-source-file-upload.icons.url_upload'))
                        ->schema([
                            TextInput::make($urlFieldName)
                                ->url()
                                ->live()
                                ->required(fn($get) => empty($get($fileFieldName)) && $required)
                                ->afterStateUpdated(function ($state, $set) use ($fileFieldName) {
                                    if (!empty($state)) {
                                        $set($fileFieldName, null);
                                    }
                                })
                        ])
                        ->live()
                        ->monitorFileUpload()
                ])
                ->columnSpanFull(),
        ];
    }
}