<?php

namespace FigTree\Config;

use FigTree\Config\Contracts\{
	ConfigFactoryInterface,
	ConfigRepositoryInterface,
};

class ConfigRepository extends AbstractConfigRepository
{
	/**
	 * Helper method to construct a ConfigRepository instance with a default ConfigFactory.
	 *
	 * @return \FigTree\Config\Contracts\ConfigRepositoryInterface
	 */
	public static function create(): ConfigRepositoryInterface
	{
		$factory = new ConfigFactory();

		$instance = new static($factory);

		return $instance;
	}

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
