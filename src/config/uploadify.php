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
    | Image quality of processed images
    |--------------------------------------------------------------------------
    |
    | Set image quality of processed images from 0 to 100.
    |
    */

    'quality' => 85,

    /*
    |--------------------------------------------------------------------------
    | Path to processed images subfolder
    |--------------------------------------------------------------------------
    |
    | Default path to processed images subfolder. Example: if model path is set
    | to "images/logo" and "path" is set to "thumb", processed images folder
    | will be "images/logo/thumb".
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
