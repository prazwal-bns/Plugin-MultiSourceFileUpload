# Multi Source File Upload

A Filament plugin that enables multi-source file uploads, allowing users to upload files either from their device or via a URL.  
Supports conditional required fields and only-image upload restrictions.

---

## Features

- **Upload files** from your device or **provide a direct URL**.
- Tabs UI for toggling between upload sources.
- Conditional required validation for both file and URL fields.
- Optionally restrict uploads to images only.
- Monitors file upload to hide/show tabs dynamically.
- Configurable labels, icons, and polling intervals.

---

## Installation

```bash
composer require przwl/multi-source-file-upload
```

If you are using Laravel < 10 or not using package discovery, add the service provider:

```php
// config/app.php

'providers' => [
    ...
    Przwl\MultiSourceFileUpload\MultiSourceFileUploadServiceProvider::class,
],
```

---

## Configuration

Optionally publish the config:

```bash
php artisan vendor:publish --tag="config" --provider="Przwl\MultiSourceFileUpload\MultiSourceFileUploadServiceProvider"
```

You can customize:
- Poll interval (`poll_interval`)
- Labels (`labels.file_upload`, `labels.url_upload`)
- Icons (`icons.file_upload`, `icons.url_upload`)

```php
// config/multi-source-file-upload.php

return [
    'poll_interval' => 50, // ms
    'labels' => [
        'file_upload' => 'File Upload',
        'url_upload' => 'URL Upload',
    ],
    'icons' => [
        'file_upload' => 'heroicon-o-arrow-up-tray',
        'url_upload' => 'heroicon-o-globe-alt',
    ]
];
```

---

## Usage

In your Filament form, use the `MultiSourceFileUpload` component.

```php
use Przwl\MultiSourceFileUpload\Components\MultiSourceFileUpload;

// Basic usage
MultiSourceFileUpload::make('attachment', 'attachment_url'),

// Make the upload required
MultiSourceFileUpload::make('attachment', 'attachment_url')->required(),

// Restrict to only images
MultiSourceFileUpload::make('photo', 'photo_url')->image()
```

Both "file" and "url" tabs are coordinated: uploading a file clears the URL; supplying a URL clears the file field.

---

## How It Works

- The plugin uses a **Tabs** interface for "File" and "URL" upload.
- When a file is uploaded, the URL field is disabled, and vice versa.
- Only one source can be filled at a time.
- Uses Alpine.js for hiding the tab when a file upload is detected.
- Poll interval for DOM updates is configurable in the config.

---

## Advanced

You can customize required logic or column span (see the implementation for details):

```php
MultiSourceFileUpload::make('attachment', 'attachment_url')
    ->required(fn () => ... )
    ->image();
```

---

## License

MIT

---

