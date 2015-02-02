<?php /*************************************************************************
*    type: SRC.PHP5                                 © 2013 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
* created: 2013.02.01                                                          *
*    path: \Security\Context                                                   * 
*                                                                              *
*   К сожалению пользовательский контекст легко отключается следующим кодом:   *
* $reflectedClass = new \ReflectionClass('\Security\Context');                 *
* $reflectedProperty = $reflectedClass->getProperty('CurrentId');              *
* $reflectedProperty->setAccessible(true);                                     *
* $reflectedProperty->setValue('1000');                                        *
*******************************************************************************/
namespace Security;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

/**
 * Контекст безопасности
 */
class Context
{
	private static $SystemId = 1000;
	private static $CurrentId = 1000;
	private static $Key = FALSE;
	
	/**
	 * Вернет истину если контекст системный
	 */
	public static function isSystem()
	{	
		if(Context::$CurrentId == Context::$SystemId) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	/**
	 * Вернет Id пользователя для текущего контекста
	 */
	public static function getCurrentId()
	{	
		return Context::$CurrentId;   // Security.Principal.Context
	}
	
	/**
	 * Активирует контекст пользователя
	 */
	public static function enableUserContext($uid)
	{
		if(Context::$CurrentId == Context::$SystemId) {
			Context::$CurrentId = $uid;
			Context::$Key = rand(111111,999999);
			return Context::$Key;
		} else {
			throw new \System\ECore('Нет доступа');
		}
	}
	
	/**
	 * Активирует котекст системы
	 */
	public static function enableSystemContext($inKey)
	{
		if($inKey == Context::$Key) {
			Context::$CurrentId = Context::$SystemId;
		} else {
			throw new \System\ECore('Нет доступа');
		}
	}
	
}