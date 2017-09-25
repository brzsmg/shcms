<?php
/**
 * SHCMS
 *
 * @copyright 2013-2017 Selivanovskikh M.G.
 * @license   GNU General Public License v2.0
 */
 
namespace Cms;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

/**
 * Запрос пользователя CMS.
 */
class Request extends \System\Object
{
//# Параметры #//
	protected /*Server*/        $WebServer;
	protected /*Server*/        $WebClient;
	protected /*Server*/        $WebRequest;
	protected /*System*/        $System;
	protected /*Server*/        $Session;
	protected /*User*/          $User;
	
	//protected /*mix*/           $Data;
	
	
//# Конструкторы #//
	public /*construct*/ function construct($inSystem = NULL, $inRequest = NULL)
	{
		call_user_func_array('parent::construct',func_get_args());
		$this->System = $inSystem;
		$this->WebRequest = $inRequest;
		$this->WebServer = $this->WebRequest->getServer();
		$this->WebClient = $this->WebRequest->getClient();
		$this->Session   = new \Net\Session($this->System, $this->WebRequest);
		//var_dump($this->Session->getSID());exit;
		$this->User      = new \Cms\User($inSystem,$this->Session->getUID());
	}
	
    protected function destruct()
    {
		call_user_func_array('parent::destruct', array());
	}
	
	public function /*string*/ getWebServer()
	{
		return $this->WebServer;
	}
	
	public function /*string*/ getWebClient()
	{
		return $this->WebClient;
	}
	
	public function /*string*/ getWebRequest()
	{
		return $this->WebRequest;
	}
	
	public function /*string*/ getSystem()
	{
		return $this->System;
	}
	
	public function /*string*/ getSession()
	{
		return $this->Session;
	}
	
	public function /*string*/ getUser()
	{
		return $this->User;
	}
	
	public function setUID($inUID)
	{
		$this->Session->setUID($inUID);
		$this->User = new \Cms\User($this->System, $this->Session->getUID());
	}
	
	public function /*string*/ getQuery()
	{
		return $this->WebRequest->getQuery();
	}
	
	public function /*string*/ isAjax()
	{
		if($this->WebRequest->getParam('ajax') !== NULL) {
			return true;
		} else {
			return false;
		}
	}
	
	public function /*string*/ isBlock()
	{
		if($this->WebRequest->getParam('block') !== NULL) {
			return true;
		} else {
			return false;
		}
	}
	
	//function /*array*/ sendResponse($inPage)
	/*{
		$response = \Net\Response();
		$response->addHeader('Content: x-html');
		$response->addBody($this->Page->GetHead());
		$response->addBody($this->Page->GetBody());
		$this->WebRequest->sendResponse($response);
	}*/
	
	function /*array*/ sendResponse(\Net\Response $inResponse)
	{
		$this->WebRequest->sendResponse($inResponse);
	}
}