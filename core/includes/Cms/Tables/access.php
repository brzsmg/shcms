<?php
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}

$tables[] = array(
	'name'   => 'access',
	'struct' => array(
		'uid'          => 'integer',
		'source'       => 'varchar',
		'oid'          => 'integer',
		'right'        => 'varchar',
		'value'        => 'boolean'
	),
	'unique' => array('uid', 'source', 'oid', 'right'),
	'rows' => array(
		array(
			'uid'     => 0,
			'source'  => '',
			'oid'     => 0,
			'right'   => '',
			'value'   => 'Y'
		),
		array(
			'uid'     => 2000,
			'source'  => '',
			'oid'     => 0,
			'right'   => '',
			'value'   => 'Y'
		),
		array(
			'uid'     => 3000,
			'source'  => '',
			'oid'     => 0,
			'right'   => '',
			'value'   => 'Y'
		),
		
		
	)
);