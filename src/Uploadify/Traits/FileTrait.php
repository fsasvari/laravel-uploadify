<?php

namespace Uploadify\Traits;

trait FileTrait
{
	/**
	 * Get file with full path
	 *
	 * @return string
	 */
	public function getUploadFilePath()
	{
		if (! $this->getUploadFile()) {
			return;
		}

		return $this->uploadFilePath.$this->getUploadFile();
	}

	/**
	 * Get upload file value
	 *
	 * @return string
	 */
	public function getUploadFile()
	{
		return $this->{$this->uploadFileField};
	}

    /**
	 * Get file base name without extension
	 *
	 * @return string
	 */
	public function getUploadFileBasename()
	{
		return pathinfo($this->getUploadFile(), PATHINFO_FILENAME);
	}

	/**
	 * Get file extension
	 *
	 * @return string
	 */
	public function getUploadFileExtension()
	{
		return pathinfo($this->getUploadFile(), PATHINFO_EXTENSION);
	}

	/**
	 * Get file size in bytes
	 *
	 * @return int
	 */
	public function getUploadFileSize()
	{
		return filesize(config('filesystems.disks.'.$this->getDisk().'.root').DIRECTORY_SEPARATOR.$this->uploadFilePath.$this->getUploadFile());
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
