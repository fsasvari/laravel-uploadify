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
    | Slug Separator
    |--------------------------------------------------------------------------
    |
    | Separator that will be used when generating slug from image name after
    | upload. Example: "Avatar IMAGE 22.jpg" => "avatar-image-22.jpg".
    |
    */

    'slug_separator' => '-',

];
