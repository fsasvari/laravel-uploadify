<?php

namespace Uploadify\Casts;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

abstract class Cast
{
    /**
     * The full file name with extension
     *
     * @var string
     */
    protected $name;

    /**
     * The path to file
     *
     * @var string
     */
    protected $path;

    /**
     * The filesystems disk name
     *
     * @var string
     */
    protected $disk;

    /**
     * Create new cast instance
     *
     * @param  string  $name  The full file name with extension
     * @param  array  $settings  List of settings => path, path_thumb, disk...
     * @return void
     */
    public function __construct($name, array $settings = [])
    {
        $this->name = $name;
        $this->saveSettings($settings);
    }

    /**
     * Save setting values from array
     *
     * @param  array  $settings
     * @return void
     */
    protected function saveSettings(array $settings = [])
    {
        $this->setPath(array_has($settings, 'path') ? $settings['path'] : '');
        $this->setDisk(array_has($settings, 'disk') ? $settings['disk'] : null);
    }

    /**
     * Set path value
     *
     * @param  string  $path
     * @return void
     */
    protected function setPath($path)
    {
        $this->path = trim($path, '/');
    }

    /**
     * Set disk value
     *
     * @param  string  $disk
     * @return void
     */
    protected function setDisk($disk = null)
    {
        $this->disk = $disk ?: Config::get('uploadify.disk');
    }

    /**
     * Get file name with extension
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Get file base name without extension
     *
     * @return string
     */
    public function basename()
    {
        return pathinfo($this->name(), PATHINFO_FILENAME);
    }

    /**
     * Get file extension
     *
     * @return string
     */
    public function extension()
    {
        return pathinfo($this->name(), PATHINFO_EXTENSION);
    }

    /**
     * Get file size in bytes
     *
     * @return string
     */
    public function filesize()
    {
        return $this->getStorage()->size($this->path().DIRECTORY_SEPARATOR.$this->name());
    }

    /**
     * Get path
     *
     * @return string
     */
    public function path()
    {
        return $this->path;
    }

    /**
     * Delete file from filesystem
     *
     * @return bool
     */
    public function delete()
    {
        return $this->getStorage()->delete($this->path().DIRECTORY_SEPARATOR.$this->name());
    }

    /**
     * Get filesystems storage
     *
     * @return \Illuminate\Contracts\Filesystem\Filesystem
     */
    protected function getStorage()
    {
        return Storage::disk($this->getDisk());
    }

    /**
     * Get filesystem disk name
     *
     * @return string
     */
    protected function getDisk()
    {
        return $this->disk;
    }

    /**
     * Get file name with extension
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name();
    }
}
