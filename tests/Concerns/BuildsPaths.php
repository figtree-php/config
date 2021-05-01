<?php

namespace FigTree\Config\Tests\Concerns;

trait BuildsPaths
{
	protected function path(string ...$parts)
	{
		return implode(DIRECTORY_SEPARATOR, $parts);
	}
}
