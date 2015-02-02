<?php
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}

$tables[] = array(
	'name'   => 'geoip',
	'struct' => array(
		'start_block'   => 'bigint',
		'end_block'     => 'bigint',
		'block'         => 'varchar',
		'country'       => 'varchar',
		'city_id'       => 'integer'
	)
);