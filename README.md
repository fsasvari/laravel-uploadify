# Laravel Uploadify

Uploadify is a library for Laravel that handles image uploading with automatic renaming, showing thumbnail image with custom routes and more.

## Installation

To get started with Laravel Uploadify, execute Composer command to add the package to your project's dependencies:

```
composer require fsasvari/laravel-uploadify
```

Or add it directly by copying next line into composer.json:

```
"fsasvari/laravel-uploadify": "0.1.*"
```

And then run composer update:

```
composer update
```

## Configuration

After installing the Laravel Trailing Slash library, register the `LaravelTrailingSlash\RoutingServiceProvider` in your `config/app.php` configuration file:

```
'providers' => [
    // Application Service Providers...
    // ...

    // Other Service Providers...
    Uploadify\Providers\UploadifyServiceProvider::class,
    // ...
],
```

## Usage

### Models

There are two types of traits for models - `FileTrait` and `ImageTrait`.
