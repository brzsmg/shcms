<?php /*************************************************************************
*  M.PHP5:                                     © 2013-2014 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
*    path: \main.php                                                           *
*                                                                              *
*   Web-приложение CMS сервер.                                                 *
*******************************************************************************/
/*global namespase;*/
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/
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