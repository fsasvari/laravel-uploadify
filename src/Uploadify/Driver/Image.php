<?php

namespace Uploadify\Driver;

use Uploadify\AbstractDriver;
use Uploadify\Contracts\DriverInterface;

class Image extends AbstractDriver implements DriverInterface
{
    /**
     * Image quality
     *
     * @var int
     */
    protected $quality = 90;

    /**
     * Set image quality
     *
     * @param  int  $quality
     * @return $this
     */
    public function setQuality($quality = 90)
    {
        $this->quality = $quality;

        return $this;
    }

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
                $isUploaded = $this->uploadFromPath();
                break;

            case 'url':
                $isUploaded = $this->uploadFromUrl();
                break;

            case 'uploadedfile':
                $isUploaded = $this->uploadFromUploadedFile();
                break;

            case 'interventionimage':
                $isUploaded = $this->uploadFromInterventionImage();
                break;
        }

        return $isUploaded;
    }

    /**
     * Upload image from intervention image
     *
     * @return bool
     */
    protected function uploadFromInterventionImage()
    {
        $path = $this->storage->disk($this->getDisk())->getDriver()->getAdapter()->getPathPrefix();

        return $this->source->save($path.DIRECTORY_SEPARATOR.$this->getPath().DIRECTORY_SEPARATOR.$this->name.'.'.$this->extension, $this->quality);
    }
}
