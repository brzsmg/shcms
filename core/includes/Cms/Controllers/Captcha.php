<?php /*************************************************************************
*  S.PHP5:                                          © 2006-2011 Kruglov Sergei *
* charset: UTF-8                                                               *
*    path: \Cms\Controllers\Captcha.php                                        *
*  source: www.captcha.ru, www.kruglov.ru                                      *
*******************************************************************************/
namespace Cms\Controllers;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

/**
 * Контроллер для капчи по адресу "http://{host}/captcha".
 */
class Captcha extends \Cms\Controller
{
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
    public function executeRequest($inRequest)
    {
		$captcha = new \Security\Captcha();
		$key = $captcha->getKeystring();
		$session = $inRequest->getSession();
		$session->captcha_key = $key;
		$captcha->Send($inRequest);
    }
	
}