<?php /************************************************************************
*                                              © 2013-2014 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
*  S.PHP5: \Data\Query                                                         * 
*                                                                              *
*   Запрос к БД. Эксперементальный класс.                                      *
*******************************************************************************/
namespace Data;
if(!defined('SOURCES')){Header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/
/**/
class Query
{
    public $driver;
    public function create($driver,$handle);
    public function rows();
    public function count();
}

?>