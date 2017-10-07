<?php

namespace Uploadify;

use Illuminate\Contracts\Filesystem\Factory as Storage;
use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Http\UploadedFile;
use Uploadify\Exceptions\InvalidSourceException;

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
     * File source type
     *
     * @var string
     */
    protected $sourceType;

    /**
     * File source
     *
     * @var mixed
     */
    protected $source;

    /**
     * Eloquent model instance
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Name of uploadify field
     *
     * @var string
     */
    protected $field;

    /**
     * File basename
     *
     * @var string
     */
    protected $name;

    /**
     * File extension
     *
     * @var string
     */
    protected $extension;

    /**
     * Create new driver instance
     *
     * @param  \Illuminate\Contracts\Filesystem\Factory  $storage
     * @param  array  $settings
     * @param  mixed  $source
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $field
     * @return void
     */
    public function __construct(Storage $storage, array $settings, $source, Eloquent $model, $field)
    {
        $this->storage = $storage;
        $this->settings = $settings;
        $this->sourceType = $this->getSourceType($source);
        $this->source = $source;
        $this->model = $model;
        $this->field = $field;

        $this->setFileInfo();
    }

    /**
     * Get source type
     *
     * @param  mixed  $source
     * @return string
     * @throws \Uploadify\Exceptions\InvalidSourceException
     */
    protected function getSourceType($source)
    {
        if ($source instanceof UploadedFile) {
            return 'uploadedfile';
        }

        if (filter_var($source, FILTER_VALIDATE_URL)) {
            return 'url';
        }

        if (file_exists($source)) {
            return 'path';
        }

        throw new InvalidSourceException('Unknown source type!');
    }

    /**
     * Set file name and extension
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @return $this
     */
    protected function setFileInfo()
    {
        switch ($this->sourceType) {
            case 'path': case 'url':
                $this->setName(pathinfo($this->source, PATHINFO_FILENAME));
                $this->setExtension(pathinfo($this->source, PATHINFO_EXTENSION));
                break;

            case 'uploadedfile':
                $this->setName(pathinfo($this->source->getClientOriginalName(), PATHINFO_FILENAME));
                $this->setExtension($this->source->getClientOriginalExtension());
                break;
        }
    }

    /**
     * Set file name
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
     * Set file extension
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
        while ($this->storage->disk($this->getDisk())->exists($path.$name)) {
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
}
