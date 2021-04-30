<?php

namespace FigTree\Config;

use FigTree\Config\Contracts\{
	ConfigReaderInterface,
};

class Config extends AbstractConfig
{
	/**
	 * Construct an instance of Config.
	 *
	 * @param string $fileName
	 */
	public function __construct(string $fileName)
	{
		$this->setFileName($fileName);
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
