<?php /*************************************************************************
*    type: SRC.PHP5                                 © 2013 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
* created: 2013.02.01                                                          *
*    path: \Cms\ELimit                                                         * 
*******************************************************************************/
namespace Cms;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

/**
 * Исключение возникающее при ограничениях.
 */
class ELimit extends \Exception
{
    function __construct(/*string*/ $message = NULL)
	{
        $this->message = $message;
        $this->code = 0;
        write_msgshow('message', $message);
    }
}