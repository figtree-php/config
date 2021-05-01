<?php

/**
 * @var \FigTree\Config\Tests\Dummies\ExtendedConfigReader $this
 */

$yesterday = (clone $this->timestamp)->sub(new DateInterval('P1D'));
$tomorrow = (clone $this->timestamp)->add(new DateInterval('P1D'));

return [

	'today' => $this->timestamp->format('Y-m-d'),

	'yesterday' => $yesterday->format('Y-m-d'),

	'tomorrow' => $tomorrow->format('Y-m-d'),
];
