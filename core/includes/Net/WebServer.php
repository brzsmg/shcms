<?php /*************************************************************************
*    type: SRC.PHP5                            © 2010-2013 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
* created: 2010.10.01                                                          *
*    path: \Net\WebServer                                                      * 
*******************************************************************************/
namespace Net;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

/**
 * Web сервер.
 */
class WebServer extends \System\Dispatch{
//# События #//
	public $EvtClient;
  

//# Свойства #//
	protected /*Array[Client]*/  $Clients;    // На вебсервере всегда один
	protected /*Int*/            $Count  = 0; // Количество клиентов
	protected /*Int*/            $NextID = 0; // Следущий идетнификатор

//# Конструкторы #//
	protected function construct()
	{
		call_user_func_array('parent::construct',func_get_args());
		$this->AddEvent('EvtClient');
		$this->AddEvent('EvtRequest');
	}
	
    protected function destruct()
    {
		call_user_func_array('parent::destruct',array());
	}
	
//# Методы #// 
	function start()
	{
		$this->Clients = array();
		/*FOR*/if(True) { //Цикл ожидания подключений
			//На вебсервере всегда одно                                         //TODO: не всегда есть одно, это может быть CRON
			//Все первичные свойства клиента получаем в этом месте
			/*mix*/ $param = array(
			'IP'         => getenv('REMOTE_ADDR'),     // IP клиента
			'Agent'      => getenv('HTTP_USER_AGENT'),                              
			'Browser'    => null
		);
		if($param['IP']===False) {
			throw new \System\ECore('IP address client is not known');
		}
		if($param['Agent']===False) {
			$param['Agent']='HTTPClient/default';  // Клиент по умолчанию
		}
		$param['Browser'] = new \Cms\Browser($param['Agent']);
		$this->NextID++;
		$Client = new \Net\WebClient($this,$param);
		$this->Clients[$this->NextID] = $Client;
		$this->Count++;
		$this->Report('EvtClient', $Client);
		unset($param);
		//Все первичные свойства запроса получаем в этом месте
		/*mix*/ $param = array(
			'AuthUser'   => array_key_exists('PHP_AUTH_USER',$_SERVER)?$_SERVER['PHP_AUTH_USER']:'',
			'AuthPass'   => array_key_exists('PHP_AUTH_PW',$_SERVER)?$_SERVER['PHP_AUTH_PW']:'',
			'Referer'    => array_key_exists('HTTP_REFERER',$_SERVER)?$_SERVER['HTTP_REFERER']:'',
			'Query'      => getenv('REDIRECT_URL'),
			'ParamGET'   => $_GET,
			'ParamPOST'  => $_POST,
			'DataGET'    => '',                                                       
			'DataPOST'   => file_get_contents("php://input"),                       //ToDO: ?
			'COOKIE'     => $_COOKIE,
			'url'        => '',
			'SectPaths'  => ''                                               
		);
		/*array[string]*/ $url = explode('?',getenv('REQUEST_URI'));
		if(sizeof($url)>0) {
			$param['url']       = $url[0];
			$param['SectPaths'] = explode('/',$param['url']);
		}
		if(sizeof($url)>1)
		{
			$param['DataGET']   = $url[1];
		}
		unset($url);
		$request = new \Net\WebRequest($this, $param, $Client);
		//Оно произошло
		$this->Report('EvtRequest',$request);
		}/*ENDFOR*/
		return True;  //Подключений больше не будет                                 
	}

	function /*Int*/ getClientCount(){
		return $this->Count;
	}
	
	function getName()
	{
		if(array_key_exists('SERVER_SOFTWARE', $_SERVER)) {
			return $_SERVER['SERVER_SOFTWARE'];
		}  else {
			return '';
		}
		
	}
	
}