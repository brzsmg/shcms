<?php
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}

$tables[] = array(
	'name'   => 'messages',
	'struct' => array(
		'id'           => 'integer',
		'from'         => 'integer',
		'to'           => 'integer',
		'date_send'    => 'integer',
		'date_read'    => 'integer',
		'date_removed' => 'integer',
		'title'        => 'varchar',
		'message'      => 'text',
		'app_name'     => 'varchar',
		'app_data'     => 'blob'
	),
	'unique' => 'id',
	'rows' => array(
		array(
			'id'           => 1,
			'from'         => 1000,
			'to'           => 3000,
			'date_send'    => 1418128298,
			'date_read'    => 0,
			'date_removed' => 0,
			'title'        => 'Спасибо',
			'message'      => 'Спасибо за использование SHCMS.',
			'app_name'     => NULL,
			'app_data'     => NULL
		),
		array(
			'id'           => 2,
			'from'         => 1000,
			'to'           => 3000,
			'date_send'    => 1418128299,
			'date_read'    => 0,
			'date_removed' => 0,
			'title'        => 'Отчет об установке',
			'message'      => 'Установка системы завершена успешно.',
			'app_name'     => NULL,
			'app_data'     => NULL
		)
	)
);