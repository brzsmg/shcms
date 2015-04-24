<?php /*************************************************************************
*    type: SRC.PHP5                            © 2013-2015 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
* created: 2013.02.01                                                          *
*    path: \Cms\Controllers\Ajax                                               * 
*******************************************************************************/
namespace Cms\Controllers;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

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