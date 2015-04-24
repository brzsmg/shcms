<?php /*************************************************************************
*    type: SRC.PHP5                            © 2010-2014 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
* created: 2010.10.01                                                          *
*    path: \Net\Request                                                        *
*******************************************************************************/
namespace Net;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

/**
 * Запрос клиента
 */
class WebRequest extends \System\Object
{
//# Параметры #//
	protected /*Server*/        $Server;
	protected /*Server*/        $Client;
	
	protected /*Bool*/          $IsSendHeader; // Отправлены ли заголовки
	protected /*Bool*/          $IsSendData;   // Отправлены ли данные
    protected /*Int*/           $Status = 0;   // 200 or 404

//# Свойства объекта #//
	protected /*String*/  $AuthUser;    // HTTP User
	protected /*String*/  $AuthPass;    // HTTP Password
	protected /*String*/  $Referer;     // Страница, с которой посетитель пришёл
	protected /*String*/  $Query;       // Запрос
	protected /*string*/  $RawPOST;     // POST данные 
	protected /*string*/  $RawGET;      // GET данные  
	protected /*Array*/   $GET;         // GET данные как переменные 
	protected /*Array*/   $POST;        // POST данные как переменные
	protected /*Array*/   $COOKIE;      // COOKIE данные как массив
	protected /*array[string]*/ $SectPaths;  // Разделы каталогов   

//# Конструкторы #//
	protected /*construct*/ function construct($inServer = NULL, $inParam = NULL, $inClient = NULL)
	{
		call_user_func_array('parent::construct',func_get_args());
		$this->Server      = $inServer;
		$this->Client      = $inClient;
		$this->AuthUser    = $inParam['AuthUser'];
		$this->AuthPass    = $inParam['AuthPass'];
		$this->Referer     = $inParam['Referer'];
		$this->Query       = $inParam['Query'];
		$this->RawGET      = $inParam['DataGET'];
		$this->RawPOST     = $inParam['DataPOST'];
		$this->GET         = $inParam['ParamGET'];
		$this->POST        = $inParam['ParamPOST'];    
		$this->COOKIE      = $inParam['COOKIE'];
		$this->SectPaths   = $inParam['SectPaths'];
		$this->Session     = NULL;
	}
	
    protected function destruct()
    {
		call_user_func_array('parent::destruct', array());
	}

	public function /*string*/ getServer()
	{
		return $this->Server;
	}
	
	public function /*string*/ getClient()
	{
		return $this->Client;
	}
	
	public function /*string*/ getSession()
	{
		return $this->Session;
	}
	
	public function /*string*/ getAuthUser()
	{
		return $this->AuthUser;
	}
	
	public function /*string*/ getAuthPass()
	{
		return $this->AuthPass;
	}
	
	public function /*string*/ getReferer()
	{
		return $this->Referer;
	}
	
	public function /*string*/ getQuery()
	{
		return $this->Query;
	}
	
	//Может вернуть любой параметр
	public function /*mix*/ getParam($name,$type='ANY')
	{
		$result = NULL;
		if(($type=='ANY')or($type=='GET')) {
			if(array_key_exists($name,$this->GET)) {
				$result=$this->GET[$name];
			}
		}
		if(($type=='ANY')or($type=='POST')) {
			if(array_key_exists($name,$this->POST)) {
				$result=$this->POST[$name];
			}
		}
		if(($type=='ANY')or($type=='COOKIE')) {
			if(array_key_exists($name,$this->COOKIE)) {
				$result=$this->COOKIE[$name];
			}
		}
		return $result;
	}
	
	public function /*mix*/ getGET($in_key = FALSE)
	{
		if($in_key === FALSE) {
			return $this->RawGET;
		}else{
			if(array_key_exists($in_key,$this->GET)) {
				return $this->GET[$in_key];
			} else {
				return NULL;
			}
		}
	}
	
	public function /*mix*/ getPOST($in_key = FALSE)
	{
		if($in_key === FALSE) {
			return $this->RawPOST;
		} else {
			if(array_key_exists($in_key,$this->POST)) {
				return $this->POST[$in_key];
			} else {
				return NULL;
			}
		}
	}
  
	public function /*mix*/ setCOOKIE($inKey, $inValue, $inTime, $inPath='/')
	{
		if($this->Client->getConnected()) {
			setcookie($inKey, $inValue, $inTime, $inPath); //setcookie; только тут
		}
	}

	public function /*array[string]*/ getSectPathCount()
	{
		return count($this->SectPaths)-1;
	}
	
	public function /*array[string]*/ getSectPath($num=1)
	{
		if($this->getSectPathCount()>=$num) {
			return $this->SectPaths[$num];
		} else {
			return NULL;
		}
	}
	
	public function /*Bool*/ setStatus(/*int*/ $inStatus)
	{
		$this->Status = $inStatus;
		return true;
	}
	
	public function /*bool*/ sendData(/*TResponse*/$inData)
	{
		global $_;
		if(($this->Client->getConnected()) and ($this->IsSendHeader)) {    
			$this->IsSendData = TRUE;
			if(!$_['echo']) {
				ob_clean();
			}
			echo $inData;              // echo; используется только тут
			if(!$_['echo']) {
				ob_flush();
			}
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	public function /*bool*/ sendHeader(/*string*/$inKey, /*string*/ $inValue)
	{
		if(($this->Client->getConnected()) and (!$this->IsSendData)) {
			$this->IsSendHeader = TRUE;
			header($inKey.': '.$inValue, FALSE);   // header; только тут
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	function /*array*/ sendResponse(/*TResponse*/$inResponse)
	{
		//Отсылаем заголовки
		foreach($inResponse->getHeaders() as $key=>$value) {
			$this->sendHeader($key, $value);
		}
		$this->IsSendHeader = TRUE;
		//Отсылаем тело сообщения
		$this->sendData($inResponse->getBody());
		//В HTTP сразу отключаемся после ответа
		$this->Client->disconnect();
	}
}