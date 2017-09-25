<?php
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}

$tables[] = array(
	'name'   => 'articles',
	'struct' => array(
		'id'           => 'integer',
		'parent_id'    => 'integer',
		'name'         => 'varchar',
		'description'  => 'text',
		'article'      => 'text'
	),
	'unique' => array('id'),
	'rows' => array(
		array(
			'id'          => 1,
			'parent_id'   => 0,
			'unique_name' => '',
			'name'        => 'Документация',
			'description' => 'Статьи документации',
			'article'        => ''
		),
		array(
			'id'          => 2,
			'parent_id'   => 0,
			'unique_name' => '',
			'name'        => 'Разделы',
			'description' => 'Статьи для разделов',
			'article'        => ''
		),
		array(
			'id'          => 3,
			'parent_id'   => 0,
			'unique_name' => '',
			'name'        => 'Статьи',
			'description' => 'Статьи сайта',
			'article'        => ''
		),
		array(
			'id'          => 10,
			'parent_id'   => 0,
			'unique_name' => '',
			'name'        => 'Главная',
			'description' => 'Статья для главной страницы',
			'article'     => '<H4>Работает</H4>Если вы видете это '.
				'сообщение значит система управления сайтом успешно '.
				'установлена. Пора создавать разделы и статьи для них.'
		)
	)
);