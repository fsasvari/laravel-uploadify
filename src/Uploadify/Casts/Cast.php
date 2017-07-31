<?php

namespace Uploadify\Casts;

abstract class Cast
{
    /**
     * The full file name with extension
     *
     * @var string
     */
    protected $name;

    /**
     * List of settings => path, path_thumb, disk...
     *
     * @var array
     */
    protected $settings = [];

    /**
     * Create new cast instance
     *
     * @param  string  $name  The full file name with extension
     * @param  array  $settings  List of settings => path, path_thumb, disk...
     * @return void
     */
    public function __construct($name, $settings)
    {
        $this->name = $name;
        $this->settings = $settings;
    }
}
