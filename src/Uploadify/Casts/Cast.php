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
     * The attributes that should be mutated to uploadify files.
     *
     * @var array
     */
    protected $files = [];

    /**
     * The attributes that should be mutated to uploadify images.
     *
     * @var array
     */
    protected $images = [];

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
        if (isset($settings['path'])) {
            $this->path = $settings['path'];
        }

        if (isset($settings['disk'])) {
            $this->disk = $settings['disk'];
        }
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
        return $this->getStorage()->size($this->path().$this->name());
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
        return $this->getStorage()->delete($this->url());
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
        if ($this->disk) {
            return $this->disk;
        }

        if (Config::has('uploadify.disk')) {
            return Config::get('uploadify.disk');
        }

        return Config::get('uploadify.filesystems.default');
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
