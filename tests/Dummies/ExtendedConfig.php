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
	 * @param string $fileName
	 */
	public function __construct(public DateTime $timestamp, string $fileName)
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
		return new ExtendedConfigReader($this->timestamp);
	}
}
