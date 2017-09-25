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
 * Контроллер для ajax запросов.
 */
class Ajax extends \Cms\Controller
{
//# Конструкторы #//
	protected function construct($system = NULL)
	{
		call_user_func_array('parent::construct',func_get_args());
	}
	
    protected function destruct()
    {
        call_user_func_array('parent::destruct',array());
    }
	
//# Методы #//
	public function executeRequest($inRequest)
	{
		$response = new \Net\Response();
		$response->addBody('<b>Деятельность не реализована.</b>');
		$inRequest->sendResponse($response);
	}
		
}