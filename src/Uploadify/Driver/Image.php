<?php

namespace Uploadify\Driver;

use Uploadify\AbstractDriver;
use Uploadify\Contracts\DriverInterface;

use Intervention\Image\Image as InterventionImage;

use Symfony\Component\HttpFoundation\File\Exception\FileException;

class Image extends AbstractDriver implements DriverInterface
{
    /**
     * The intervention image instance
     *
     * @var \Intervention\Image\Image
     */
    protected $file;

    /**
     * Image quality
     *
     * @var int
     */
    protected $quality = 90;

    /**
     * Set intervention image as file source
     *
     * @param  \Intervention\Image\Image  $file
     * @return $this
     * @throws \Symfony\Component\HttpFoundation\File\Exception\FileException
     */
    public function setFile($file)
    {
        if (! ($file instanceof InterventionImage)) {
            throw new FileException('File source must be instance of Intervention\Image\Image!');
        }

        $this->file = $file;

        return $this;
    }

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
     * Upload image
     *
     * @param  int  $quality
     * @return $this
     */
    public function upload()
    {
        $this->createDirectory($this->model->uploadImagePath);

        $name = $this->rename($this->model->uploadImagePath, $this->name, $this->extension);
        $path = $this->storage->disk($this->getDisk())->getDriver()->getAdapter()->getPathPrefix();

        $this->file->save($path.'/'.$this->model->uploadImagePath.$name, $this->quality);

        return $name;
    }

    /**
     * Delete file from default model storage disk
     *
     * @return bool
     */
    public function delete()
    {
        return $this->storage->disk($this->getDisk())->delete($this->model->uploadImagePath.$this->model->getUploadImage());
    }
}
