<?php /*************************************************************************
*  M.PHP5:                                     © 2013-2014 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
*    path: \index.php                                                          *                                          
*******************************************************************************/
define('ROOT', getcwd());
define('SOURCES', getcwd());
define('DEBUG', True);
define('MAIN', getcwd().DIRECTORY_SEPARATOR.'engine.php');
include SOURCES.DIRECTORY_SEPARATOR.'system'.DIRECTORY_SEPARATOR.'bootstrap.php';
bootstrap(MAIN);
