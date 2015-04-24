<?php /*************************************************************************
*    type: SRC.PHP5                            © 2013-2014 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
* created: 2013.02.01                                                          *
*    path: \System\Dispatch                                                    *  
*                                                                              *
* Настоящий конструктор. Делегирует динамический метод Create().               *
* Настоящий деструктор. Делегирует динамический метод Destroy().               *  
* События. Позволяют обмениваться событиями между объектами.                   *                                      
*******************************************************************************/
namespace System;
if(!defined('SOURCES')){header("Location: http://".$_SERVER['HTTP_HOST']);exit;}
/******************************************************************************/
class Dispatch extends \System\Object
{
    //# События #//
    protected        /*array*/  $FEvents = array(); //Все события объекта
  
	//Вызывает родительский конструктор и создает события
    protected function /*void*/ construct(){
        call_user_func_array('parent::construct',func_get_args());
        $vars = get_class_vars(get_called_class());
        foreach($vars as $var=>$value)
        {
            if(strpos($var,'Evt')!==false)
            {
                $this->AddEvent($var);
            }
        }
    }
    protected function /*void*/ destruct(){
        call_user_func_array('parent::destruct',array());
    }
    
	//Добавляет слушателя в список у события
	function /*bool*/ Listen($Event,$Method){
		if(array_key_exists($Event,$this->FEvents)){
			$this->FEvents[$Event][] = $Method;
			return true;
		}else{
			throw new \System\ECore('События "'.$Event.'"не существует.');
		}
	}
  //Удаляет слушателя из списка у события
  function /*bool*/ Disregard($Event,$Method){  
    if(array_key_exists($Event,$this->FEvents)){
      for($i=0;$i<count($this->FEvents[$Event]);$i++){
        if($this->FEvents[$Event][$i] = $Method){
          unset($this->FEvents[$Event][$i]);
          return true;
        }
      }
    }else{
      return false;
    }
    return false;
  }
	//Сообщает о событии своим слушателям
	protected /*void*/ function Report($Event,$inParam = 0){
		\System\Console::info('Event: '.$Event);
		$args = func_get_args();
		unset($args[0]);
		if(array_key_exists($Event,$this->FEvents)){
			for($i=0;$i<count($this->FEvents[$Event]);$i++){
				if($inParam !== 0){
					call_user_func_array($this->FEvents[$Event][$i],$args); // Сообщаем
				}else{
					call_user_func($this->FEvents[$Event][$i]);          // Сообщаем
				}
			}
			return true;
		}else{
			throw new \System\ECore('События "'.$Event.'"не существует.');
		}
	}
  //Добавляет событие, в которое могут записаться слушатели
  protected /*bool*/ function AddEvent(/*string*/ $Event){
    if(!array_key_exists($Event,$this->FEvents)){
      $this->FEvents[$Event] = array();
      return true;
    }else{
      return false;
    }
  }
  //Удаляет событие, вместе со списком слушателей
  protected /*bool*/ function DeleteEvent(/*string*/ $Event){
    if(array_key_exists($Event,$this->FEvents)){
      unset($this->FEvents[$Event]);
    }else{
      return false;
    }
    return true;
  }

}

?>