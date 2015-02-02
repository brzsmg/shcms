<?php
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}

$tables[] = array(
	'name'   => 'configuration',
	'struct' => array(
		'module'      => 'varchar',
		'key'         => 'varchar',
		'value'       => 'varchar',
		'description' => 'varchar'
	),
	'unique' => array('module', 'key'),
	'rows' => array(
		array(
			'module'      => 'core',
			'key'         => 'session_time',
			'value'       => (string)(60 * 60 * 24 * 365),
			'description' => 'Время действия сессии клиента'
		),
		array(
			'module'      => 'core',
			'key'         => 'registration',
			'value'       => 'Y',
			'description' => 'Разрешить регистрацию'
		),
		array(
			'module'      => 'core',
			'key'         => 'guest_id',
			'value'       => '2000',
			'description' => 'Идентификтор не аутентифицированого пользователя'
		),
		array(
			'module'      => 'core',
			'key'         => 'section_error',
			'value'       => '5',
			'description' => 'Раздел с ошибкой'
		),
		array(
			'module'      => 'core',
			'key'         => 'section_menu',
			'value'       => '8',
			'description' => 'Главное меню'
		),
		array(
			'module'      => 'core',
			'key'         => 'section_start',
			'value'       => '9',
			'description' => 'Главная страница' 
		),
		array(
			'module'      => 'core',
			'key'         => 'theme',
			'value'       => 'core',
			'description' => 'Тема оформления'
		)
	)
);