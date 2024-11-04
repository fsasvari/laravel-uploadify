<?php

namespace Uploadify\Traits;

use Illuminate\Support\Collection as BaseCollection;
use Uploadify\Casts\FileCast;
use Uploadify\Casts\ImageCast;

trait UploadifyTrait
{
    /**
     * Initialize the trait for an instance.
     *
     * @return void
     */
    public function initializeUploadifyTrait()
    {
        if ($this->hasFileCasts()) {
            foreach (array_keys($this->uploadifyFiles) as $key) {
                if (! isset($this->attributes[$key])) {
                    $this->casts[$key] = 'filecast';
                }
            }
        }

        if ($this->hasImageCasts()) {
            foreach (array_keys($this->uploadifyImages) as $key) {
                if (! isset($this->attributes[$key])) {
                    $this->casts[$key] = 'imagecast';
                }
            }
        }
    }

    /**
     * Set a given attribute on the model.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        if (is_string($value)) {
            if ($this->hasFileCasts()) {
                if (array_key_exists($key, $this->uploadifyFiles)) {
                    $this->attributes[$key] = $value;
                    return $this;
                }
            }

            if ($this->hasImageCasts()) {
                if (array_key_exists($key, $this->uploadifyImages)) {
                    $this->attributes[$key] = $value;
                    return $this;
                }
            }
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Cast an attribute to a native PHP type.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return mixed
     */
    protected function castAttribute($key, $value)
    {
        if (is_null($value)) {
            return $value;
        }

        switch ($this->getCastType($key)) {
            case 'filecast':
                if ($value) {
                    return new FileCast($value, $this->uploadifyFiles[$key]);
                } else {
                    return null;
                }
            case 'imagecast':
                if ($value) {
                    return new ImageCast($value, $this->uploadifyImages[$key]);
                } else {
                    return null;
                }
        }

        return parent::castAttribute($key, $value);
    }

    /**
     * Determine if the given key is cast using a custom class.
     *
     * @param  string  $key
     * @return bool
     *
     * @throws \Illuminate\Database\Eloquent\InvalidCastException
     */
    protected function isClassCastable($key)
    {
        if ($this->hasFileCasts()) {
            if (array_key_exists($key, $this->uploadifyFiles)) {
                return false;
            }
        }

        if ($this->hasImageCasts()) {
            if (array_key_exists($key, $this->uploadifyImages)) {
                return false;
            }
        }

        return parent::isClassCastable($key);
    }

    /**
     * Check if model has file casts
     *
     * @return bool
     */
    public function hasFileCasts()
    {
        return ! empty($this->uploadifyFiles);
    }

    /**
     * Check if model has image casts
     *
     * @return bool
     */
    public function hasImageCasts()
    {
        return ! empty($this->uploadifyImages);
    }
}
