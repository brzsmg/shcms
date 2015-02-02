<?php
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}

$tables[] = array(
	'name'   => 'favorites',
	'struct' => array(
		'source'      => 'varchar',
		'id'          => 'integer',
		'uid'         => 'integer',
		'create_date' => 'integer'
	),
	'identity' => 'id',
	'unique' => array('source', 'id', 'uid'),
	'description' => 'Избранное',
);