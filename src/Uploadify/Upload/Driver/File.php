<?php

namespace Uploadify\Upload\Driver;

use Uploadify\Upload\AbstractDriver;
use Uploadify\Upload\DriverInterface;

use Illuminate\Http\UploadedFile;

use Symfony\Component\HttpFoundation\File\Exception\FileException;

class File extends AbstractDriver implements DriverInterface
{
    /**
     * Driver name
     *
     * @var string
     */
    protected $driver = 'file';

    /**
     * The uploaded file instance
     *
     * @var \Illuminate\Http\UploadedFile
     */
    protected $file;

    /**
     * Set uploaded file as file source
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @return $this
     * @throws \Symfony\Component\HttpFoundation\File\Exception\FileException
     */
    public function setFile($file)
    {
        if (! ($file instanceof UploadedFile)) {
            throw new FileException('File source must be instance of Illuminate\Http\UploadedFile!');
        }

        if (! $file->isValid()) {
            throw new FileException('File was not uploaded successfully!');
        }

        $this->file = $file;

        $this->setFileInfo($file);

        return $this;
    }

    /**
     * Upload file
     *
     * @return string
     */
    public function upload()
    {
        $this->createDirectory($this->model->uploadFilePath);

        $name = $this->rename($this->model->uploadFilePath, $this->name, $this->extension);

        $options = [
            'disk' => $this->getDisk(),
        ];

        $this->file->storeAs($this->model->uploadFilePath, $name, $options);

        return $name;
    }

    /**
     * Delete file or image
     *
     * @param  object  $model
     * @param  string  $type  file/image
     * @param  string|null  $disk
     * @return bool
     */
    public function delete()
    {
        return $this->storage->disk($this->getDisk())->delete($this->model->uploadFilePath.$this->model->getUploadFile());
    }
}
