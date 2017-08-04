<?php

namespace Uploadify\Casts;

use Uploadify\Casts\Cast as BaseCast;

class ImageCast extends BaseCast
{
    /**
     * Get full url to file
     *
     * @param  int|array  $width
     * @param  int  $height
     * @param  array  $options
     * @return string
     */
    public function url($width = null, $height = null, array $options = [])
    {
        if (is_array($width)) {
            $options = $width;
        } elseif ($width) {
            if ($height) {
                $options = array_merge(['h' => $height], $options);
            }

            $options = array_merge(['w' => $width], $options);
        }

        if (! empty($options)) {
            return $this->getStorage()->url($this->path().'/'.$this->prepareOptions($options).'/'.$this->name());
        }

        return $this->getStorage()->url($this->path().'/'.$this->name());
    }

    /**
     * Prepare and convert options from array to string
     *
     * @param array $options
     */
    protected function prepareOptions(array $options = [])
    {
        $string = implode(',', array_map(
            function ($value, $key) {
                return $key.'_'.$value;
            },
            $options,
            array_keys($options)
        ));

        $from = ['width', 'height'];

        $to = ['w', 'h'];

        return str_replace($from, $to, $string);
    }
}
