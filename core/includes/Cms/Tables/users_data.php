<?php
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}

$tables[] = array(
	'name'   => 'users_data',
	'struct' => array(
		'id'         => 'integer',
		'key'        => 'varchar',
		'value'      => 'varchar'
	),
	'unique' => array('id','key'),
	'rows' => array(
		array(
			'id'     => 1000,
			'key'    => 'first_name',
			'value'  => 'Система'
		),
		array(
			'id'     => 2000,
			'key'    => 'first_name',
			'value'  => 'Гость'
		),
		array(
			'id'     => 3000,
			'key'    => 'first_name',
			'value'  => 'Администратор'
		),
		array(//В релизе надо будет удалить
			'id'     => 3000,
			'key'    => 'password',
			'value'  => '202cb962ac59075b964b07152d234b70'
		),
		array(
			'id'     => 3000,
			'key'    => 'email',
			'value'  => 'admin@'
		),
		
		array(
			'id'     => 4000,
			'key'    => 'first_name',
			'value'  => 'Василий'
		),
		array(
			'id'     => 4000,
			'key'    => 'last_name',
			'value'  => 'Иванов'
		),
		array(
			'id'     => 4000,
			'key'    => 'middle_name',
			'value'  => 'Петрович'
		),
		array(//В релизе надо будет удалить
			'id'     => 4000,
			'key'    => 'password',
			'value'  => '202cb962ac59075b964b07152d234b70'
		),
		array(
			'id'     => 4000,
			'key'    => 'email',
			'value'  => 'ivan@mail.ru'
		),
		array(
			'id'     => 4000,
			'key'    => 'phone',
			'value'  => '+7 908 1234567'
		)
		
	)
);