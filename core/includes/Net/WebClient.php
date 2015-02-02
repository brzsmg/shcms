<?php /************************************************************************
*  M.PHP5:                                     © 2010-2014 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
* created: 2010.02.01                                                          *
*    path: \Net\WebClient                                                      * 
*                                                                              *
*   Клиент HTTP.                                                               *
*******************************************************************************/
namespace Net;
if(!defined('SOURCES')){Header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/
class WebClient extends \System\Dispatch{
	protected /*Bool*/    $Server;
	protected /*Bool*/    $Connected;   // Подключен ли пользователь
	protected /*String*/  $Address;     // IP пользователя
	protected /*String*/  $TypeAddress; // Тип адресса
	protected /*String*/  $Agent;       // Клиент пользователя
	protected /*Browser*/ $Browser;     // Название клиента

//# Конструкторы #//
	protected /*construct*/ function construct($inServer = null, $inParam = null)
	{
		call_user_func_array('parent::construct',func_get_args());
		$this->Server        = $inServer;
		$this->Connected     = True;
		$this->Address       = $inParam['IP'];
		$this->Agent         = $inParam['Agent'];
		$this->Browser       = $inParam['Browser'];
		$this->TypeAddress   = $this->typeAddres($this->Address);
	}
    protected function destruct()
    {
		call_user_func_array('parent::destruct',array());
	}
  
//# Методы #//  
	private function typeAddres($ip)
	{
		$a = preg_split('/[.]/', $ip);
		$type = 'internet';
		//10.0.0.0/8
		if($a[0]=='10')
		{
			$type='lan:crm';
		}
		//172.16.0.0/12
		else if(($a[0]=='172')and($a[1]>='16')and($a[1]<='31')) {
			$type='lan:crm';
		}
		//127.0.0.0/8
		else if($a[0]=='127') {
			$type='local';
		}
		//192.168.0.0/16
		else if(($a[0]=='192')and($a[1]=='168')) {
			$type='lan';
		}
		//169.254.0.0/16
		else if(($a[0]=='169')and($a[1]=='254')) {
			$type='lan:nodhcp';
		}
		return $type;
	}

	public function /*string*/ getAddress()
	{
		return $this->Address;
	}

	public function /*string*/ getTypeAddres()
	{
		return $this->TypeAddress;
	}
	
	public function /*string*/ getAgent()
	{
		return $this->Agent;
	}

	public function /*string*/ getBrowser()
	{
		return $this->Browser;
	}
	
	public function /*string*/ getConnected()
	{
		return $this->Connected;
	}
	
	public function /*Array*/ disconnect(/*Void*/)
	{
		$this->Connected = FALSE;
		//Соединение завершено.
	}
	
}