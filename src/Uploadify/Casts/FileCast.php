<?php

namespace Uploadify\Casts;

use Uploadify\Casts\Cast as BaseCast;

class FileCast extends BaseCast
{
    /**
     * Get file name with extension
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Get file base name without extension
     *
     * @return string
     */
    public function basename()
    {
        return pathinfo($this->name(), PATHINFO_FILENAME);
    }

    /**
     * Get full url to file
     *
     * @return string
     */
    public function url()
    {
        return $this->getStorage()->url($this->path().'/'.$this->name());
    }
}
