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
 * Статистика
 */
class Statistic extends \System\Dispatch
{
	protected $System = FALSE;
	protected $Data = array();
	
	protected function construct($inRequest = NULL)
	{
		call_user_func_array('parent::construct',func_get_args());
		$this->System = $inRequest->getSystem();
		$query = 'SELECT COUNT(id) FROM {users}';
		$result = $this->System->getBase()->execute($query);
		$this->Data['registrations'] = array(
			'name' => 'registrations',
			'count' => $result->fetchValue(),
			'description' => 'Registrations count.'
		);
		$query = 'SELECT COUNT(*) FROM {queries}';
		$result = $this->System->getBase()->execute($query);
		$this->Data['queries'] = array(
			'name' => 'queries',
			'count' => $result->fetchValue(),
			'description' => 'Queries count.'
		);
	}
	
    protected function destruct()
    {
		call_user_func_array('parent::destruct', array());
	}
    
	/**
	 * Возвращает ответ в виде массива данных
	 */
	public function /*void*/ __get($key)
	{
		if(array_key_exists($key,$this->Data)) {
			
			return $this->Data[$key];
		} else {
			\System\Console::warning('Field "'.$key.'" not found.');
			return NULL;
		}
	}
	
}