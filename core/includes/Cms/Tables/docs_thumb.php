<?php
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}

$tables[] = array(
	'name'   => 'docs_thumb',
	'struct' => array(
		'doc_id'       => 'integer',
		'width'        => 'integer',
		'height'       => 'integer',
		'mode'         => 'varchar',
		'format'       => 'varchar',
		'quality'      => 'integer',
		'name'         => 'varchar'
	),
	'unique'      => array('doc_id', 'width', 'height', 'mode', 'format', 'quality'),
	'description' => 'Кеш для превью'
);