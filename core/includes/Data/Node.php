<?php /*************************************************************************
*    type: SRC.PHP5                            © 2009-2014 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
* created: 2013.02.01                                                          *
*    path: \Data\Node                                                          * 
*                                                                              *
*   Node. Автоматизирует иерархические объекты. Поля из базы именуются с нижним*
* подчеркиванием, что бы имя поля БД не совпало с зарезервированым именем PHP. *                                                       *
*   (x)Можно автоматизировать UPDATE записи, при присвоении нового значения,   *
* но UPDATE должен быть массовый, а не каждое поле по отдельности.             *
*   (x)Можно автоматизировать INSERT дочернего объекта, при добавлении.        *
*   (x)Можно автоматизировать DELETE объекта, при удалении.                    *
*******************************************************************************/
namespace Data;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

/*
 * Узел в иерархии объектов базы данных.
 */
abstract class Node extends \System\Object{
//# Свойства #//
	protected /*Node[]*/ $items     = FALSE;
	protected /*Node*/   $parent    = FALSE;
//# Свойства базы #//
	protected /*int*/    $_id        = FALSE;
	protected /*int*/    $_parent_id = FALSE;

//# Конструкторы #//
	protected function construct($inParam = 0)
	{
		call_user_func_array('parent::construct', func_get_args());
	}
	
    protected function destruct()
    {
		call_user_func_array('parent::destruct', array());
	}
	
//# Виртуальные методы #//
	protected /*virtual*/ function /*void*/ select_self()
	{
		msg(__FILE__.'('.__LINE__.')');
		return array();
	}
	
	protected /*virtual*/ function /*void*/ select_items()
	{
		msg(__FILE__.'('.__LINE__.')');
		return array();
	}
	
	protected /*virtual*/ function /*void*/ select_parent()
	{
		msg(__FILE__.'('.__LINE__.')');
		return array();
	}

//# Методы #//
	//private function /*void*/ _check_parent(){ 
    	//if(($this->_items===false)and(method_exists($this,'select_items'))){
    	//	$this->set_items();
    	//}
	//}
	
	protected function /*void*/ set_properties($properties)
	{
		if(!is_array($properties)) {
			return;//Костыль
		}
	    foreach($properties as $key => $value) {
	    	$property_name = '_'.$key;
	    	if(property_exists(get_class($this),$property_name)) {
	        	$this->$property_name = $value;
	    	}
	    	if(property_exists(get_class($this),$key)) {
	        	$this->$key = $value;
	    	}
	    }
	}
	
    public function /*void*/ refresh()
	{
        $this->items = FALSE;
        if(method_exists($this,'select_items')) {
            $properties = $this->select_self();
			if($properties !== NULL) {
				$this->set_properties($properties);
			} else {
				throw new \System\ECore('Объект в базе не существует. "ID='.$this->_id.'; CLASS="'.\get_class().'"');
			}
        }
    }
	
	protected function /*object*/ get_object()
	{
		$class = get_class($this);
		return new $class();
	}
	
	protected /*virtual*/ function /*mix*/ Get($name)
	{
        $property_name = '_'.$name;
		///ITEMS
        if($name=='items') {
			if($this->items===FALSE) {
		    	$items = $this->select_items();
		    	foreach($items as $key => $value) {
					$item = $this->get_object();
					$item->init($value);
		        	$this->items[] = $item;
		    	}
			}
            return $this->items;
        } else
		//PARENT
        if($name=='parent') {
			if($this->parent===FALSE) {
				$data = $this->select_parent();
				if($data !== NULL) {
					$this->parent = $this->get_object();
					$this->parent->Init($this->select_parent());
				} else {
					return NULL;
				}
			}
            return $this->parent;
        } else
		///SELF
        if(property_exists(get_class($this),$property_name)) {
            return $this->$property_name;
        }
        if(property_exists(get_class($this),$name)) {
            return $this->$name;
        }
		return FALSE;
	}
	
	//Присваевает значения только свойствам без подчеркивания
	protected function /*void*/ Set($name,$value)
	{
        if($name!='items')
		{
            if(property_exists(get_class($this),$name))
			{
              $this->$name = $value;
            }
        }
	}
	
	final public function /*void*/ init($properties)
	{
        //parent::__construct();
        if(is_array($properties)){
			//$this->_id = $properties['id'];
			//$properties = $this->select_self();
            $this->set_properties($properties);
        }
		$this->refresh();
	}
    /*final public function __construct($properties){
		$this->Create($properties);
    }*/
	
    final public function /*void*/ __get($name)
	{
		return $this->Get($name);
    }
	
    final public function /*void*/ __set($name,$value)
	{
		$this->Set($name,$value);
    }
}