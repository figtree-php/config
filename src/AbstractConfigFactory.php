<?php

namespace FigTree\Config;

use FigTree\Exceptions\{
	InvalidDirectoryException,
	InvalidPathException,
	UnreadablePathException,
};
use FigTree\Config\Exceptions\InvalidConfigFilePathException;
use FigTree\Config\Contracts\{
	ConfigInterface,
	ConfigFactoryInterface,
};

abstract class AbstractConfigFactory implements ConfigFactoryInterface
{
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
