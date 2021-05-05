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
	 * @param array $paths
	 *
	 * @return \FigTree\Config\Contracts\ConfigInterface
	 */
	public function create(array $paths): ConfigInterface
	{
		return new ExtendedConfig($this->timestamp, $paths);
	}
}
