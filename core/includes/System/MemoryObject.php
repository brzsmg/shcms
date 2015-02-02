<?php /*************************************************************************
*  M.PHP5:                                     © 2009-2014 Selivanovskikh M.G. *
* created: 2009.02.01                                                          *
* charset: UTF-8                                                               *
*    path: \System\MemoryObject                                                *
*                                                                              *
*   Реализует:                                                                 *
* [-] Внутренние конструкторы и деструкторы.                                   *
* [-] Переменное число параметоров для конструктора;                           *
* [-] Цепочку вызовов конструкторов от наследника к родителю.                  *
*******************************************************************************/
namespace System;
if(!defined('SOURCES')){Header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

class MemoryObject
{
    public function /*string*/ getRootClass()
	{
        return get_class();
    }
	
    protected function /*void*/ construct(/*void*/)
	{
    }
	
    protected function /*void*/ destruct(/*void*/)
	{
    }
	
    final function /*void*/ __construct()
	{
        call_user_func_array(array($this,'construct'),func_get_args());
    }
    final function /*void*/ __destruct ( /*void*/ )
	{
        call_user_func_array(array($this,'destruct'),array());
    }
}