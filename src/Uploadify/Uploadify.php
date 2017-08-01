<?php

namespace Uploadify;

use Illuminate\Contracts\Filesystem\Factory as Storage;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Image as InterventionImage;

use Uploadify\Exceptions\InvalidDriverException;

class Uploadify
{
    /**
     * The filesystem factory instance
     *
     * @var \Illuminate\Contracts\Filesystem\Factory
     */
    protected $storage;

    /**
     * The list of settings
     *
     * @var array
     */
    protected $settings = [];

    /**
     * Create new uploadify instance
     *
     * @param  \Illuminate\Contracts\Filesystem\Factory  $storage
     * @param  array  $settings
     * @return void
     */
    public function __construct(Storage $storage, array $settings = [])
    {
        $this->storage = $storage;
        $this->settings = $settings;
    }

    /**
     * Return driver instance
     *
     * @param  string  $driver
     * @return \Uploadify\AbstractDriver|\Uploadify\Contracts\DriverInterface
     */
    public function driver($driver)
    {
        return $this->createDriver($driver);
    }

    /**
     * Create new driver instance
     *
     * @param  string  $driver
     * @throws \Uploadify\Exceptions\InvalidDriverException
     * @return \Uploadify\AbstractDriver|\Uploadify\Contracts\DriverInterface
     */
    private function createDriver($driver)
    {
        $name = studly_case($driver);
        $class = '\\Uploadify\\Driver\\'.$name;

        if (! class_exists($class)) {
            throw new InvalidDriverException('Driver "'.$class.'" does not exists!');
        }

        return new $class($this->storage);
    }

    /**
     * Set file source and create new driver instance
     *
     *
     * @param  \Illuminate\Http\UploadedFile|\Intervention\Image\Image  $file
     * @throws \Uploadify\Exceptions\InvalidDriverException
     * @return \Uploadify\AbstractDriver|\Uploadify\Contracts\DriverInterface
     */
    public function setFile($file)
    {
        if ($file instanceof UploadedFile) {
            return $this->driver('file')->setFile($file);
        }

        if ($file instanceof InterventionImage) {
            return $this->driver('image')->setFile($file);
        }

        throw new InvalidDriverException('Driver "'.get_class($file).'" does not exists!');
    }
}
