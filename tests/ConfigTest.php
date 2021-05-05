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
	Contracts\ConfigRepositoryInterface,
	AbstractConfig,
	AbstractConfigRepository,
	Config,
	ConfigFactory,
	ConfigRepository,
};

class ConfigTest extends AbstractTestCase
{
	/**
	 * @small
	 */
	public function testConfigRepository()
	{
		$factory = new ConfigFactory();

		$this->assertInstanceOf(ConfigFactoryInterface::class, $factory);

		$repo = new ConfigRepository($factory);

		$this->assertInstanceOf(ConfigRepositoryInterface::class, $repo);
		$this->assertInstanceOf(AbstractConfigRepository::class, $repo);

		$repo->addDirectory(__DIR__ . '/Data/Config/Alpha');
		$repo->addDirectory(__DIR__ . '/Data/Config/Beta');

		$directories = $repo->getDirectories();

		$this->assertIsArray($directories);
		$this->assertCount(2, $directories);

		$this->assertEquals($this->path(__DIR__, 'Data', 'Config', 'Alpha'), $directories[0]);
		$this->assertEquals($this->path(__DIR__, 'Data', 'Config', 'Beta'), $directories[1]);
	}

	/**
	 * @small
	 */
	public function testConfigRepositoryInvalidDirectory()
	{
		$factory = new ConfigFactory();

		$repo = new ConfigRepository($factory);

		$this->expectException(InvalidDirectoryException::class);

		$repo->addDirectory(__FILE__);
	}

	/**
	 * @small
	 */
	public function testConfigFactoryInvalidPath()
	{
		$factory = new ConfigFactory();

		$repo = new ConfigRepository($factory);

		$this->expectException(InvalidPathException::class);

		$repo->addDirectory('foo');
	}

	/**
	 * @small
	 */
	public function testConfigInvalid()
	{
		$factory = new ConfigFactory();

		$repo = new ConfigRepository($factory);

		$repo->addDirectory(__DIR__ . '/Data/Config/Alpha');

		$this->expectException(InvalidConfigFileException::class);

		$repo->get('invalid');
	}

	/**
	 * @small
	 */
	public function testConfigOutOfBounds()
	{
		$factory = new ConfigFactory();

		$repo = new ConfigRepository($factory);

		$repo->addDirectory(__DIR__ . '/Data/Config/Alpha');

		$this->expectException(InvalidConfigFilePathException::class);

		$repo->get('../oob');
	}

	/**
	 * @small
	 */
	public function testConfigFactoryCreate()
	{
		$factory = new ConfigFactory();

		$config = $factory->create([
			__DIR__ . '/Data/Config/Alpha/foo.php'
		]);

		$this->assertInstanceOf(ConfigInterface::class, $config);
		$this->assertInstanceOf(AbstractConfig::class, $config);
		$this->assertInstanceOf(Config::class, $config);

		$paths = $config->getPaths();

		$this->assertCount(1, $paths);
		$this->assertEquals($this->path(__DIR__, 'Data', 'Config', 'Alpha', 'foo.php'), $paths[0]);
	}

	/**
	 * @small
	 */
	public function testConfigRepositoryGet()
	{
		$factory = new ConfigFactory();

		$repo = new ConfigRepository($factory);

		$repo->addDirectory(__DIR__ . '/Data/Config/Alpha');
		$repo->addDirectory(__DIR__ . '/Data/Config/Beta');

		$config = $repo->get('oof');

		$this->assertInstanceOf(ConfigInterface::class, $config);
		$this->assertInstanceOf(AbstractConfig::class, $config);
		$this->assertInstanceOf(Config::class, $config);

		$paths = $config->getPaths();

		$this->assertEquals($this->path(__DIR__, 'Data', 'Config', 'Beta', 'oof.php'), $paths[0]);

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

	/**
	 * @small
	 */
	public function testMergedConfig()
	{
		$factory = new ConfigFactory();

		$repo = new ConfigRepository($factory);

		$repo->addDirectory(__DIR__ . '/Data/Config/Alpha');
		$repo->addDirectory(__DIR__ . '/Data/Config/Beta');

		$config = $repo->get('bar');

		$this->assertEquals('new', $config['name']);

		$this->assertArrayHasKey('alpha', $config);

		$alpha = $config['alpha'];
		$this->assertArrayHasKey('colors', $alpha);
		$this->assertIsArray($alpha['colors']);

		$this->assertArrayHasKey('beta', $config);

		$beta = $config['beta'];
		$this->assertArrayHasKey('shapes', $beta);
		$this->assertIsArray($beta['shapes']);

		$this->assertArrayHasKey('servers', $config);

		$servers = $config['servers'];
		$this->assertCount(3, $servers);

		$server = $servers[0];

		$this->assertEquals('https://service.net', $server['host']);
		$this->assertEquals(443, $server['port']);
		$this->assertEquals('/api', $server['path']);
		$this->assertEquals('username', $server['username']);
		$this->assertEquals('This is my password, actually.', $server['password']);
		$this->assertEquals(1, $server['version']);

		$server = $servers[1];

		$this->assertEquals('https://service.net', $server['host']);
		$this->assertEquals(443, $server['port']);
		$this->assertEquals('/api', $server['path']);
		$this->assertEquals('username', $server['username']);
		$this->assertEquals('This is my password, actually.', $server['password']);
		$this->assertEquals(2, $server['version']);

		$server = $servers[2];

		$this->assertEquals('https://service.org', $server['host']);
		$this->assertEquals(443, $server['port']);
		$this->assertEquals('/api', $server['path']);
		$this->assertEquals('slj', $server['username']);
		$this->assertEquals('sn@kes on a Plane!', $server['password']);
		$this->assertEquals(2, $server['version']);
	}
}
