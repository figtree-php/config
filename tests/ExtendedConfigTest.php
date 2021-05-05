<?php

namespace FigTree\Config\Tests;

use DateInterval;
use DateTime;
use FigTree\Config\{
	Contracts\ConfigFactoryInterface,
	Contracts\ConfigInterface,
	AbstractConfig,
	ConfigRepository,
};
use FigTree\Config\Tests\Dummies\{
	ExtendedConfigFactory,
	ExtendedConfig,
	ExtendedConfigReader,
};

class ExtendedConfigTest extends AbstractTestCase
{
	/**
	 * @small
	 */
	public function testConfigFactory()
	{
		$timestamp = new DateTime();

		$factory = new ExtendedConfigFactory($timestamp);

		$this->assertInstanceOf(ConfigFactoryInterface::class, $factory);
		$this->assertInstanceOf(ExtendedConfigFactory::class, $factory);

		$repo = new ConfigRepository($factory);

		$repo->addDirectory(__DIR__ . '/Data/Config/Extended');

		$directories = $repo->getDirectories();

		$this->assertIsArray($directories);
		$this->assertCount(1, $directories);

		$this->assertEquals($this->path(__DIR__, 'Data', 'Config', 'Extended'), $directories[0]);
	}

	public function testConfig()
	{
		$today = new DateTime();
		$yesterday = (clone $today)->sub(new DateInterval('P1D'));
		$tomorrow = (clone $today)->add(new DateInterval('P1D'));

		$factory = new ExtendedConfigFactory($today);

		$repo = new ConfigRepository($factory);

		$repo->addDirectory(__DIR__ . '/Data/Config/Extended');

		$config = $repo->get('file');

		$this->assertInstanceOf(ConfigInterface::class, $config);
		$this->assertInstanceOf(AbstractConfig::class, $config);
		$this->assertInstanceOf(ExtendedConfig::class, $config);

		$this->assertArrayHasKey('today', $config);
		$this->assertArrayHasKey('yesterday', $config);
		$this->assertArrayHasKey('tomorrow', $config);

		$this->assertIsString($config['today']);
		$this->assertEquals($today->format('Y-m-d'), $config['today']);

		$this->assertIsString($config['yesterday']);
		$this->assertEquals($yesterday->format('Y-m-d'), $config['yesterday']);

		$this->assertIsString($config['tomorrow']);
		$this->assertEquals($tomorrow->format('Y-m-d'), $config['tomorrow']);
	}
}
