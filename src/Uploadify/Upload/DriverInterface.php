<?php

namespace Uploadify\Upload;

interface DriverInterface
{
    /**
     * Set file source
     *
     * @param  mixed  $file
     * @return $this
     */
    public function setFile($file);

    /**
     * Upload file to storage disk
     *
     * @return string
     */
    public function upload();

    /**
     * Delete file from storage disk
     *
     * @return bool
     */
    public function delete();
}
