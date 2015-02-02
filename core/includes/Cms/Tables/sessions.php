<?php
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}

$tables[] = array(
	'name'   => 'sessions',
	'struct' => array(
		'create_date' => 'integer',
		'update_date' => 'integer',
		'sid'         => 'varchar',
		'uid'         => 'integer',
		'cookie_date' => 'integer',
		'auth_date'   => 'integer'
	),
	'unique' => 'sid'
);
$tables[] = array(
	'name'   => 'sessions_data',
	'struct' => array(
		'sid'   => 'varchar',
		'key'   => 'varchar',
		'value' => 'varchar'
	)
);