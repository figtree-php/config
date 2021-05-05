<?php

namespace FigTree\Config;

use FigTree\Config\Contracts\ConfigFactoryInterface;

class ConfigRepository extends AbstractConfigRepository
{
	/**
	 * Construct an instance of ConfigRepository.
	 *
	 * @param \FigTree\Config\Contracts\ConfigFactoryInterface $factory
	 */
	public function __construct(ConfigFactoryInterface $factory)
	{
		$this->factory = $factory;
	}
}
