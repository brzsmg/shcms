<?php
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}

$tables[] = array(
	'name'   => 'geoip_cities',
	'struct' => array(
		'city_id'       => 'integer',
		'city'          => 'varchar',
		'region'        => 'varchar',
		'district'      => 'varchar',
		'lat'           => 'float',
		'lng'           => 'float'
	)
);