<?php

namespace FigTree\Config\Exceptions;

use Throwable;
use RuntimeException;
use FigTree\Exceptions\Contracts\SevereExceptionInterface;
use FigTree\Exceptions\Concerns\{
	HasSeverity,
	SetsLocation
};

/**
 * Exception thrown when a Config file is invalid or fails to parse.
 */
class InvalidConfigFileException extends RuntimeException implements SevereExceptionInterface
{
	use HasSeverity;
	use SetsLocation;

	protected int $severity = E_ERROR;

	/**
	 * Exception thrown when a Config file is invalid or fails to parse.
	 *
	 * @param string $filename The path to the Config file.
	 * @param int $code The Exception code.
	 * @param \Throwable $previous The previous throwable used for the exception chaining.
	 */
	public function __construct(string $filename, int $code = 0, Throwable $previous = null)
	{
		$message = sprintf('Config file %s could not be parsed.', $filename);

		parent::__construct($message, $code, $previous);
	}
}
