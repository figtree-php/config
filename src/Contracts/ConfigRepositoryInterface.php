<?php

namespace FigTree\Config\Contracts;

interface ConfigRepositoryInterface
{
	/**
	 * Get the directories to search for a Config file.
	 *
	 * @return array
	 */
	public function getDirectories(): array;

	/**
	 * Add a directory to search for a Config file.
	 *
	 * @param string $directory
	 *
	 * @return $this
	 */
	public function addDirectory(string $directory): ConfigRepositoryInterface;

	/**
	 * Search for a Config instance from the list of applicable directories.
	 * Returns null if it could not be found.
	 *
	 * @param string $fileName
	 *
	 * @return \FigTree\Config\Contracts\ConfigInterface|null
	 */
	public function get(string $fileName): ?ConfigInterface;
}
