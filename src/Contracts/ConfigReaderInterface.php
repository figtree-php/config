<?php

namespace FigTree\Config\Contracts;

interface ConfigReaderInterface
{
	/**
	 * Read the contents of the Config file.
	 *
	 * @return array
	 */
	public function read(string $filename): array;
}
