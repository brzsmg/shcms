<?php
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}

$tables[] = array(
	'name'   => 'users_fields',
	'struct' => array(
		'key'          => 'varchar',
		'position'     => 'integer',
		'title'        => 'varchar',
		'type'         => 'varchar',
		'input'        => 'varchar',
		'required'     => 'boolean',
		'registration' => 'boolean',
		'default'      => 'varchar'
	),
	'unique' => 'key',
	'rows' => array(
		array(
			'key'          => 'login',
			'position'     => '10',
			'title'        => 'Логин',
			'type'         => 'varchar',
			'input'        => 'text',
			'required'     => 'N',
			'registration' => 'N',
			'default'      => ''
		),
		array(
			'key'          => 'email',
			'position'     => '20',
			'title'        => 'Эл-почта',
			'type'         => 'varchar',
			'input'        => 'email',
			'required'     => 'Y',
			'registration' => 'Y',
			'default'      => ''
		),
		array(
			'key'          => 'password',
			'position'     => '30',
			'title'        => 'Пароль',
			'type'         => 'varchar',
			'input'        => 'password',
			'required'     => 'Y',
			'registration' => 'Y',
			'default'      => ''
		),
		array(
			'key'          => 'first_name',
			'position'     => '40',
			'title'        => 'Имя',
			'type'         => 'varchar',
			'input'        => 'text',
			'required'     => 'Y',
			'registration' => 'Y',
			'default'      => ''
		),
		array(
			'key'          => 'last_name',
			'position'     => '41',
			'title'        => 'Фамилия',
			'type'         => 'varchar',
			'input'        => 'text',
			'required'     => 'N',
			'registration' => 'Y',
			'default'      => ''
		),
		array(
			'key'          => 'middle_name',
			'position'     => '42',
			'title'        => 'Отчество',
			'type'         => 'varchar',
			'input'        => 'text',
			'required'     => 'N',
			'registration' => 'Y',
			'default'      => ''
		),
		array(
			'key'          => 'phone',
			'position'     => '50',
			'title'        => 'Телефон',
			'type'         => 'varchar',
			'input'        => 'phone',
			'required'     => 'N',
			'registration' => 'Y',
			'default'      => ''
		)
	)
);