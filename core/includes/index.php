<?php
/**
 * SHCMS
 *
 * @copyright 2013-2017 Selivanovskikh M.G.
 * @license   GNU General Public License v2.0
 */

define('ROOT', getcwd());
define('SOURCES', getcwd());
define('DEBUG', True);
define('MAIN', getcwd().DIRECTORY_SEPARATOR.'engine.php');
include SOURCES.DIRECTORY_SEPARATOR.'system'.DIRECTORY_SEPARATOR.'bootstrap.php';
bootstrap(MAIN);
