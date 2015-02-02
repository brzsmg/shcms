<?php
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}

$tables[] = array(
	'name'   => 'queries',
	'struct' => array(
		'sid'          => 'varchar',
		'uid'          => 'integer',
		'date'         => 'integer',
		'ip'           => 'varchar',
		'query'        => 'varchar',
		'user_agent'   => 'text'
	),
	'unique' => NULL
);