<?php

namespace FigTree\Config\Contracts;

use ArrayAccess;
use IteratorAggregate;
use JsonSerializable;
use Stringable;

interface ConfigInterface extends ArrayAccess, IteratorAggregate, JsonSerializable, Stringable
{
	/**
	 * Get the paths of the associated files.
	 *
	 * @return array
	 */
	public function getPaths(): array;

	/**
	 * Convert the object into an array.
	 *
	 * @return array
	 */
	public function toArray(): array;

	/**
	 * Convert the object into JSON.
	 *
	 * @param integer $options
	 * @param integer $depth
	 *
	 * @return string
	 */
	public function toJson(int $options = 0, int $depth = 512): string;

	/**
	 * Convert the object into a string.
	 *
	 * @return string
	 */
	public function toString(): string;

	/**
	 * Create a ConfigReader instance.
	 *
	 * @return \FigTree\Config\Contracts\ConfigReaderInterface
	 */
	public function createReader(): ConfigReaderInterface;
}
