<?php

namespace FigTree\Config\Concerns;

use FigTree\Config\ConfigFactory;
use FigTree\Config\Contracts\ConfigInterface;

trait Configurable
{
	/**
	 * ConfigFactory instance.
	 *
	 * @var \FigTree\Config\ConfigFactory
	 */
	protected ConfigFactory $configFactory;

	/**
	 * Set the Config instance.
	 *
	 * @param \FigTree\Config\ConfigFactory $configFactory
	 *
	 * @return $this
	 */
	public function setConfigFactory(ConfigFactory $configFactory)
	{
		$this->configFactory = $configFactory;

		return $this;
	}

	/**
	 * Shorthand to either get the associated Config instance or the given
	 * top-level key from the Config file.
	 *
	 * @param string $fileName
	 *
	 * @return \FigTree\Config\Config
	 */
	protected function config(string $fileName): ConfigInterface
	{
		return $this->configFactory->get($fileName);
	}
}
