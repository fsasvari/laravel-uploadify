<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the Uploadify package. If default filesystem disk is not provided,
    | package will use default filesystem from Laravel configuration.
    |
    */

    'disk' => 'public',

    /*
    |--------------------------------------------------------------------------
    | Default Thumbnail Folder
    |--------------------------------------------------------------------------
    |
    | Default suffix for path to thumbnail folder. Example: if "path" is set to
    | "upload/images/logo/", "path_thumb" will be "upload/images/logo/thumb/".
    |
    */

    'path_thumb_suffix' => 'thumb/',

    /*
    |--------------------------------------------------------------------------
    | Name Mask
    |--------------------------------------------------------------------------
    */

    'name_mask' => '{name}-w{width}-h{height}',

    /*
    |--------------------------------------------------------------------------
    | Name Separator
    |--------------------------------------------------------------------------
    |
    */

    'name_separator' => '-',

];
