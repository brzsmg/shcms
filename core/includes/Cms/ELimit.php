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