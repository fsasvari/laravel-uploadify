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
    | Default Thumbnail Folder Suffix
    |--------------------------------------------------------------------------
    |
    | Default suffix for path to thumbnail folder. Example: if "path" is set to
    | "upload/images/logo/" and "path_thumb_suffix" is set to "thumb/",
    | "path_thumb" will be "upload/images/logo/thumb/".
    |
    */

    'path_thumb_suffix' => 'thumb/',

    /*
    |--------------------------------------------------------------------------
    | Thumbnail Name Mask
    |--------------------------------------------------------------------------
    |
    | Thumbnail name mask for images is consisted of "name", "width" and
    | "height" parameters. This mask will be used for generating url and for
    | creating route to image thumbnail.
    |
    */

    'name_thumb_mask' => '{name}-w{width}-h{height}',

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
