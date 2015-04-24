<?php /*************************************************************************
*    type: SRC.PHP5                            © 2009-2014 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
* created: 2009.02.01                                                          *
*    path: \System\Object                                                      *  
*                                                                              *
* Основная цель класса, что бы все от него наследовались.                      *                                   
*******************************************************************************/
namespace System;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/
class Object extends \System\MemoryObject
{
    public function /*string*/ getClass()
	{
        return get_called_class();
    }

    protected function /*void*/ construct()
	{
        call_user_func_array('parent::construct',func_get_args());
    }
    protected function /*void*/ destruct()
	{
        call_user_func_array('parent::destruct',array());
    }

}