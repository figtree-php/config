<?php

namespace FigTree\Config;

use Throwable;
use FigTree\Config\Contracts\ConfigReaderInterface;
use FigTree\Config\Exceptions\InvalidConfigFileException;

class ConfigReader implements ConfigReaderInterface
{
	/**
	 * Read the contents of the Config file.
	 *
	 * @return array
	 */
	public function read(string $filename): array
	{
		try {
			return (require $filename);
		} catch (Throwable $exc) {
			throw new InvalidConfigFileException($filename, 0, $exc);
		}
	}
}
