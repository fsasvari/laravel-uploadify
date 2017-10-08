<?php

namespace Uploadify\Driver;

use Uploadify\AbstractDriver;
use Uploadify\Contracts\DriverInterface;

class File extends AbstractDriver implements DriverInterface
{
    /**
     * Upload file
     *
     * @return string
     */
    public function upload()
    {
        $this->createDirectory($this->getPath());

        $this->rename($this->getPath(), $this->name, $this->extension);

        switch ($this->sourceType) {
            case 'path':
                return $this->uploadFromPath();

            case 'url':
                return $this->uploadFromUrl();

            case 'uploadedfile':
                return $this->uploadFromUploadedFile();
        }
    }
}
