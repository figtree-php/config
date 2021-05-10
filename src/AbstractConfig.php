<?php

namespace FigTree\Config;

use ArrayIterator;
use Traversable;
use FigTree\Exceptions\{
	InvalidFileException,
	InvalidPathException,
	UnreadablePathException,
};
use FigTree\Config\Exceptions\ReadOnlyException;
use FigTree\Config\Contracts\ConfigInterface;

abstract class AbstractConfig implements ConfigInterface
{
	/**
	 * Paths of underlying Config files.
	 */
	protected array $paths = [];

	/**
	 * Configuration data.
	 */
	protected array $data = [];

	/**
	 * Indicates if Config data has already been read.
	 */
	protected bool $isRead = false;

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
	 * Magic method to handle key_exists/isset checks of an array value on the object.
	 *
	 * @param string|int $offset
	 *
	 * @return boolean
	 */
	public function offsetExists($offset): bool
	{
		$this->read();

		return key_exists($offset, $this->data);
	}

	/**
	 * Magic method to handle retrieval of an array value on the object.
	 *
	 * @param string|int $offset
	 *
	 * @return mixed
	 */
	public function offsetGet($offset)
	{
		return $this->read()->data[$offset] ?? null;
	}

	/**
	 * Magic method to handle modification of an array value on the object.
	 *
	 * @param string|int $offset
	 * @param mixed $value
	 *
	 * @return void
	 *
	 * @throws \FigTree\Config\Exceptions\ReadOnlyException
	 */
	public function offsetSet($offset, $value): void
	{
		throw new ReadOnlyException($offset);
	}

	/**
	 * Magic method to handle removal of an array value on the object.
	 *
	 * @param string|int $offset
	 *
	 * @return void
	 *
	 * @throws \FigTree\Config\Exceptions\ReadOnlyException
	 */
	public function offsetUnset($offset): void
	{
		throw new ReadOnlyException($offset);
	}

	/**
	 * Convert the object into an array.
	 *
	 * @return array
	 */
	public function toArray(): array
	{
		return $this->read()->data;
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
	 * Retrieve an external iterator.
	 *
	 * @return \Traversable
	 */
	public function getIterator(): Traversable
	{
		return new ArrayIterator($this->data);
	}

	/**
	 * Resolve the given filename of a Config file, add it to the
	 * array of files, and mark the Config as unread.
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

		$this->isRead = false;

		return $this;
	}

	/**
	 * Clear and read in all Config data.
	 *
	 * @return $this
	 */
	protected function read()
	{
		if ($this->isRead) {
			return $this;
		}

		$this->data = [];

		foreach ($this->paths as $path) {
			$this->readFile($path);
		}

		$this->isRead = true;

		return $this;
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
	protected function readFile(string $path): ConfigInterface
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
