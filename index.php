<?php
/**
 * SHCMS
 *
 * @copyright 2013-2017 Selivanovskikh M.G.
 * @license   GNU General Public License v2.0
 */
define('ROOT', getcwd());
define('DEBUG', True);
define('CORE', ROOT.DIRECTORY_SEPARATOR.'core');
define('SOURCES', ROOT.DIRECTORY_SEPARATOR.'core'.DIRECTORY_SEPARATOR.'includes');
define('MAIN', CORE.DIRECTORY_SEPARATOR.'includes'.DIRECTORY_SEPARATOR.'Main.php');
include SOURCES.DIRECTORY_SEPARATOR.'System'.DIRECTORY_SEPARATOR.'Bootstrap.php';
bootstrap(MAIN);