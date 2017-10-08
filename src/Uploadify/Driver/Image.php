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
                return $this->uploadFromPath();

            case 'url':
                return $this->uploadFromUrl();

            case 'uploadedfile':
                return $this->uploadFromUploadedFile();

            case 'interventionimage':
                return $this->uploadFromInterventionImage();
        }
    }

    /**
     * Upload image from intervention image
     *
     * @return bool
     */
    protected function uploadFromInterventionImage()
    {
        $path = $this->storage->disk($this->getDisk())->getDriver()->getAdapter()->getPathPrefix();

        return $this->source->save($path.'/'.$this->model->uploadImagePath.$this->name.'.'.$this->extension, $this->quality);
    }

    /**
     * Upload image
     *
     * @param  int  $quality
     * @return $this
     */
//    public function upload()
//    {
//        $this->createDirectory($this->model->uploadImagePath);
//
//        $name = $this->rename($this->model->uploadImagePath, $this->name, $this->extension);
//        $path = $this->storage->disk($this->getDisk())->getDriver()->getAdapter()->getPathPrefix();
//
//        $this->source->save($path.'/'.$this->model->uploadImagePath.$name, $this->quality);
//
//        return $name;
//    }
}
