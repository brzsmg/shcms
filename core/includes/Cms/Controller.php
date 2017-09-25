<?php
/**
 * SHCMS
 *
 * @copyright 2013-2017 Selivanovskikh M.G.
 * @license   GNU General Public License v2.0
 */
 
namespace Cms;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}

/**
 * Контроллер. Для обработки запроса клиента, создается объект класса, и
 * в метод ExecuteRequest передается сессия.
 */
class Controller extends \System\Dispatch
{
	protected $System = NULL;
	
	protected function construct($inSystem = NULL)
	{
		call_user_func_array('parent::construct',func_get_args());
		$this->System = $inSystem;
	}
	
    protected function destruct()
    {
        call_user_func_array('parent::destruct', array());
    }

	public function executeRequest($inRequest)
	{
		throw new \System\ECore('Абстрактный метод');
	}

}