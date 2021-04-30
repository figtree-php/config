<?php

namespace FigTree\Config\Concerns;

use FigTree\Config\Exceptions\{
	ReadOnlyException,
};

trait ArrayAccessData
{
	protected array $data = [];

	/**
	 * Magic method to handle key_exists/isset checks of an array value on the object.
	 *
	 * @param string|int $offset
	 *
	 * @return boolean
	 */
	public function offsetExists($offset): bool
	{
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
		return $this->data[$offset] ?? null;
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
		return $this->data;
	}
}
