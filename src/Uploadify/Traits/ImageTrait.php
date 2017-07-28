<?php

namespace Uploadify\Traits;

trait ImageTrait
{
	/**
	 * Get image with full path
	 *
	 * @param  int  $width
	 * @param  int  $height
	 * @return string
	 */
	public function getUploadImagePath($width = null, $height = null)
	{
		if (! $this->getUploadImage()) {
			return;
		}

		if ($width && $height) {
			$extension = $this->getUploadImageExtension();

			return $this->uploadImageThumbPath.basename($this->getUploadImage(), '.'.$extension).'-'.$width.'x'.$height.'.'.$extension;
		}

		return $this->uploadImagePath.$this->getUploadImage();
	}

	/**
	 * Get upload image value
	 *
	 * @return string
	 */
	public function getUploadImage()
	{
		return $this->{$this->uploadImageField};
	}

    /**
	 * Get image base name without extension
	 *
	 * @return string
	 */
	public function getUploadImageBasename()
	{
		return pathinfo($this->getUploadImage(), PATHINFO_FILENAME);
	}

	/**
	 * Get image extension
	 *
	 * @return string
	 */
	public function getUploadImageExtension()
	{
		return pathinfo($this->getUploadImage(), PATHINFO_EXTENSION);
	}

	/**
	 * Get image size in bytes
	 *
     * @param  int  $width
     * @param  int  $height
	 * @return int
	 */
	public function getUploadImageSize($width = null, $height = null)
	{
        return filesize(config('filesystems.disks.'.$this->getDisk().'.root').DIRECTORY_SEPARATOR.$this->getUploadImagePath($width, $height));
	}

    /**
	 * Get storage disk name
	 *
	 * @return string|null
	 */
	public function getDisk()
	{
		return $this->disk ? $this->disk : 'public';
	}
}
