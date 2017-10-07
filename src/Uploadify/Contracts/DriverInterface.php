<?php

namespace Uploadify\Contracts;

interface DriverInterface
{
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
