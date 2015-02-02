<?php
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}

$tables[] = array(
	'name'   => 'forms',
	'struct' => array(
		'sid'         => 'varchar',
		'form'        => 'varchar',
		'apply'       => 'boolean',
		'ip'          => 'varchar',
		'create_date' => 'varchar',
		'update_date' => 'varchar',
		'hash'        => 'varchar',
		'check_count' => 'integer',
		'name'        => 'varchar',
		'value'       => 'varchar'
	),
	'unique' => array('sid', 'form', 'apply')
);