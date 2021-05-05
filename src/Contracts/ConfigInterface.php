<?php

namespace FigTree\Config\Contracts;

use ArrayAccess;
use IteratorAggregate;
use JsonSerializable;
use Stringable;

interface ConfigInterface extends ArrayAccess, IteratorAggregate, JsonSerializable, Stringable
{
	/**
	 * Get the name of the underlying Config file.
	 *
	 * @return string
	 */
	public function getFileName(): string;

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
