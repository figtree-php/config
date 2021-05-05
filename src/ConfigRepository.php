<?php

namespace FigTree\Config;

use FigTree\Config\Contracts\ConfigFactoryInterface;

class ConfigRepository extends AbstractConfigRepository
{
	public function __construct(ConfigFactoryInterface $factory)
	{
		$this->factory = $factory;
	}
}
