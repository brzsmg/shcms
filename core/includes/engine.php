<?php /*************************************************************************
*    type: SRC.PHP5                            © 2013-2014 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
* created: 2013.02.01                                                          *
*    path: \engine.php                                                         *                                          
*******************************************************************************/
/*global namespase;*/
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/
$_['echo']=true;
echo 'Ядро загрузилось без ошибок.<br/>';
$o = new \System\Object('text',1);
