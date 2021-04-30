<?php

namespace FigTree\Config;

use FigTree\Exceptions\{
	InvalidDirectoryException,
	InvalidPathException,
	UnreadablePathException,
};
use FigTree\Config\Contracts\{
	ConfigInterface,
	ConfigFactoryInterface,
};

abstract class AbstractConfigFactory implements ConfigFactoryInterface
{
	/**
	 * Config file directories.
	 *
	 * @var array
	 */
	protected $directories = [];

	/**
	 * Cached Config objects.
	 *
	 * @var array
	 */
	protected $configs = [];

	/**
	 * Get the directories to search for a Config file.
	 *
	 * @return array
	 */
	public function getDirectories(): array
	{
		return $this->directories;
	}

	/**
	 * Add a directory to search for a Config file.
	 *
	 * @param string $directory
	 *
	 * @return $this
	 */
	public function addDirectory(string $directory): ConfigFactory
	{
		$dir = $this->resolveDirectory($directory);

		$this->directories[] = $directory;

		return $this;
	}

	/**
	 * Search for a Config file from the list of applicable directories.
	 * Returns null if it could not be found.
	 *
	 * @param string $fileName
	 *
	 * @return \FigTree\Config\Contracts\ConfigInterface|null
	 */
	public function get(string $fileName): ?ConfigInterface
	{
		if (key_exists($fileName, $this->configs)) {
			return $this->configs[$fileName];
		}

		foreach ($this->directories as $directory) {
			$fullPath = $this->resolveFile($directory, $fileName . '.php');

			if (!empty($fullPath)) {
				return ($this->configs[$fileName] = $this->create($fullPath));
			}
		}

		return null;
	}

	protected function resolveDirectory(string $directory): string
	{
		$dir = realpath($directory);

		if (empty($dir)) {
			throw new InvalidPathException($directory);
		}

		if (!is_dir($dir)) {
			throw new InvalidDirectoryException($directory);
		}

		if (!is_readable($dir)) {
			throw new UnreadablePathException(sprintf('Directory %s is not readable.', $dir));
		}

		return $dir;
	}

	protected function resolveFile(string $directory, string $file)
	{
		$prefix = $directory . DIRECTORY_SEPARATOR;

		$path = realpath($prefix . $file);

		if (empty($path) || !is_file($path) || !is_readable($path)) {
			return null;
		}

		return $path;
	}
}
