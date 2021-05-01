<?php

namespace FigTree\Config\Tests;

use PHPUnit\Framework\TestCase;
use FigTree\Config\Tests\Concerns\BuildsPaths;

abstract class AbstractTestCase extends TestCase
{
	use BuildsPaths;
}
