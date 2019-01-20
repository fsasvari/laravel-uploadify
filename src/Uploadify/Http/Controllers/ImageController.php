<?php

namespace Uploadify\Http\Controllers;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Contracts\Routing\ResponseFactory as Response;
use Illuminate\Contracts\Filesystem\Factory as Storage;
use Intervention\Image\ImageManager;
use Psr\Log\LoggerInterface;
use Intervention\Image\Image;
use Intervention\Image\Exception\NotReadableException;
use Intervention\Image\Exception\NotWritableException;

class ImageController
{
    /**
     * The config repository instance
     *
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * The routing response factory instance
     *
     * @var \Illuminate\Contracts\Routing\ResponseFactory
     */
    protected $response;

    /**
     * The filesystem factory (storage) instance
     *
     * @var \Illuminate\Contracts\Filesystem\Factory
     */
    protected $storage;

    /**
     * The intervention image manager instance
     *
     * @var \Intervention\Image\ImageManager
     */
    protected $imageManager;

    /**
     * The log logger instance
     *
     * @var \Psr\Log\LoggerInterface
     */
    protected $log;

    /**
     * Create new image controller instance
     *
     * @param  \Illuminate\Contracts\Config\Repository  $config
     * @param  \Illuminate\Contracts\Routing\ResponseFactory  $response
     * @param  \Illuminate\Contracts\Filesystem\Factory  $storage
     * @param  \Intervention\Image\ImageManager  $imageManager
     * @param  \Psr\Log\LoggerInterface  $log
     * @return void
     */
    public function __construct(Config $config, Response $response, Storage $storage, ImageManager $imageManager, LoggerInterface $log)
    {
        $this->config = $config;
        $this->response = $response;
        $this->storage = $storage;
        $this->imageManager = $imageManager;
        $this->log = $log;
    }

    /**
     * Show processed image
     *
     * @param  string  $path
     * @param  string  $options
     * @param  string  $name
     * @param  string|null  $extension
     * @return mixed
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function show($path, $options, $name, $extension = null)
    {
        $originalPath = $this->getPath($path);

        $imagePath = $originalPath.'/'.$name.($extension ? '.'.$extension : '');
        $imageSmallPath = $originalPath.'/'.$this->config->get('uploadify.path').'/'.$this->slugifyName($name.','.$options).'.'.($extension ?: '');

        if ($this->exists($imagePath, $imageSmallPath)) {
            $image = $this->getDisk()->get($imageSmallPath);
            $type = $this->getDisk()->mimeType($imageSmallPath);

            return $this->response->make($image)->header('Content-Type', $type);
        }

        try {
            $imageNew = $this->imageManager->make($this->getDisk()->get($imagePath));
        } catch (NotReadableException $e) {
            $imageNew = null;

            abort(404);
        }

        $imageNew = $this->processImage($imageNew, $this->parseOptions($options));

        if ($this->config->get('uploadify.cache')) {
            try {
                $imageNew->save($this->getDisk()->getDriver()->getAdapter()->getPathPrefix().$imageSmallPath, 85);
            } catch (NotWritableException $e) {
                $context = [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ];

                $this->log->notice($e->getMessage(), $context);
            }
        }

        return $imageNew->response();
    }

    /**
     * Check if image thumbnail exists
     *
     * @param  string  $imagePath
     * @param  string  $imageSmallPath
     * @return bool
     */
    protected function exists($imagePath, $imageSmallPath)
    {
        return $this->getDisk()->exists($imageSmallPath) && $this->getDisk()->lastModified($imagePath) <= $this->getDisk()->lastModified($imageSmallPath);
    }

    /**
     * Get real path to image
     *
     * @param  string  $path
     * @return string
     */
    protected function getPath($path)
    {
        $storagePath = parse_url($this->getDisk()->url(''));

        $from = [
            trim($storagePath['path'], '/'),
        ];

        return trim(str_replace($from, '', $path), '/');
    }

    /**
     * Get filesystems storage disk
     *
     * @return \Illuminate\Contracts\Filesystem\Filesystem
     */
    protected function getDisk()
    {
        return $this->storage->disk($this->config->get('uploadify.disk'));
    }

    /**
     * Create array from options string
     *
     * @param  string  $options
     * @return array
     */
    protected function parseOptions($options)
    {
        $array = explode(',', $options);

        $optionsArray = [];

        foreach ($array as $option) {
            $optionArray = explode('_', $option, 2);

            if (count($optionArray) < 2) {
                continue;
            }

            $optionsArray[$optionArray[0]] = $optionArray[1];
        }

        return $optionsArray;
    }

    /**
     * Get slugified name
     *
     * @param  string  $name
     * @return string
     */
    protected function slugifyName($name)
    {
        return str_replace(',', $this->config->get('uploadify.separator'), $name);
    }

    /**
     * Process image with options parameters
     *
     * @param  \Intervention\Image\Image  $image
     * @param  array  $options
     * @return \Intervention\Image\Image
     */
    protected function processImage(Image $image, $options)
    {
        $width = array_has($options, 'w') ? $options['w'] : null;
        $height = array_has($options, 'h') ? $options['h'] : null;

        if ($width || $height) {
            if (array_has($options, 'crop') && $options['crop'] == 'resize') {
                $image->resize($width, $height);
            } else {
                $image->fit($width, $height);
            }
        }

        if (array_has($options, 'effect')) {
            switch($options['effect']) {
                case 'greyscale':
                    $image->greyscale();
                    break;
                case 'invert':
                    $image->invert();
                    break;
            }
        }

        if (array_has($options, 'blur')) {
            $image->blur($options['blur']);
        }

        if (array_has($options, 'brightness')) {
            $image->brightness($options['brightness']);
        }

        if (array_has($options, 'contrast')) {
            $image->contrast($options['contrast']);
        }

        if (array_has($options, 'sharpen')) {
            $image->sharpen($options['sharpen']);
        }

        if (array_has($options, 'pixelate')) {
            $image->pixelate($options['pixelate']);
        }

        if (array_has($options, 'rotate')) {
            $image->rotate($options['rotate']);
        }

        if (array_has($options, 'flip')) {
            $image->flip($options['flip']);
        }

        return $image;
    }
}
