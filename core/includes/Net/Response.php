<?php /*************************************************************************
*    type: SRC.PHP5                            © 2010-2014 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
* created: 2010.02.01                                                          *
*    path: \Net\Response                                                       * 
*******************************************************************************/
namespace Net;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

/**
 * Результат запроса, для клиента
 */
class Response extends \System\Object{
//# Свойства #//
	protected /*Array*/  $Headers    = array();
	protected /*String*/ $Body       = '';  //String
//# Конструкторы #//
	protected function construct($inParam = 0)
	{
		call_user_func_array('parent::construct',func_get_args());
	}
	
    protected function destruct()
    {
		call_user_func_array('parent::destruct', array());
	}
	
//# Методы #//
	public /*Void*/ function addHeader(/*String*/ $inName, /*String*/ $inData)
	{
		//Нет поддержки повтора заголовков
		//Например заносить Content-type{0} - потом удалять скобки {}
		//Например заносить Content-type{1} - потом удалять скобки {}
		$this->Headers[$inName] = $inData;
	}
	
	public /*Void*/ function addBody(/*String*/ $inData)
	{
		$this->Body .= $inData;
	}
	
	public /*Void*/ function clearHeader(/*Void*/)
	{
		$this->Headers = array();
	}
	
	public /*Void*/ function clearBody(/*Void*/)
	{
		$this->Body = '';
	}
	
	public /*Void*/ function setContentType(/*String*/ $inData)
	{
		$this->Headers['Content-type'] = $inData;
	}
	
	public /*Void*/ function setBody(/*String*/ $inData)
	{
		$this->Body = $inData;
	}
	
	public /*Array*/ function getHeaders(/*Void*/)
	{
		return $this->Headers;
	}
	
	public /*String*/ function getBody(/*Void*/)
	{
		return $this->Body;
	}
}
/***************************************************************************/ ?>