<?php

namespace Uploadify\Upload;

use Illuminate\Contracts\Filesystem\Factory as Storage;
use Illuminate\Http\UploadedFile;

abstract class AbstractDriver
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
     * File instance
     *
     * @var mixed
     */
    protected $file;

    /**
     * Model instance
     *
     * @var object
     */
    protected $model;

    /**
     * Custom filename
     *
     * @var string
     */
    protected $name;

    /**
     * Custom extension
     *
     * @var string
     */
    protected $extension;

    /**
     * Create new driver instance
     *
     * @param  \Uploadify\Upload\Storage  $storage
     * @param  array  $settings
     * @return void
     */
    public function __construct(Storage $storage, array $settings = [])
    {
        $this->storage = $storage;
        $this->settings = $settings;
    }

    /**
     * Set model
     *
     * @param  object  $model
     * @return $this
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Set file name and extension
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @return $this
     */
    public function setFileInfo(UploadedFile $file)
    {
        $this->setName(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $this->setExtension($file->getClientOriginalExtension());

        return $this;
    }

    /**
     * Set custom file name
     *
     * @param  string  $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = str_slug($name);

        return $this;
    }

    /**
     * Set custom file extension
     *
     * @param  string  $extension
     * @return $this
     */
    public function setExtension($extension)
    {
        $this->extension = strtolower($extension);

        return $this;
    }

    /**
     * Rename file if exists
     *
     * @param  string  $path
     * @param  string  $filename
     * @param  string  $extension
     * @return string
     */
    protected function rename($path, $filename, $extension)
    {
        $name = $filename.'.'.$extension;

        $i = 1;
        while($this->storage->disk($this->getDisk())->exists($path.$name)) {
            $name = $filename.'-'.$i.'.'.$extension;

            $i++;
        }

        return $name;
    }

    /**
     * Create directory including sub-directories if does not exists
     *
     * @param  string  $path
     * @return void
     */
    protected function createDirectory($path)
    {
        if (! $this->storage->disk($this->getDisk())->exists($path)) {
            $this->storage->disk($this->getDisk())->makeDirectory($path);
        }
    }

    /**
     * Get storage disk name from model
     *
     * @return string|null
     */
    protected function getDisk()
    {
        return $this->model->getDisk();
    }
}
