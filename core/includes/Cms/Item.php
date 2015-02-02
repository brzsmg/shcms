<?php /*************************************************************************
*    type: SRC.PHP5                            © 2009-2014 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
* created: 2009.02.01                                                          *
*    path: \Data\Node                                                          * 
*******************************************************************************/
namespace Cms;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

/**
 * Узел иерархии привязаный к объекту БД.
 */
abstract class Item extends \Data\Node
{
	//# Свойства #//
	protected /*int*/ $table  = NULL;
	protected         $system = NULL;
	
	protected function construct($system = NULL, $inID = NULL, $inName = NULL)
	{
		call_user_func_array('parent::construct',func_get_args());
		if($system === NULL) {
			throw new \System\ECore('Нет данных для создания объекта.');
		}
		$this->system = $system;
	}
	
    protected function destruct()
    {
		call_user_func_array('parent::destruct', array());
	}
	
	public function getID()
	{
		return $this->_id;
	}
	
	public function getTable()
	{
		return $this->table;
	}
	
}