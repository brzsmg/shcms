<?php
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}

$tables[] = array(
	'name'   => 'docs',
	'struct' => array(
		'id'           => 'integer',
		'parent_table' => 'varchar',
		'parent_id'    => 'integer',
		'position'     => 'integer',
		'name'         => 'varchar',
		'description'  => 'text',
		'type'         => 'varchar',
		'mime'         => 'varchar',
		'size'         => 'integer',
		'path'         => 'varchar',
		'data'         => 'blob',
	),
	'identity'    => 'id',
	'unique'      => array('id', 'parent_table', 'parent_id'),
	'start'       => 1000,
	'description' => 'Приложения для объектов',
	'rows' => array(
		array(
			'id'           => 101,
			'parent_table' => 'users',
			'parent_id'    => 1000,
			'position'     => 0,
			'name'         => '',
			'description'  => '',
			'type'         => 'avatar',
			'mime'         => 'image/png',
			'size'         => '1',
			'path'         => 'users/1000.png',
			'data'         => NULL
		),
		array(
			'id'           => 102,
			'parent_table' => 'users',
			'parent_id'    => 2000,
			'position'     => 0,
			'name'         => '',
			'description'  => '',
			'type'         => 'avatar',
			'mime'         => 'image/png',
			'size'         => '1',
			'path'         => 'users/2000.png',
			'data'         => NULL
		),
		array(
			'id'           => 103,
			'parent_table' => 'users',
			'parent_id'    => 3000,
			'position'     => 0,
			'name'         => '',
			'description'  => '',
			'type'         => 'avatar',
			'mime'         => 'image/png',
			'size'         => '1',
			'path'         => 'users/3000.png',
			'data'         => NULL
		)
	)
);