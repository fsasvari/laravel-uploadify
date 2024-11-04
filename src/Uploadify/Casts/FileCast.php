<?php

namespace Uploadify\Casts;

class FileCast extends Cast
{
    public function url()
    {
        return $this->getStorage()->url($this->path() . '/' . $this->name());
    }
}
