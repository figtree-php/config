<?php

namespace FigTree\Config;

use FigTree\Config\Contracts\ConfigReaderInterface;

class ConfigReader implements ConfigReaderInterface
{
	/**
	 * Read the contents of the Config file.
	 *
	 * @return array
	 */
	public function read(string $filename): array
	{
		return (require $filename);
	}
}
