<?php

namespace FigTree\Config\Tests\Dummies;

use DateTime;
use FigTree\Config\AbstractConfig;
use FigTree\Config\Contracts\ConfigReaderInterface;

class ExtendedConfig extends AbstractConfig
{
	/**
	 * Construct an instance of Config.
	 *
	 * @param \DateTime $timestamp
	 * @param array $paths
	 */
	public function __construct(public DateTime $timestamp, array $paths)
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
		return new ExtendedConfigReader($this->timestamp);
	}
}
