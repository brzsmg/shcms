<?php /*************************************************************************
*    type: SRC.PHP5                                 © 2014 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
* created: 2014.10.01                                                          *
*    path: \Data\Query                                                         * 
*******************************************************************************/
namespace Data;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

/**
 * Запрос к БД. Эксперементальный класс
 */
class Query
{
    public $driver;
    public function create($driver,$handle);
    public function rows();
    public function count();
}
