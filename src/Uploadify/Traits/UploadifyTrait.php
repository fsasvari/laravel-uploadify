<?php

namespace Uploadify\Traits;

use Uploadify\Casts\FileCast;
use Uploadify\Casts\ImageCast;

trait UploadifyTrait
{
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
            case 'int':
            case 'integer':
                return (int) $value;
            case 'real':
            case 'float':
            case 'double':
                return (float) $value;
            case 'string':
                return (string) $value;
            case 'bool':
            case 'boolean':
                return (bool) $value;
            case 'object':
                return $this->fromJson($value, true);
            case 'array':
            case 'json':
                return $this->fromJson($value);
            case 'collection':
                return new BaseCollection($this->fromJson($value));
            case 'date':
                return $this->asDate($value);
            case 'datetime':
                return $this->asDateTime($value);
            case 'timestamp':
                return $this->asTimestamp($value);
            case 'file':
                return new FileCast($value, $this->files[$key]);
            case 'image':
                return new ImageCast($value, $this->images[$key]);
            default:
                return $value;
        }
    }

    /**
     * Get the casts array.
     *
     * @return array
     */
    public function getCasts()
    {
        $casts = $this->casts;

        if ($this->getIncrementing()) {
            $casts = array_merge([$this->getKeyName() => $this->getKeyType()], $casts);
        }

        if ($this->hasFileCasts()) {
            foreach (array_keys($this->files) as $key) {
                $casts = array_merge([$key => 'file'], $casts);
            }
        }

        if ($this->hasImageCasts()) {
            foreach (array_keys($this->images) as $key) {
                $casts = array_merge([$key => 'image'], $casts);
            }
        }

        return $casts;
    }

    /**
     * Check if model has file casts
     *
     * @return bool
     */
    protected function hasFileCasts()
    {
        return empty($this->files);
    }

    /**
     * Check if model has image casts
     *
     * @return bool
     */
    protected function hasImageCasts()
    {
        return empty($this->images);
    }
}
