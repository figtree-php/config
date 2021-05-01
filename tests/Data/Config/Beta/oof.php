<?php

return [

	'name' => 'Service Name',

	'server' => 'main',

	'servers' => [

		'main' => [
			'host' => 'http://www.service.com',
			'port' => 80,
			'secure' => false,
		],

		'alt' => [
			'host' => 'https://www.service.com',
			'port' => 443,
			'secure' => true,
		],

	],

];
