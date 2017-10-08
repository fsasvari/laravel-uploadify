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
        $this->setModelInfo();
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

        throw new InvalidSourceException('Unknown source type! File source must be from UploadedFile, url or path.');
    }

    /**
     * Set file name and extension
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @return void
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
     * Set file name with extension on model field
     *
     * @return void
     */
    protected function setModelInfo()
    {
        $this->model->{$this->field} = $this->name.'.'.$this->extension;
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
     * Delete file or image
     *
     * @param  object  $model
     * @param  string  $type  file/image
     * @param  string|null  $disk
     * @return bool
     */
    public function delete()
    {
        return $this->getFieldCast()->delete();
    }

    /**
     * Copy file from source folder to destination folder
     *
     * @return bool
     */
    protected function uploadFromPath()
    {
        $path = $this->storage->disk($this->getDisk())->getDriver()->getAdapter()->getPathPrefix();

        return copy($this->source, $path.DIRECTORY_SEPARATOR.$this->getPath().DIRECTORY_SEPARATOR.$this->name.'.'.$this->extension);
    }

    /**
     * Download file from url and put on destination folder
     *
     * @return bool
     */
    protected function uploadFromUrl()
    {
        $contents = file_get_contents($this->source);

        return $this->storage->disk($this->getDisk())->put($this->getPath().DIRECTORY_SEPARATOR.$this->name.'.'.$this->extension, $contents);
    }

    /**
     *
     * @return type
     */
    protected function uploadFromUploadedFile()
    {
        $options = [
            'disk' => $this->getDisk(),
        ];

        return $this->source->storeAs($this->getPath(), $this->name.'.'.$this->extension, $options);
    }

    /**
     * Rename file if exists
     *
     * @return string
     */
    protected function rename()
    {
        $name = $this->name.'.'.$this->extension;

        $i = 1;
        while ($this->storage->disk($this->getDisk())->exists($this->getPath().DIRECTORY_SEPARATOR.$name)) {
            $name = $this->name.'-'.$i.'.'.$this->extension;

            $i++;
        }

        $this->setName(rtrim($name, '.'.$this->extension));
        $this->setModelInfo();

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
        return $this->getFieldCast()->disk();
    }

    /**
     * Get path from model
     *
     * @return string|null
     */
    protected function getPath()
    {
        return $this->getFieldCast()->path();
    }

    /**
     * Get field cast
     *
     * @return \Uploadify\Casts\Cast
     */
    protected function getFieldCast()
    {
        return $this->model->{$this->field};
    }
}
