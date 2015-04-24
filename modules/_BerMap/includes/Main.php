<?php /*************************************************************************
*  S.PHP5:                                          © 2015 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
* created: 2015.04.01                                                          *
*    path: \Modules\BerMap\Main.php                                            *
*                                                                              *
*******************************************************************************/
namespace Modules\BerMap;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

//$system->addController('ads', 'Ads');
$base = $system->getBase();

//Меняем тему оформления
$query = 'SELECT value FROM {configuration} WHERE "module" = :module and "key" = :key';
$result = $base->execute($query,array(
	'module' => 'core',
	'key'    => 'theme'
));
if($result->fetchValue() != 'BerMap') {
	$query = 'UPDATE {configuration} SET "value" = :value WHERE "module" = :module and "key" = :key';
	$base->execute($query,array(
		'module' => 'core',
		'key'    => 'theme',
		'value'    => 'BerMap'
	));
}