<?php

namespace FigTree\Config\Tests;

use FigTree\Exceptions\{
	InvalidDirectoryException,
	InvalidPathException,
};
use FigTree\Config\{
	Exceptions\InvalidConfigFileException,
	Exceptions\InvalidConfigFilePathException,
	Contracts\ConfigInterface,
	Contracts\ConfigFactoryInterface,
	AbstractConfig,
	AbstractConfigFactory,
	Config,
	ConfigFactory,
};

class ConfigTest extends AbstractTestCase
{
	/**
	 * @small
	 */
	public function testConfigFactory()
	{
		$factory = new ConfigFactory();

		$this->assertInstanceOf(ConfigFactoryInterface::class, $factory);
		$this->assertInstanceOf(AbstractConfigFactory::class, $factory);
		$this->assertInstanceOf(ConfigFactory::class, $factory);

		$factory->addDirectory(__DIR__ . '/Data/Config/Alpha');
		$factory->addDirectory(__DIR__ . '/Data/Config/Beta');

		$directories = $factory->getDirectories();

		$this->assertIsArray($directories);
		$this->assertCount(2, $directories);

		$this->assertEquals($this->path(__DIR__, 'Data', 'Config', 'Alpha'), $directories[0]);
		$this->assertEquals($this->path(__DIR__, 'Data', 'Config', 'Beta'), $directories[1]);
	}

	/**
	 * @small
	 */
	public function testConfigFactoryInvalidDirectory()
	{
		$factory = new ConfigFactory();

		$this->expectException(InvalidDirectoryException::class);

		$factory->addDirectory(__FILE__);
	}

	/**
	 * @small
	 */
	public function testConfigFactoryInvalidPath()
	{
		$factory = new ConfigFactory();

		$this->expectException(InvalidPathException::class);

		$factory->addDirectory('foo');
	}

	/**
	 * @small
	 */
	public function testConfigInvalid()
	{
		$factory = new ConfigFactory();

		$factory->addDirectory(__DIR__ . '/Data/Config/Alpha');

		$this->expectException(InvalidConfigFileException::class);

		$factory->get('invalid');
	}

	/**
	 * @small
	 */
	public function testConfigOutOfBounds()
	{
		$factory = new ConfigFactory();

		$factory->addDirectory(__DIR__ . '/Data/Config/Alpha');

		$this->expectException(InvalidConfigFilePathException::class);

		$factory->get('../oob');
	}

	/**
	 * @small
	 */
	public function testConfigFactoryCreate()
	{
		$factory = new ConfigFactory();

		$config = $factory->create(__DIR__ . '/Data/Config/Alpha/foo.php');

		$this->assertInstanceOf(ConfigInterface::class, $config);
		$this->assertInstanceOf(AbstractConfig::class, $config);
		$this->assertInstanceOf(Config::class, $config);

		$this->assertEquals($this->path(__DIR__, 'Data', 'Config', 'Alpha', 'foo.php'), $config->getFileName());
	}

	/**
	 * @small
	 */
	public function testConfigFactoryGet()
	{
		$factory = new ConfigFactory();

		$factory->addDirectory(__DIR__ . '/Data/Config/Alpha');
		$factory->addDirectory(__DIR__ . '/Data/Config/Beta');

		$config = $factory->get('oof');

		$this->assertInstanceOf(ConfigInterface::class, $config);
		$this->assertInstanceOf(AbstractConfig::class, $config);
		$this->assertInstanceOf(Config::class, $config);

		$this->assertEquals($this->path(__DIR__, 'Data', 'Config', 'Beta', 'oof.php'), $config->getFileName());

		$this->assertEquals('Service Name', $config['name']);
		$this->assertEquals('main', $config['server']);

		$servers = $config['servers'];

		$this->assertIsArray($servers);
		$this->assertArrayHasKey('main', $servers);
		$this->assertArrayHasKey('alt', $servers);

		$this->assertArrayHasKey($config['server'], $servers);

		$main = $servers['main'];

		$this->assertIsArray($main);

		$this->assertArrayHasKey('host', $main);
		$this->assertIsString($main['host']);
		$this->assertEquals('http://www.service.com', $main['host']);

		$this->assertArrayHasKey('port', $main);
		$this->assertIsInt($main['port']);
		$this->assertEquals(80, $main['port']);

		$this->assertArrayHasKey('secure', $main);
		$this->assertIsBool($main['secure']);
		$this->assertEquals(false, $main['secure']);

		$alt = $servers['alt'];

		$this->assertIsArray($alt);

		$this->assertArrayHasKey('host', $alt);
		$this->assertIsString($alt['host']);
		$this->assertEquals('https://www.service.com', $alt['host']);

		$this->assertArrayHasKey('port', $alt);
		$this->assertIsInt($alt['port']);
		$this->assertEquals(443, $alt['port']);

		$this->assertArrayHasKey('secure', $alt);
		$this->assertIsBool($alt['secure']);
		$this->assertEquals(true, $alt['secure']);
	}
}
