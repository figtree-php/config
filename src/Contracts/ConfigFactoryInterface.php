<?php

namespace FigTree\Config\Contracts;

interface ConfigFactoryInterface
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
	public function addDirectory(string $directory): ConfigFactoryInterface;

	/**
	 * Search for a Config file from the list of applicable directories.
	 * Returns null if it could not be found.
	 *
	 * @param string $fileName
	 *
	 * @return \FigTree\Config\Contracts\ConfigInterface|null
	 */
	public function get(string $fileName): ?ConfigInterface;

	/**
	 * Create a Config instance.
	 *
	 * @param string $path
	 *
	 * @return \FigTree\Config\Contracts\ConfigInterface
	 */
	public function create(string $path): ConfigInterface;
}
