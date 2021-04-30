<?php

namespace FigTree\Config\Contracts;

use FigTree\Config\ConfigFactory;

interface ConfigurableInterface
{
	/**
	 * Set the ConfigFactory instance.
	 *
	 * @param \FigTree\Config\ConfigFactory $configFactory
	 */
	public function setConfigFactory(ConfigFactory $configFactory);
}
