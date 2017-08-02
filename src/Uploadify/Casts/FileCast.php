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
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get file base name without extension
     *
     * @return string
     */
    public function getBasename()
    {
        return pathinfo($this->getName(), PATHINFO_FILENAME);
    }

    /**
     * Get full url to file
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->getStorage()->url($this->getPath().$this->getName());
    }
}
