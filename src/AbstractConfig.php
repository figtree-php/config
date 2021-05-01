<?php

namespace FigTree\Config;

use FigTree\Exceptions\UnreadablePathException;
use FigTree\Config\Exceptions\{
	InvalidConfigFileException,
};
use FigTree\Exceptions\{
	InvalidFileException,
	InvalidPathException,
};
use FigTree\Config\Concerns\ArrayAccessData;
use FigTree\Config\Contracts\ConfigInterface;

abstract class AbstractConfig implements ConfigInterface
{
	use ArrayAccessData;

	protected string $fileName;

	/**
	 * Get the name of the underlying Config file.
	 *
	 * @return string
	 */
	public function getFileName(): string
	{
		return $this->fileName;
	}

	/**
	 * Convert the object into JSON.
	 *
	 * @param integer $options
	 * @param integer $depth
	 *
	 * @return string
	 */
	public function toJson(int $options = 0, int $depth = 512): string
	{
		if (($options & JSON_THROW_ON_ERROR) === 0) {
			$options |= JSON_THROW_ON_ERROR;
		}

		return json_encode($this, $options, $depth);
	}

	/**
	 * Convert the object into a string.
	 *
	 * @return string
	 */
	public function toString(): string
	{
		return $this->__toString();
	}

	/**
	 * Magic method called on JSON serialization of the object.
	 *
	 * @return array The data to be serialized.
	 */
	public function jsonSerialize()
	{
		return $this->toArray();
	}

	/**
	 * Magic method called during serialization to a string.
	 *
	 * @return string
	 */
	public function __toString()
	{
		return serialize($this);
	}

	/**
	 * Set the resolved filename of the Config file and read in its data.
	 *
	 * @param string $fileName
	 *
	 * @return $this
	 *
	 * @throws \FigTree\Exceptions\InvalidPathException
	 * @throws \FigTree\Exceptions\InvalidFileException
	 */
	protected function setFileName(string $fileName)
	{
		$path = realpath($fileName);

		if (empty($path)) {
			throw new InvalidPathException($fileName);
		}

		if (!is_file($path)) {
			throw new InvalidFileException($path);
		}

		$this->fileName = $path;

		return $this->readData();
	}

	/**
	 * Read the result of the Config file into the object's data.
	 *
	 * @return $this
	 *
	 * @throws \FigTree\Exceptions\UnreadablePathException
	 * @throws \FigTree\Config\Exceptions\InvalidConfigFileException
	 */
	protected function readData(): ConfigInterface
	{
		if (!is_readable($this->fileName)) {
			throw new UnreadablePathException($this->fileName);
		}

		$reader = $this->createReader();

		$data = $reader->read($this->fileName);

		$this->data = $data;

		return $this;
	}
}
