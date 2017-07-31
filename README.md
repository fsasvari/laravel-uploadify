# Laravel Uploadify

Uploadify is a library for Laravel that handles image uploading with automatic renaming, showing thumbnail image with custom routes and more. All that is available over Eloquent models.

[![Build For Laravel](https://img.shields.io/badge/Built_for-Laravel-orange.svg)](https://styleci.io/repos/79834672)
[![Latest Stable Version](https://poser.pugx.org/fsasvari/laravel-uploadify/v/stable)](https://packagist.org/packages/fsasvari/laravel-uploadify)
[![Latest Unstable Version](https://poser.pugx.org/fsasvari/laravel-uploadify/v/unstable)](https://packagist.org/packages/fsasvari/laravel-uploadify)
[![Total Downloads](https://poser.pugx.org/fsasvari/laravel-uploadify/downloads)](https://packagist.org/packages/fsasvari/laravel-uploadify)
[![License](https://poser.pugx.org/fsasvari/laravel-uploadify/license)](https://packagist.org/packages/fsasvari/laravel-uploadify)

## Installation

### Step 1: Install package

To get started with Laravel Uploadify, execute Composer command to add the package to your composer.json project's dependencies:

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

### Step 2: Service Provider

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

### Step 3: Configuration



### Step 4: Models

There are two types of traits for Eloquent models - `FileTrait` and `ImageTrait`.

#### File Trait

If you need to show simple files (pdf, doc, zip...) in Eloquent model, you should use `Uploadify\Traits\FileTrait` trait. You need to define `$files` property with database field name as key and `path` as array value which is required.

```php
<?php

namespace App;

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

If you need to show images (jpg, png, gif...) in Eloquent model, you should use `Uploadify\Traits\ImageTrait` trait. You need to define `$images` property with database field name as key and paths as array values (`path` and `path_thumb`). `path` value is required, but `path_thumb` is not. Use `path_thumb` only if path to thumb images is different then default one (we always use `thumb/` prefix on defined `path` value).

```php
<?php

namespace App;

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
        'upload_cover' => ['path' => 'upload/images/cover/'],
        'upload_avatar' => ['path' => 'upload/images/avatar/', 'path_thumb' => 'upload/images/avatar-small/'],
    ];
}
```

#### File and Image Traits combined

You can also combine traits in one Eloquent model:

```php
<?php

namespace App;

use Uploadify\Traits\FileTrait;
use Uploadify\Traits\ImageTrait;

class Car extends Eloquent
{
    use FileTrait, ImageTrait;

    /**
     * List of uploadify files
     *
     * @var array
     */
    public $files = [
        'upload_information' => ['path' => 'upload/documents/information/'],
        'upload_specification' => ['path' => 'upload/documents/specification/'],
    ];

    /**
     * List of uploadify images
     *
     * @var array
     */
    public $images = [
        'upload_cover' => ['path' => 'upload/images/cover/'],
    ];
}
```

## Usage

### Files

```php
// To use this package, first we need an instance of our model
$car = Car::first();

// get full file name with extension
$cat->upload_specification->getName(); // car-specification.pdf

// get file basename
$cat->upload_specification->getBasename(); // car-specification

// get file extension
$cat->upload_specification->getExtension(); // pdf

// get file size in bytes
$cat->upload_specification->getFilesize(); // 1500000

// get full path to file
$car->upload_specification->getUrl(); // upload/documents/specification/car-specification.pdf
```

### Images

```php
// To use this package, first we need an instance of our model
$user = User::first();

// get full image name with extension
$cat->upload_avatar->getName(); // user-avatar.jpg

// get full image thumb name with extension
$cat->upload_avatar->getName(200, 200); // user-avatar-w200-h200.jpg

// get image basename
$cat->upload_avatar->getBasename(); // user-avatar

// get image thumb basename
$cat->upload_avatar->getBasename(200, 200); // user-avatar-w200-h200

// get file extension
$cat->upload_avatar->getExtension(); // jpg

// get image size in bytes
$cat->upload_avatar->getFilesize(); // 150000

// get full path to image
$car->upload_avatar->getUrl(); // upload/images/avatar/user-avatar.jpg

// get full path to image thumb
$car->upload_avatar->getUrl(200, 200); // upload/images/avatar/thumb/user-avatar-w200-h200.jpg
```