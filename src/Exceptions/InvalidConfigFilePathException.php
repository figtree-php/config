<?php

namespace FigTree\Config\Exceptions;

use Throwable;
use FigTree\Exceptions\RuntimeException;

/**
 * Exception thrown when a Config file is outside the search directories.
 */
class InvalidConfigFilePathException extends RuntimeException
{
	/**
	 * Exception thrown when a Config file is outside the search directories.
	 *
	 * @param string $filename The path to the Config file.
	 * @param int $code The Exception code.
	 * @param \Throwable $previous The previous throwable used for the exception chaining.
	 */
	public function __construct(string $filename, int $code = 0, Throwable $previous = null)
	{
		$message = sprintf('Config file %s is outside the search directories.', $filename);

		parent::__construct($message, $code, $previous);
	}
}
