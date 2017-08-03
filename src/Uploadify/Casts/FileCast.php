<?php

namespace Uploadify\Casts;

use Uploadify\Casts\Cast as BaseCast;

class FileCast extends BaseCast
{
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
