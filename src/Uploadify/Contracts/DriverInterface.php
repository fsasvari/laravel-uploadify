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
}
