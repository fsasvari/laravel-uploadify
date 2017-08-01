<?php

namespace Uploadify\Upload;

use Illuminate\Contracts\Filesystem\Factory as Storage;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Image as InterventionImage;

use Uploadify\Exceptions\InvalidDriverException;

class UploadManager
{
    /**
     * The filesystem factory instance
     *
     * @var \Illuminate\Contracts\Filesystem\Factory
     */
    protected $storage;

    /**
     * The list of configuration data
     *
     * @var array
     */
    protected $config;

    /**
     * Create new upload manager instance
     *
     * @param  \Illuminate\Contracts\Filesystem\Factory  $storage
     * @param  array  $config
     * @return void
     */
    public function __construct(Storage $storage, array $config = [])
    {
        $this->storage = $storage;
        $this->config = $config;
    }

    /**
     * Return driver instance
     *
     * @param  string  $driver
     * @return \Uploadify\Upload\AbstractDriver|\Uploadify\Upload\DriverInterface
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
     * @return \Uploadify\Upload\AbstractDriver|\Uploadify\Upload\DriverInterface
     */
    private function createDriver($driver)
    {
        $name = studly_case($driver);
        $class = '\\Uploadify\\Upload\\Driver\\'.$name;

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
     * @return \Uploadify\Upload\AbstractDriver|\Uploadify\Upload\DriverInterface
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
