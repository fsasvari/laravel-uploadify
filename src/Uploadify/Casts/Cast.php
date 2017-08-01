<?php

namespace Uploadify\Casts;

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
        $this->path = $settings['path'];
        $this->disk = $settings['disk'];
    }

    /**
     * Get file extension
     *
     * @return string
     */
    public function getExtension()
    {
        return pathinfo($this->getName(), PATHINFO_EXTENSION);
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
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
        return Storage::disk($this->getDisk())->delete($this->getUrl());
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

        if (config()->has('uploadify.disk')) {
            return config()->get('uploadify.disk');
        }

        return config()->get('uploadify.filesystems.default');
    }
}
