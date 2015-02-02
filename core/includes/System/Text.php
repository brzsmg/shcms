<?php /*************************************************************************
*  M.PHP5:                                     © 2013-2014 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
*    path: \System\Text                                                        *  
*******************************************************************************/
namespace System;
if(!defined('SOURCES')){Header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

/**
 * Через этот класс выводится весь текст, который может быть переведен.
 */
class Text extends \System\Object {

	protected $GettextArray = array();
	protected $Culture = 'ru';
	protected $Dir = 'locale';
	
	/**
	 * @param string $conf <p>Настройки из файла.</p>
	 */
	protected function /*void*/ construct($conf=null)
	{
		call_user_func_array('parent::construct',func_get_args());
		if(array_key_exists('culture',$conf)) {
			$this->Culture = $conf['culture'];
		}
		$this->addLang('core');
		//Определяем короткую функцию
		global $_;
		$_['_'] = array($this,'miniMethod');
	}
	
    protected function destruct()
    {
		call_user_func_array('parent::destruct', array());
	}
	
	/**
	 * Добавляет перевод текстов модуля для текущей локализации.
	 * @param string $module <p>Название каталога модуля.</p>
	 * @return void
	 */
	public function addLang($module)
	{
		if($module == 'core') {
			$fculture = CORE.DS.$this->Dir.DS.$this->Culture.DS.'core.po';
		} else {
			$fculture = MODULES.DS.$module.DS.$this->Dir.DS.$this->Culture.DS.'core.po';
		}
		if(file_exists($fculture)) {
			$this->readPO($fculture);
		}
	}
	
	/**
	 * @TODO Эта функция должна читаться из PO файла2
	 * @param integer $module <p>Число</p>
	 * @return integer <p>Номер числовой формы</p>
	 */
	private function pluralForms($n){
		return
		(
			((($n%10)==1)&&(($n%100)!=11))
			?
			(0)
			:
			(
				(((($n%10)>=2)&&(($n%10)<=4))&&((($n%100)<10)||(($n%100)>=20)))
				? (1) : 2
			)
		);
	}
	
	/**
	 * Метод для вызова через короткую функцию "<b>_('Example');</b>".
	 * @param string $text <p>Текст на английском языке</p>
	 * @param integer $n [optional] <p>Число</p>
	 * @return string <p>Текст на локальном языке</p>
	 */
	public function miniMethod($text, $n=null)
	{
		$t = $this->gettext($text,$n);
		if($n!==null)
		{
			$t = str_replace('%n', $n, $t);
		}
		return $t;
	}
	
	/**
	 *Функция сама по себе не производит подстановку числового значения
	 */
	public function gettext($id, $n=null)
	{	
		$result = $id;
		if(array_key_exists($id,$this->GettextArray)) {
			$result = $this->GettextArray[$id][0];
			if($n!==null) {
				if($this->GettextArray[$id]['plural']!==false) {
					$f = $this->pluralForms($n);
					if(array_key_exists($f,$this->GettextArray[$id])) {
						$result = $this->GettextArray[$id][$f];
					}
				}
			}
		}
		return $result;
	}
	
	private function readPO($fn)
	{
		$str = array();
		$strid = '';
		$str_one = '';
		$plural = false;
		$plural_cnt = 0;
		$handle = @fopen($fn, "r");
		if ($handle) {
			while (($buffer = fgets($handle, 4096)) !== false) {
				$buffer = str_replace('"', '\\"', $buffer);
				$buffer = str_replace('\\\\"', '"', $buffer);
				if(substr($buffer,0,3)=='msg') {
					$sub5=substr($buffer,0,5);
					$sub6=substr($buffer,0,6);
					$sub12=substr($buffer,0,12);
					if(($sub5=='msgid')and($sub12 != 'msgid_plural')) {
						$plural_cnt = 0;
						$plural = false;
						$d = explode('\\"',$buffer);
						$strid = $d[1];
					}
					if($sub12 == 'msgid_plural') {
						$plural = true;
						$str_one = $strid;
						$d = explode('\\"',$buffer);
						$strid = $d[1];
						//$strid_plural = $d[1];
					}
					if($sub6=='msgstr') {
						$str[$strid]['plural'] = $plural;
						if($plural===true) {
							$str[$strid]['id'] = $str_one;
						}
						$d = explode('\\"',$buffer);
						$str[$strid][$plural_cnt] = $d[1];
						$plural_cnt++;
					}
				}
			}
			if (!feof($handle)) {
				throw new \System\ECore('Error: unexpected fgets() fail');
			}
			fclose($handle);
		}
		$this->GettextArray = array_merge($this->GettextArray, $str);
	}
}
