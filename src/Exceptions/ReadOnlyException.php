<?php

namespace FigTree\Config\Exceptions;

use Throwable;
use FigTree\Exceptions\RuntimeException;

/**
 * Exception thrown when attempting to modify a Config value.
 */
class ReadOnlyException extends RuntimeException
{
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
