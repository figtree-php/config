<?php

namespace FigTree\Config\Tests\Dummies;

use DateTime;
use FigTree\Config\ConfigReader;

class ExtendedConfigReader extends ConfigReader
{
	public function __construct(public DateTime $timestamp)
	{
		//
	}
}
