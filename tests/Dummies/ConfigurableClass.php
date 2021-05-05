<?php

namespace FigTree\Config\Tests\Dummies;

use FigTree\Config\Concerns\Configurable;
use FigTree\Config\Contracts\ConfigRepositoryInterface;
use FigTree\Config\Contracts\ConfigurableInterface;

class ConfigurableClass implements ConfigurableInterface
{
	use Configurable;

	public function __construct(ConfigRepositoryInterface $configRepo)
	{
		$this->setConfigRepository($configRepo);
	}

	public function getName(): string
	{
		return $this->config('bar')['name'];
	}
}
