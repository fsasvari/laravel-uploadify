<?php

namespace Uploadify\Casts;

use Uploadify\Casts\Cast as BaseCast;

use Illuminate\Support\Facades\Storage;

class FileCast extends BaseCast
{
    /**
     * Get file name with extension
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get file base name without extension
     *
     * @return string
     */
    public function getBasename()
    {
        return pathinfo($this->getName(), PATHINFO_FILENAME);
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
     * Get file size in bytes
     *
     * @return string
     */
    public function getFilesize()
    {
        return Storage::disk($this->getDisk())->size($this->getName());
    }

    /**
     * Get full path to file
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->getPath().$this->getName();
    }

    /**
     * Get path to file
     *
     * @return string
     */
    protected function getPath()
    {
        return $this->settings['path'];
    }

    /**
     * Get filesystem disk name
     *
     * @return string
     */
    protected function getDisk()
    {
        if (isset ($this->settings['disk']) && $this->settings['disk']) {
            return $this->settings['disk'];
        }

        if (config()->has('uploadify.disk')) {
            return config()->get('uploadify.disk');
        }

        return config()->get('uploadify.filesystems.default');
    }
}
