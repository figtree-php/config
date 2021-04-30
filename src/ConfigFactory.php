<?php

namespace FigTree\Config;

use FigTree\Config\Contracts\ConfigInterface;

class ConfigFactory extends AbstractConfigFactory
{
	/**
	 * Create a Config instance.
	 *
	 * @param string $path
	 *
	 * @return \FigTree\Config\Contracts\ConfigInterface
	 */
	public function create(string $path): ConfigInterface
	{
		return new Config($path);
	}
}
