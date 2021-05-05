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

	/**
	 * Paths of underlying Config files.
	 */
	protected array $paths = [];

	/**
	 * Get the paths of the underlying Config files.
	 *
	 * @return array
	 */
	public function getPaths(): array
	{
		return $this->paths;
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
	 * Resolve the given filename of a Config file, add it to the
	 * array of files, and read in its data.
	 *
	 * @param string $fileName
	 *
	 * @return $this
	 *
	 * @throws \FigTree\Exceptions\InvalidPathException
	 * @throws \FigTree\Exceptions\InvalidFileException
	 */
	protected function addPath(string $fileName): ConfigInterface
	{
		$path = realpath($fileName);

		if (empty($path)) {
			throw new InvalidPathException($fileName);
		}

		if (!is_file($path)) {
			throw new InvalidFileException($path);
		}

		$this->paths[] = $path;

		return $this->readData($path);
	}

	/**
	 * Read the result of the Config file into the object's data.
	 *
	 * @param string $path
	 *
	 * @return $this
	 *
	 * @throws \FigTree\Exceptions\UnreadablePathException
	 * @throws \FigTree\Config\Exceptions\InvalidConfigFileException
	 */
	protected function readData(string $path): ConfigInterface
	{
		if (!is_readable($path)) {
			throw new UnreadablePathException($path);
		}

		$reader = $this->createReader();

		$data = $reader->read($path);

		$this->data = array_replace_recursive($this->data, $data);

		return $this;
	}
}
