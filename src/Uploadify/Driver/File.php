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
        return $this->storage->disk($this->getDisk())->delete($this->getFieldCast()->path().$this->getFieldCast()->name());
    }
}
