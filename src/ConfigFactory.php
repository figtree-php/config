<?php

namespace FigTree\Config;

use FigTree\Config\Contracts\ConfigInterface;
use FigTree\Config\Contracts\ConfigFactoryInterface;

class ConfigFactory implements ConfigFactoryInterface
{
	/**
	 * Create a Config instance.
	 *
	 * @param array $paths
	 *
	 * @return \FigTree\Config\Contracts\ConfigInterface
	 */
	public function create(array $paths): ConfigInterface
	{
		return new Config($paths);
	}
}
