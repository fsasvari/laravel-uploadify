# Laravel Uploadify

Uploadify is a library for Laravel that handles image uploading with automatic renaming, showing thumbnail image with custom routes and more.

[![Build For Laravel](https://img.shields.io/badge/Built_for-Laravel-orange.svg)](https://styleci.io/repos/79834672)
[![Latest Stable Version](https://poser.pugx.org/fsasvari/laravel-uploadify/v/stable)](https://packagist.org/packages/fsasvari/laravel-uploadify)
[![Latest Unstable Version](https://poser.pugx.org/fsasvari/laravel-uploadify/v/unstable)](https://packagist.org/packages/fsasvari/laravel-uploadify)
[![Total Downloads](https://poser.pugx.org/fsasvari/laravel-uploadify/downloads)](https://packagist.org/packages/fsasvari/laravel-uploadify)
[![License](https://poser.pugx.org/fsasvari/laravel-uploadify/license)](https://packagist.org/packages/fsasvari/laravel-uploadify)

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

```php
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

#### File Trait

If you need files, you should use trait `Uploadify\Traits\FileTrait`:

```php
use Uploadify\Traits\FileTrait;

class Car extends Eloquent
{
    use FileTrait;

    /**
     * List of uploadify files
     *
     * @var array
     */
    public $files = [
        'upload_information' => ['path' => 'upload/documents/information/'],
        'upload_specification' => ['path' => 'upload/documents/specification/'],
    ];
}
```

#### Image Trait

If you need images, you should use trait `Uploadify\Traits\ImageTrait`:

```php
use Uploadify\Traits\ImageTrait;

class User extends Eloquent
{
    use ImageTrait;

    /**
     * List of uploadify images
     *
     * @var array
     */
    public $images = [
        'upload_cover' => ['path' => 'upload/images/cover/', 'path_thumb' => 'upload/images/cover/thumb'],
        'upload_avatar' => ['path' => 'upload/images/avatar/', 'path_thumb' => 'upload/images/avatar/thumb'],
    ];
}
```