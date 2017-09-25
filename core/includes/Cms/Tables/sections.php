<?php
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}

$tables[] = array(
	'name'   => 'sections',
	'struct' => array(
		'id'           => 'integer',
		'parent_id'    => 'integer',
		'name'         => 'varchar',
		'title'        => 'varchar',
		'description'  => 'text',
		'view'         => 'varchar',
		'data'         => 'varchar'
	),
	'unique' => 'id',
	'rows' => array(
		array(
			'id'          => 1,
			'parent_id'   => 0,
			'name'        => '',
			'title'       => 'Системные разделы',
			'description' => '',
			'view'        => '',
			'data'        => ''
		),
		array(
			'id'          => 4,
			'parent_id'   => 1,
			'name'        => 'messages',
			'title'       => 'Сообщения',
			'description' => '',
			'view'        => 'Messages',
			'data'        => ''
		),
		array(
			'id'          => 4,
			'parent_id'   => 1,
			'name'        => 'users',
			'title'       => 'Страница пользователя',
			'description' => '',
			'view'        => 'User',
			'data'        => ''
		),
		array(
			'id'          => 5,
			'parent_id'   => 1,
			'name'        => '',
			'title'       => 'Страница с ошибкой',
			'description' => '',
			'view'        => 'Error',
			'data'        => ''
		),
		array(
			'id'          => 6,
			'parent_id'   => 1,
			'name'        => 'enter',
			'title'       => 'Вход',
			'description' => 'Страница для аутентификации',
			'view'        => 'Authentication',
			'data'        => ''
		),
		array(
			'id'          => 7,
			'parent_id'   => 1,
			'name'        => 'registration',
			'title'       => 'Регистрация',
			'description' => 'Страница для регистрации пользователей',
			'view'        => 'Registration',
			'data'        => ''
		),
		array(
			'id'          => 8,
			'parent_id'   => 0,
			'name'        => '',
			'title'       => 'Разделы',
			'description' => 'Главное меню',
			'view'        => '',
			'data'        => ''
		),
		array(
			'id'          => 9,
			'parent_id'   => 8,
			'name'        => 'home',
			'title'       => 'Главная',
			'description' => 'Главная страница',
			'view'        => 'Article',
			'data'        => '10'
		)
	)
);