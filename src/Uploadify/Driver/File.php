<?php

namespace Uploadify\Driver;

use Uploadify\AbstractDriver;
use Uploadify\Contracts\DriverInterface;

class File extends AbstractDriver implements DriverInterface
{
    /**
     * Upload file
     *
     * @return void
     */
    public function upload()
    {
        $this->createDirectory($this->getPath());

        $this->rename($this->getPath(), $this->name, $this->extension);

        switch ($this->sourceType) {
            case 'path':
                $isUploaded = $this->uploadFromPath();
                break;

            case 'url':
                $isUploaded = $this->uploadFromUrl();
                break;

            case 'uploadedfile':
                $isUploaded = $this->uploadFromUploadedFile();
                break;
        }

        return $isUploaded;
    }
}
