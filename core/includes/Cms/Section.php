<?php /*************************************************************************
*    type: SRC.PHP5                                 © 2013 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
* created: 2013.02.01                                                          *
*    path: \Cms\Page                                                           * 
*******************************************************************************/
namespace Cms;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

/**
 * Формируемая для пользователя страница.
 */
class Section extends \Cms\Item
{
	protected $_name = FALSE;
	protected $_title = FALSE;
	protected $_description = FALSE;
	protected $_view = FALSE;
	protected $_data = FALSE;


	protected /*virtual*/ function /*void*/ select_self()
	{
		if(
			($this->system === NULL)
			or
			(($this->_id === FALSE) and ($this->_name === FALSE))
		) {
			throw new \System\ECore('Нет данных для инициализации объекта.');
		}
		$db = $this->system->GetBase();
		
		if($this->_id !== FALSE) {
			$query = 'SELECT id, parent_id, name, title, description, view, data FROM {sections} WHERE id = :id';
			$result = $db->query($query, array('id'=>$this->_id));
		} else {
			$query = 'SELECT id, parent_id, name, title, description, view, data FROM {sections} WHERE name = :name';
			$result = $db->query($query, array('name'=>$this->_name));
		}
		
		if($result->numRows()>0) {
			return $result->fetchArray(TRUE);
		} else {
			return NULL;
		}
	}
	
	protected /*virtual*/ function /*void*/ select_items()
	{
		if(($this->system === NULL) or ($this->_id == NULL)) {
			throw new \System\ECore('Нет данных для инициализации объекта.');
		}
		$db = $this->system->GetBase();
		
		$query = 'SELECT id, parent_id, name, title, description, view, data FROM {sections} WHERE parent_id = :id';
		$result = $db->query($query, array('id'=>$this->_id));

		$items = array();
		while(($row = $result->fetchArray(TRUE))!==FALSE) {
			$items[] = $row;
		}
		return $items;
	}
	protected /*virtual*/ function /*void*/ select_parent()
	{
		if(($this->system === NULL) or ($this->_id == NULL)) {
			throw new \System\ECore('Нет данных для инициализации объекта.');
		}
		$db = $this->system->GetBase();
		
		$query = 'SELECT id, parent_id, name, title, description, view, data FROM {sections} WHERE id = :parent_id';
		$result = $db->query($query, array('parent_id'=>$this->_parent_id));
		if($result->numRows()>0) {
			return $result->fetchArray(TRUE);
		} else {
			return NULL;
		}
	}
	
	protected function /*object*/ get_object()
	{
		$class = get_class($this);
		return new $class($this->system);
	}
	
	protected function construct($system = NULL, $inID = NULL, $inName = NULL)
	{
		call_user_func_array('parent::construct',func_get_args());
		$this->table = 'sections';
		if($inName !== NULL) {
			$this->_name = $inName;
			$this->refresh();
		}
		if($inID !== NULL) {
			$this->_id = $inID;
			$this->refresh();
		}


		/*$this->Id = $inID;
		if(($inID == NULL)and($inName == NULL))
		{
			throw new \System\ECore('Нет данных для инициализации объекта.');
		}
		$db = $system->GetBase();
		$result = NULL;
		if($inID !==NULL)
		{
			$query = 'SELECT id, parent_id, unique_name, name, description, view, data FROM {sections} WHERE id = :id';
			//$query = 'SELECT id, parent_id, unique_name, name, description, view, data FROM {sections} WHERE id = :id';
			$result = $db->query($query, array('id'=>$inID));
		}
		else
		{
			$query = 'SELECT id, parent_id, unique_name, name, description, view, data FROM {sections} WHERE unique_name = :name';
			$result = $db->query($query, array('name'=>$inName));
		}
		if($result->numRows()>0)
		{
			$data = $result->fetchArray();
		}
		else
		{
			throw new \System\ECore('Раздел не найден в базе.');
		}
		$this->id = $data[0];
		$this->paren_id = $data[1];
		$this->unique_name = $data[2];
		$this->name = $data[3];
		$this->description = $data[4];
		$this->view = $data[5];
		$this->data = $data[6];*/
	}
	
    protected function destruct()
    {
		call_user_func_array('parent::destruct', array());
	}
	
	/*
	public function GetParent()
	{
		return NULL;
	}
	public function GetChilds()
	{
		return array();
	}
	
	public function GetView()
	{
		return $this->view;
	}
	
	public function GetData()
	{
		return $this->data;
	}*/

}