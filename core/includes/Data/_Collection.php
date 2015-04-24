<?php /*************************************************************************
*    type: SRC.PHP5                                 © 2014 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
* created: 2014.10.01                                                          *
*    path: \Data\Collection                                                    * 
*******************************************************************************/
namespace Data;
if(!defined('SOURCES')){Header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

/**
 * Коллекция. Эксперементальный класс
 */
abstract class Collection extends \System\Object{
  //# Свойства #//
  protected /*String*/ $_items = false;
  function select_items($id){
    //Этот метод не должен вызываться
    //Он должен переопределяться
  }
  function /*mix*/ GetItem($index){
    if($_items===false){
      $this->select_items();
    }
    if(count($_items)<=($index+1)){
      return $_items[(int)$index];
    }
  }
  function /*mix*/ Count(){
    if($_items===false){
      $this->select_items();
    }
    return count($_items);
  }
  
}
