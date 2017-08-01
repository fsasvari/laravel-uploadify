<?php

namespace Uploadify\Facades;

use Illuminate\Support\Facades\Facade;

class Uploadify extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'uploadify';
    }
}