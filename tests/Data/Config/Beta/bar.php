<?php

return [

	'name' => 'new',

	'beta' => [

		'shapes' => [
			'ellipse',
			'superellipse',
			'astroid',
			'cardioid',
			'deltoid',
			'lemniscate',
			'henagon',
			'polygon',
			'polygram',
			'apeirogon',
		]

	],

	'servers' => [

		[
			'host' => 'https://service.net',
			'port' => 443,
			'path' => '/api',
			'username' => 'username',
			'password' => 'This is my password, actually.',
			'version' => 1,
		],

		[
			'host' => 'https://service.net',
			'port' => 443,
			'path' => '/api',
			'username' => 'username',
			'password' => 'This is my password, actually.',
			'version' => 2,
		],

		[
			'host' => 'https://service.org',
			'port' => 443,
			'path' => '/api',
			'username' => 'slj',
			'password' => 'sn@kes on a Plane!',
			'version' => 2,
		],

	],

];
