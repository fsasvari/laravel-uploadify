<?php

namespace Uploadify;

use Illuminate\Contracts\Filesystem\Factory as Storage;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Uploadify\Exceptions\InvalidDriverException;
use Uploadify\Exceptions\InvalidFieldException;

class UploadifyManager
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
     * Create new uploadify instance
     *
     * @param  \Illuminate\Http\UploadedFile|string  $file
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  \Uploadify\Uploadify  $field
     * @return \Uploadify\AbstractDriver|\Uploadify\Contracts\DriverInterface
     */
    public function create($file, Eloquent $model, $field)
    {
        $type = $this->getCastType($model, $field);

        return $this->createDriver($type, $file, $model, $field);
    }

    /**
     * Get uploadify cast type by model and field name
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model  $model
     * @param  string  $field
     * @throws \Uploadify\Exceptions\InvalidFieldException
     * @return string
     */
    private function getCastType(Eloquent $model, $field)
    {
        if ($model->hasFileCasts() && array_key_exists($field, $model->files)) {
            return 'file';
        } elseif ($model->hasImageCasts() && array_key_exists($field, $model->images)) {
            return 'image';
        }

        throw new InvalidFieldException('Field "'.$field.'" is not defined as Uploadify field!');
    }

    /**
     * Create new driver instance
     *
     * @param  string  $driver
     * @param  \Illuminate\Http\UploadedFile|string  $file
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $field
     * @throws \Uploadify\Exceptions\InvalidDriverException
     * @return \Uploadify\AbstractDriver|\Uploadify\Contracts\DriverInterface
     */
    private function createDriver($driver, $file, Eloquent $model, $field)
    {
        $name = studly_case($driver);
        $class = '\\Uploadify\\Driver\\'.$name;

        if (! class_exists($class)) {
            throw new InvalidDriverException('Driver "'.$class.'" does not exists!');
        }

        return new $class($this->storage, $file, $model, $field);
    }
}
