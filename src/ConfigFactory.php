<?php

namespace FigTree\Config;

use FigTree\Config\Contracts\ConfigInterface;

class ConfigFactory extends AbstractConfigFactory
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
