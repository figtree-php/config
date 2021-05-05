<?php

namespace FigTree\Config;

use FigTree\Exceptions\{
	InvalidPathException,
	InvalidDirectoryException,
	UnreadablePathException,
};
use FigTree\Config\Contracts\{
	ConfigRepositoryInterface,
	ConfigFactoryInterface,
	ConfigInterface,
};
use FigTree\Config\Exceptions\{
    InvalidConfigFileException,
    InvalidConfigFilePathException,
};

abstract class AbstractConfigRepository implements ConfigRepositoryInterface
{
	protected ConfigFactoryInterface $factory;

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
	public function addDirectory(string $directory): ConfigRepositoryInterface
	{
		$dir = $this->resolveDirectory($directory);

		$this->directories[] = $dir;

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

		$paths = $this->search($fileName);

		if (empty($paths)) {
			return null;
		}

		return $this->configs[$fileName] = $this->factory->create($paths);
	}

	/**
	 * Find all instances of the given file within configured directories.
	 *
	 * @param string $fileName
	 *
	 * @return array
	 */
	protected function search(string $fileName): array
	{
		$paths = [];

		foreach ($this->directories as $directory) {
			$fullPath = $this->resolveFile($directory, $fileName . '.php');

			if (!empty($fullPath)) {
				$paths[] = $fullPath;
			}
		}

		return $paths;
	}

	/**
	 * Resolve a given directory to an absolute path.
	 *
	 * @param string $directory
	 *
	 * @return string
	 *
	 * @throws \FigTree\Exceptions\InvalidDirectoryException
	 * @throws \FigTree\Exceptions\InvalidPathException
	 * @throws \FigTree\Exceptions\UnreadablePathException
	 */
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

	/**
	 * Resolve a file in a given directory to an absolute path,
	 * additionally ensuring the file exists within that directory.
	 *
	 * @param string $directory
	 * @param string $file
	 *
	 * @return string|null
	 *
	 * @throws \FigTree\Config\Exceptions\InvalidConfigFilePathException
	 */
	protected function resolveFile(string $directory, string $file): ?string
	{
		$prefix = $directory . DIRECTORY_SEPARATOR;

		$path = realpath($prefix . $file);

		if (empty($path) || !is_file($path) || !is_readable($path)) {
			return null;
		}

		if (!str_starts_with($path, $prefix)) {
			throw new InvalidConfigFilePathException($file);
		}

		return $path;
	}
}
