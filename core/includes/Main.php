<?php
/**
 * SHCMS
 *
 * @copyright 2013-2017 Selivanovskikh M.G.
 * @license   GNU General Public License v2.0
 */

/*global namespase;*/
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/**
 * Web-приложение CMS сервер.
 */
class MainApp extends \System\Object
{
    protected $Server;
    protected $Cms;
    protected function construct()
    {
        call_user_func_array('parent::construct',func_get_args());
        $this->Server = new \Net\WebServer();
        $this->Cms = new \Cms\System($this->Server);
        $this->Cms->SetConnectionLimit(10);
        $this->Server->Start();
    }
	
    protected function destruct()
    {
		call_user_func_array('parent::destruct', array());
	}
	
}

$app = new MainApp();