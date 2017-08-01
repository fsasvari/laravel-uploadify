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
     * Get file size in bytes
     *
     * @return string
     */
    public function getFilesize()
    {
        return Storage::disk($this->getDisk())->size($this->getUrl());
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
}
