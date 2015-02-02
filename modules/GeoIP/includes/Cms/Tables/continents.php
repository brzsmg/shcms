<?php
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}

$tables[] = array(
	'name'   => 'continents',
	'struct' => array(
		'id'            => 'integer',
		'parent_id'     => 'integer',
		'continent'     => 'varchar',
	),
	'rows' => array(
		array(
			'id'            => '002',
			'parent_id'     => '0',
			'continent'     => 'Africa'
		),
		array(
			'id'            => '150',
			'parent_id'     => '0',
			'continent'     => 'Europe'
		),
		array(
			'id'            => '019',
			'parent_id'     => '0',
			'continent'     => 'Americas'
		),
		array(
			'id'            => '142',
			'parent_id'     => '0',
			'continent'     => 'Asia'
		),
		array(
			'id'            => '009',
			'parent_id'     => '0',
			'continent'     => 'Oceania'
		),
		
/**********
 * Africa
 **********/
		array(
			'id'         => '015',
			'parent_id'  => '002',
			'continent'  => 'Northern Africa'
		),
		array(

			'id'         => '011',
			'parent_id'  => '002',
			'continent'  => 'Western Africa'
		),
		array(
			'id'         => '017',
			'parent_id'  => '002',
			'continent'  => 'Middle Africa'
		),
		array(
			'id'         => '014',
			'parent_id'  => '002',
			'continent'  => 'Eastern Africa'
		),
		array(
			'id'         => '018',
			'parent_id'  => '002',
			'continent'  => 'Southern Africa'
		),
		
/**********
 * Europe
 **********/
		array(
			'id'         => '154',
			'parent_id'  => '150',
			'continent'  => 'Northern Europe'
		),
		array(
			'id'         => '155',
			'parent_id'  => '150',
			'continent'  => 'Western Europe'
		),
		array(
			'id'         => '151',
			'parent_id'  => '150',
			'continent'  => 'Eastern Europe'
		),
		array(
			'id'         => '039',
			'parent_id'  => '150',
			'continent'  => 'Southern Europe'
		),
/**********
 * Americas
 **********/
		array(
			'id'         => '021',
			'parent_id'  => '019',
			'continent'  => 'Northern America'
		),
		array(
			'id'         => '029',
			'parent_id'  => '019',
			'continent'  => 'Caribbean'
		),
		array(
			'id'         => '013',
			'parent_id'  => '019',
			'continent'  => 'Central America'
		),
		array(
			'id'         => '005',
			'parent_id'  => '019',
			'continent'  => 'South America'
		),
/**********
 * Asia
 **********/
		array(
			'id'         => '143',
			'parent_id'  => '142',
			'continent'  => 'Central Asia'
		),
		array(
			'id'         => '030',
			'parent_id'  => '142',
			'continent'  => 'Eastern Asia'
		),
		array(
			'id'         => '034',
			'parent_id'  => '142',
			'continent'  => 'Southern Asia'
		),
		array(
			'id'         => '035',
			'parent_id'  => '142',
			'continent'  => 'South-Eastern Asia'
		),
		array(
			'id'         => '145',
			'parent_id'  => '142',
			'continent'  => 'Western Asia'
		),
		
/**********
 * Oceania
 **********/
		array(
			'id'         => '053',
			'parent_id'  => '009',
			'continent'  => 'Australia and New Zealand'
		),
		array(
			'id'         => '054',
			'parent_id'  => '009',
			'continent'  => 'Melanesia'
		),
		array(
			'id'         => '057',
			'parent_id'  => '009',
			'continent'  => 'Micronesia'
		),
		array(
			'id'         => '061',
			'parent_id'  => '009',
			'continent'  => 'Polynesia'
		),
	)
	
);