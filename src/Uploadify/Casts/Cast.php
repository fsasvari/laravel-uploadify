<?php

namespace Uploadify\Casts;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;

abstract class Cast
{
    protected $name; // Nome completo do arquivo
    protected $path; // Caminho para o arquivo
    protected $disk; // Nome do disco do sistema de arquivos

    public function __construct($name, array $settings = [])
    {
        $this->name = $name;
        $this->saveSettings($settings);
    }

    protected function saveSettings(array $settings = [])
    {
        $this->setPath(Arr::get($settings, 'path', ''));
        $this->setDisk(Arr::get($settings, 'disk', null));
    }

    protected function setPath($path)
    {
        $this->path = trim($path, '/');
    }

    protected function setDisk($disk = null)
    {
        $this->disk = $disk ?: Config::get('uploadify.disk');
    }

    public function name()
    {
        return $this->name;
    }

    public function basename()
    {
        return pathinfo($this->name(), PATHINFO_FILENAME);
    }

    public function extension()
    {
        return pathinfo($this->name(), PATHINFO_EXTENSION);
    }

    public function filesize()
    {
        return $this->getStorage()->size($this->path() . '/' . $this->name());
    }

    public function path()
    {
        return $this->path;
    }

    public function delete()
    {
        return $this->getStorage()->delete($this->path() . '/' . $this->name());
    }

    public function disk()
    {
        return $this->getDisk();
    }

    protected function getStorage()
    {
        return Storage::disk($this->getDisk());
    }

    protected function getDisk()
    {
        return $this->disk;
    }

    public function __toString()
    {
        return $this->name();
    }
}
