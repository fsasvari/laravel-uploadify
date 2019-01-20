<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Uploadify Routes
|--------------------------------------------------------------------------
*/

Route::get('{path}/{options}/{name}.{extension?}', '\Uploadify\Http\Controllers\ImageController@show')
    ->where('path', '[a-z-/]+')
    ->where('options', '[a-z0-9-_,]+')
    ->where('name', '.+?')
    ->where('extension', 'jpe?g|gif|png|JPE?G|GIF|PNG');
