<?php
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}

$tables[] = array(
	'name'   => 'apps',
	'struct' => array(
		'id'          => 'integer',
		'source'      => 'varchar',
		'oid'         => 'integer',
		'position'    => 'integer',
		'name'        => 'varchar',
		'description' => 'text',
		'type'        => 'varchar',
		'mime'        => 'varchar',
		'path'        => 'varchar',
		'data'        => 'blob',
	),
	'identity' => 'id',
	'unique' => array('id', 'source', 'oid'),
	'description' => 'Приложения для объектов',
	'rows' => array(
		array(
			'id'         => 101,
			'source'     => 'users',
			'oid'        => 1000,
			'position'   => 0,
			'name'       => '',
			'description'=> '',
			'type'       => 'avatar',
			'mime'       => 'image/png',
			'path'       => 'users/1000.png',
			'data'       => NULL
		),
		array(
			'id'         => 102,
			'source'     => 'users',
			'oid'        => 2000,
			'position'   => 0,
			'name'       => '',
			'description'=> '',
			'type'       => 'avatar',
			'mime'       => 'image/png',
			'path'       => 'users/2000.png',
			'data'       => NULL
		),
		array(
			'id'         => 103,
			'source'     => 'users',
			'oid'        => 3000,
			'position'   => 0,
			'name'       => '',
			'description'=> '',
			'type'       => 'avatar',
			'mime'       => 'image/png',
			'path'       => 'users/3000.png',
			'data'       => NULL
		)
	)
);