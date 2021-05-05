<?php

namespace FigTree\Config\Contracts;

interface ConfigurableInterface
{
	/**
	 * Set the Config instance.
	 *
	 * @param \FigTree\Config\Contracts\ConfigRepositoryInterface $configRepo
	 *
	 * @return $this
	 */
	public function setConfigRepository(ConfigRepositoryInterface $configRepo);
}
