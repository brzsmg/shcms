<?php
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}

$tables[] = array(
	'name'   => 'balance',
	'struct' => array(
		'uid'          => 'integer',
		'start_date'   => 'integer',
		'end_date'     => 'integer',
		'balance'      => 'integer',
		'update'         => 'integer',
		'reason'       => 'text',
	),
	'unique' => array('uid', 'start_date'),
	'rows' => array(
		array(
			'uid'          => 3000,
			'start_date'   => 1418128000,
			'end_date'     => 1418128299,
			'balance'      => 0,
			'update'       => 0,
			'reason'       => 'Open balance'
		),
		array(
			'uid'          => 3000,
			'start_date'   => 1418128000,
			'end_date'     => 1418128100,
			'balance'      => 5000,
			'update'       => 5000,
			'reason'       => 'Test add'
		),
		array(
			'uid'          => 3000,
			'start_date'   => 1418128100,
			'end_date'     => NULL,
			'balance'      => 4000,
			'update'       => -1000,
			'reason'       => 'Test diminish'
		)
	)
);