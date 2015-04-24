<?php /*************************************************************************
*    type: SRC.PHP5                            © 2013-2014 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
* created: 2013.02.01                                                          *
*    path: \System\Text                                                        *
*******************************************************************************/
namespace System;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

/**
 * Консоль
 */
class Console extends \System\Object {

	public static function /*void*/ info($str)
	{
		_log($str,'info');
	}
	public static function /*void*/ warning($str)
	{
		_log($str,'warning');
	}
	public static function /*void*/ error($str)
	{
		_log($str,'error');//Сразу показывать консоль
	}
	
	public static function /*mix*/ getUsageTime()
	{
		return SizeToStr(memory_get_usage());
	}
	
	/**
	 * Вернет время начала логирования, для профилирования
	 */
	public static function /*mix*/ getStartTime()
	{
		global $_;
		return $_['start_mtime'];
	}
	
	public static function /*mix*/ getDump()
	{
		global $_;
		$cnt = count($_['msgshow']['dump']);
		$str = '';
		$clr = array(TRUE=>'#FFFFFF',FALSE=>'#EEEEEE');
		$clr_i = TRUE;
		if($cnt > 1) {
			for($i = 0; $i < $cnt; $i++){
			$str .= '<div style="border-top: 1px solid black;background-color: '.$clr[$clr_i=!$clr_i].'">'.$_['msgshow']['dump'][$i].'</div>';
			}
		} else if($cnt == 1) {
			$str .= '<div>'.$_['msgshow']['dump'][0].'</div>';
		} else {
			$str .= '<b>Нет значений.</b>';
		}
		if($str !== '') {
			return $str;
		} else {
			return NULL;
		}
	}
	
	public static function /*mix*/ getLog()
	{
		global $_;
		return $_['datalog'];
	}
}
