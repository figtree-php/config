<?php

namespace FigTree\Config\Contracts;

interface ConfigFactoryInterface
{
	/**
	 * Create a Config instance.
	 *
	 * @param array $paths
	 *
	 * @return \FigTree\Config\Contracts\ConfigInterface
	 */
	public function create(array $paths): ConfigInterface;
}
