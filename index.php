<?php /*************************************************************************
*    type: SRC.PHP5                            © 2013-2014 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
* created: 2013.02.01                                                          *
*    path: index.php                                                           *
*******************************************************************************/
define('ROOT', getcwd());
define('DEBUG', True);
define('CORE', ROOT.DIRECTORY_SEPARATOR.'core');
define('SOURCES', ROOT.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'includes');
define('MAIN', CORE.DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'Main.php');
include SOURCES.DIRECTORY_SEPARATOR.'System'.DIRECTORY_SEPARATOR.'Bootstrap.php';
bootstrap(MAIN);