<?php

namespace FigTree\Config\Concerns;

use FigTree\Config\Contracts\{
	ConfigRepositoryInterface,
	ConfigInterface,
	ConfigurableInterface,
};

trait Configurable
{
	/**
	 * ConfigRepository instance.
	 *
	 * @var \FigTree\Config\Contracts\ConfigRepositoryInterface
	 */
	protected ConfigRepositoryInterface $configRepo;

	/**
	 * Set the Config instance.
	 *
	 * @param \FigTree\Config\Contracts\ConfigRepositoryInterface $configRepo
	 *
	 * @return $this
	 */
	public function setConfigRepository(ConfigRepositoryInterface $configRepo): ConfigurableInterface
	{
		$this->configRepo = $configRepo;

		return $this;
	}

	/**
	 * Shorthand to either get the associated Config instance or the given
	 * top-level key from the Config file.
	 *
	 * @param string $fileName
	 *
	 * @return \FigTree\Config\Contracts\ConfigInterface
	 */
	protected function config(string $fileName): ConfigInterface
	{
		return $this->configRepo->get($fileName);
	}
}
