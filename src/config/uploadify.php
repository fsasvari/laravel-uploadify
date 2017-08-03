<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the Uploadify package. If default filesystem disk is not provided,
    | or is null, package will use default filesystem from Laravel
    | configuration.
    |
    */

    'disk' => 'public',

    /*
    |--------------------------------------------------------------------------
    | Cache processed images
    |--------------------------------------------------------------------------
    |
    | Set "true" if you want to cache processed images.
    |
    */

    'cache' => true,

    /*
    |--------------------------------------------------------------------------
    | Path to processed images folder
    |--------------------------------------------------------------------------
    |
    | Default path to processed images folder. Example: if model path is set
    | to "images/logo" and "path" is set to "processed", processed images folder
    | will be "images/logo/processed".
    |
    */
    'path' => 'thumb',

    /*
    |--------------------------------------------------------------------------
    | Separator for generating slug from file name
    |--------------------------------------------------------------------------
    |
    | Separator that will be used when generating slug from file name after
    | upload. Example: "Avatar IMAGE 22.jpg" => "avatar-image-22.jpg".
    |
    */

    'separator' => '-',

];
