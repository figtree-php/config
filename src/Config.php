<?php

namespace FigTree\Config;

use FigTree\Config\Contracts\{
	ConfigReaderInterface,
};

class Config extends AbstractConfig
{
	public function __construct(array $paths)
	{
		foreach ($paths as $path) {
			$this->addPath($path);
		}
	}

	/**
	 * Create a ConfigReader instance.
	 *
	 * @return \FigTree\Config\Contracts\ConfigReaderInterface
	 */
	public function createReader(): ConfigReaderInterface
	{
		return new ConfigReader();
	}
}
