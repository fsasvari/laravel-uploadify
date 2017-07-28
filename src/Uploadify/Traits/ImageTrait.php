<?php

namespace Uploadify\Traits;

trait ImageTrait
{
    /**
     * Get image with full path
     *
     * @param  string  $field
     * @param  int  $width
     * @param  int  $height
     * @return string
     */
    public function getImage($field, $width = null, $height = null)
    {
        if (! $this->getImageName($field)) {
            return;
        }

        if ($width && $height) {
            $extension = $this->getImageExtension($field);

            return $this->getImageThumbPath($field).$this->getImageBasename($field).'-w'.$width.'-h'.$height.'.'.$extension;
        }

        return $this->getImagePath($field).$this->getImageName($field);
    }

    /**
     * Get image name with extension
     *
     * @param  string  $field
     * @return string
     */
    public function getImageName($field)
    {
        return $this->getAttribute($field);
    }

    /**
     * Get image path
     *
     * @param  string  $field
     * @return string
     */
    protected function getImagePath($field)
    {
        return $this->images[$field]['path'];
    }

    /**
     * Get image thumbnail path
     *
     * @param  string  $field
     * @return string
     */
    protected function getImageThumbPath($field)
    {
        return $this->images[$field]['thumb_path'];
    }

    /**
     * Get image base name without extension
     *
     * @param  string  $field
     * @return string
     */
    public function getImageBasename($field)
    {
        return pathinfo($this->getImageName($field), PATHINFO_FILENAME);
    }

    /**
     * Get image extension
     *
     * @param  string  $field
     * @return string
     */
    public function getImageExtension($field)
    {
        return pathinfo($this->getImageName($field), PATHINFO_EXTENSION);
    }

    /**
     * Get image size in bytes
     *
     * @param  string  $field
     * @param  int  $width
     * @param  int  $height
     * @return int
     */
    public function getImageSize($field, $width = null, $height = null)
    {
        return filesize(config('filesystems.disks.'.$this->getDisk().'.root').DIRECTORY_SEPARATOR.$this->getImage($field, $width, $height));
    }

    /**
     * Get storage disk name
     *
     * @return string|null
     */
    public function getDisk()
    {
        return $this->disk ? $this->disk : 'public';
    }
}
