<?php
/**
 * SHCMS
 *
 * @copyright 2013-2017 Selivanovskikh M.G.
 * @license   GNU General Public License v2.0
 */

/*global namespase;*/
if(!defined('SOURCES')){Header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/
$_['echo']=true;
echo 'Ядро загрузилось без ошибок.<br/>';
$o = new \System\Object('text',1);
