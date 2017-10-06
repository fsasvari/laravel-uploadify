<?php

namespace Uploadify;

use Illuminate\Contracts\Filesystem\Factory as Storage;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Image as InterventionImage;
use Illuminate\Database\Eloquent\Model as Eloquent;

class UploadifyManager
{
    /**
     * The filesystem factory instance
     *
     * @var \Illuminate\Contracts\Filesystem\Factory
     */
    protected $storage;

    /**
     * The list of settings
     *
     * @var array
     */
    protected $settings = [];

    /**
     * Create new uploadify instance
     *
     * @param  \Illuminate\Contracts\Filesystem\Factory  $storage
     * @param  array  $settings
     * @return void
     */
    public function __construct(Storage $storage, array $settings = [])
    {
        $this->storage = $storage;
        $this->settings = $settings;
    }

    /**
     * Create new uploadify instance
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  \Uploadify\Uploadify  $field
     * @return self
     */
    public function create(UploadedFile $file, Eloquent $model, $field)
    {

    }
}
