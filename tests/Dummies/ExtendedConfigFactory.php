<?php

namespace FigTree\Config\Tests\Dummies;

use DateTime;
use FigTree\Config\AbstractConfigFactory;
use FigTree\Config\Contracts\ConfigInterface;

class ExtendedConfigFactory extends AbstractConfigFactory
{
	public function __construct(public DateTime $timestamp)
	{
		//
	}

	/**
	 * Create a Config instance.
	 *
	 * @param string $path
	 *
	 * @return \FigTree\Config\Contracts\ConfigInterface
	 */
	public function create(string $path): ConfigInterface
	{
		return new ExtendedConfig($this->timestamp, $path);
	}
}
