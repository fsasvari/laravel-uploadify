<?php

namespace Uploadify\Upload;

use Illuminate\Contracts\Filesystem\Factory as Storage;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Image as InterventionImage;

use Uploadify\Exceptions\InvalidDriverException;

class UploadManager
{
	/**
	 * The filesystem factory instance
	 *
	 * @var \Illuminate\Contracts\Filesystem\Factory
	 */
	protected $storage;

	/**
	 * Default driver
	 *
	 * @var string
	 */
	protected $driver;

	/**
	 * Create new upload manager instance
	 *
	 * @param  \Illuminate\Contracts\Filesystem\Factory  $storage
	 * @param  string  $driver
	 * @return void
	 */
	public function __construct(Storage $storage, $driver)
	{
		$this->storage = $storage;
		$this->driver = $driver;
	}

	/**
	 * Return driver instance
	 *
	 * @param  string|null  $driver
	 * @return \Uploadify\Upload\AbstractDriver|\Uploadify\Upload\DriverInterface
	 */
	public function driver($driver = null)
	{
		return $this->createDriver($driver);
	}

	/**
	 * Create new driver instance
	 *
	 * @param  string|null  $driver
	 * @throws \Uploadify\Exceptions\InvalidDriverException
	 * @return \Uploadify\Upload\AbstractDriver|\Uploadify\Upload\DriverInterface
	 */
	private function createDriver($driver = null)
	{
		$name = studly_case($driver ? $driver : $this->driver);
		$class = '\\Uploadify\\Upload\\Driver\\'.$name;

		if (! class_exists($class)) {
            throw new InvalidDriverException('Driver "'.$class.'" does not exists!');
        }

		return new $class($this->storage);
	}

	/**
	 * Set file source and create new driver instance
	 *
	 * @param  mixed  $file
	 * @return \Uploadify\Upload\AbstractDriver|\Uploadify\Upload\DriverInterface
	 */
	public function setFile($file)
	{
		if ($file instanceof UploadedFile) {
			return $this->driver('file')->setFile($file);
		}

		if ($file instanceof InterventionImage) {
			return $this->driver('image')->setFile($file);
		}

		return $this->driver()->setFile($file);
	}
}
