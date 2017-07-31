<?php

namespace Uploadify\Casts;

use Uploadify\Casts\Cast as BaseCast;

class ImageCast extends BaseCast
{
    /**
     * The path to thumb file
     *
     * @var string
     */
    protected $pathThumb;

    /**
     * Save setting values from array
     *
     * @param  array  $settings
     * @return void
     */
    protected function saveSettings(array $settings = [])
    {
        $this->path = $settings['path'];
        $this->pathThumb = $settings['path_thumb'];
        $this->disk = $settings['disk'];
    }

    /**
     * Get file name with extension
     *
     * @param  int  $width
     * @param  int  $height
     * @return string
     */
    public function getName($width = null, $height = null)
    {
        if ($width && $height) {
            return $this->getBasenameWithDimensions($width, $height).$this->getExtension();
        }

        return $this->name;
    }

    /**
     * Get file base name without extension
     *
     * @param  int  $width
     * @param  int  $height
     * @return string
     */
    public function getBasename($width = null, $height = null)
    {
        if ($width && $height) {
            return $this->getBasenameWithDimensions($width, $height);
        }

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
     * @param  int  $width
     * @param  int  $height
     * @return string
     */
    public function getUrl($width = null, $height = null)
    {
        if ($width && $height) {
            $this->pathThumb.$this->getName($width, $height);
        }

        return $this->path.$this->getName();
    }

    /**
     * Get file base name with dimensions (width and height), without extension
     *
     * @param  int  $width
     * @param  int  $height
     * @return string
     */
    protected function getBasenameWithDimensions($width, $height)
    {
        return pathinfo($this->getName(), PATHINFO_FILENAME).'-w'.$width.'-h'.$height;
    }
}
