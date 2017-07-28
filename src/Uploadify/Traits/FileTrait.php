<?php

namespace Uploadify\Traits;

trait FileTrait
{
    /**
     * Get file with full path
     *
     * @param  string  $field
     * @return string
     */
    public function getFile($field)
    {
        if (! $this->getFileName($field)) {
            return;
        }

        return $this->getFilePath($field).$this->getFileName($field);
    }

    /**
     * Get file name with extension
     *
     * @param  string  $field
     * @return string
     */
    public function getFileName($field)
    {
        return $this->getAttribute($field);
    }

    /**
     * Get file path
     *
     * @param  string  $field
     * @return string
     */
    protected function getFilePath($field)
    {
        return $this->files[$field]['path'];
    }

    /**
     * Get file base name without extension
     *
     * @param  string  $field
     * @return string
     */
    public function getFileBasename($field)
    {
        return pathinfo($this->getFileName($field), PATHINFO_FILENAME);
    }

    /**
     * Get file extension
     *
     * @param  string  $field
     * @return string
     */
    public function getFileExtension($field)
    {
        return pathinfo($this->getFileName($field), PATHINFO_EXTENSION);
    }

    /**
     * Get file size in bytes
     *
     * @param  string  $field
     * @return int
     */
    public function getFileSize($field)
    {
        return filesize(config('filesystems.disks.'.$this->getDisk().'.root').DIRECTORY_SEPARATOR.$this->getFile($field));
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
