<?php

namespace Uploadify\Casts;

use Uploadify\Casts\Cast as BaseCast;
use Illuminate\Support\Facades\Config;

class ImageCast extends BaseCast
{
    /**
     * The path to thumb file
     *
     * @var string
     */
    protected $pathThumb;

    /**
     * Save setting values from array
     *
     * @param  array  $settings
     * @return void
     */
    protected function saveSettings(array $settings = [])
    {
        parent::saveSettings($settings);

        $this->setPathThumb(isset($settings['path_thumb']) ? $settings['path_thumb'] : null);
    }

    /**
     * Set thumbnail path
     *
     * @param  string|null  $pathThumb
     * @return void
     */
    protected function setPathThumb($pathThumb = null)
    {
        if ($pathThumb) {
            $this->pathThumb = $pathThumb;
        } else {
            $this->pathThumb = $this->path.Config::get('uploadify.path_thumb_suffix');
        }
    }

    /**
     * Get file name with extension
     *
     * @param  int  $width
     * @param  int  $height
     * @return string
     */
    public function name($width = null, $height = null)
    {
        if ($width && $height) {
            return $this->basename($width, $height).'.'.$this->extension();
        }

        return $this->name;
    }

    /**
     * Get file base name without extension
     *
     * @param  int  $width
     * @param  int  $height
     * @return string
     */
    public function basename($width = null, $height = null)
    {
        if ($width && $height) {
            return $this->prepareNameThumb(pathinfo($this->name(), PATHINFO_FILENAME), $width, $height);
        }

        return pathinfo($this->name(), PATHINFO_FILENAME);
    }

    /**
     * Get thumb path
     *
     * @return string
     */
    public function pathThumb()
    {
        return $this->pathThumb;
    }

    /**
     * Get full url to file
     *
     * @param  int  $width
     * @param  int  $height
     * @return string
     */
    public function url($width = null, $height = null)
    {
        if ($width && $height) {
            return $this->getStorage()->url($this->pathThumb().$this->name($width, $height));
        }

        return $this->getStorage()->url($this->path().$this->name());
    }

    /**
     * Prepare thumbnail name from name mask
     *
     * @param  string  $name
     * @param  int  $width
     * @param  int  $height
     * @return string
     */
    protected function prepareNameThumb($name, $width, $height)
    {
        $from = [
            '{name}',
            '{width}',
            '{height}',
        ];

        $to = [
            $name,
            $width,
            $height,
        ];

        return str_replace($from, $to, Config::get('uploadify.name_thumb_mask'));
    }
}
