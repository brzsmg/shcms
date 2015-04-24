<?php
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}

$tables[] = array(
	'name'   => 'users',
	'struct' => array(
		'id'           => 'integer',
		'start_date'   => 'integer',
		'close_date'   => 'integer',
		'create_date'  => 'integer',
		'update_date'  => 'integer',
		'create_user'  => 'integer',
		'update_user'  => 'integer',
		'reason'       => 'varchar'
	),
	'identity' => 'id',
	'unique'   => 'id',
	'rows' => array(
		array(
			'id'           => 1000,
			'start_date'   => 1418128299,
			'close_date'   => 0,
			'create_date'  => 1418128299,
			'update_date'  => 1418128299,
			'create_user'  => 1000,
			'update_user'  => 1000,
			'reason'       => 'Создана учетная записть Системы'
		),
		array(
			'id'           => 2000,
			'start_date'   => 1418128299,
			'close_date'   => 0,
			'create_date'  => 1418128299,
			'update_date'  => 1418128299,
			'create_user'  => 1000,
			'update_user'  => 1000,
			'reason'       => 'Создана учетная запись Гостя'
		),
		array(
			'id'           => 3000,
			'start_date'   => 1418128299,
			'close_date'   => 0,
			'create_date'  => 1418128299,
			'update_date'  => 1418128299,
			'create_user'  => 1000,
			'update_user'  => 1000,
			'reason'       => 'Создана учетная запись Администратора'
		),
		array(
			'id'           => 4000,
			'start_date'   => 1418128299,
			'close_date'   => 0,
			'create_date'  => 1418128299,
			'update_date'  => 1418128299,
			'create_user'  => 2000,
			'update_user'  => 2000,
			'reason'       => 'Зарегистрирован новый пользователь'
		)
		
		
	)
);