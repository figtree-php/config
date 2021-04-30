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
 * Exception thrown when attempting to modify a Config value.
 */
class ReadOnlyException extends RuntimeException implements SevereExceptionInterface
{
	use HasSeverity;
	use SetsLocation;

	protected int $severity = E_ERROR;

	/**
	 * Exception thrown when attempting to modify a Config value.
	 *
	 * @param string|int $property The key of the value for which an attempt was made to modify the value.
	 * @param int $code The Exception code.
	 * @param \Throwable $previous The previous throwable used for the exception chaining.
	 */
	public function __construct($property, int $code = 0, Throwable $previous = null)
	{
		$message = sprintf('Cannot modify config property %s.', $property);

		parent::__construct($message, $code, $previous);
	}
}
