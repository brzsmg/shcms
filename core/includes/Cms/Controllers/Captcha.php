<?php
/**
 * SHCMS
 *
 * @copyright 2013-2017 Selivanovskikh M.G.
 * @license   GNU General Public License v2.0
 */

namespace Cms\Controllers;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}

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