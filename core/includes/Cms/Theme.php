<?php /*************************************************************************
*    type: SRC.PHP5                                 © 2013 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
* created: 2013.02.01                                                          *
*    path: \Cms\Theme                                                          * 
*                                                                              *
*   Должна быть возможность работать без Smarty.                               *
* Сначала ищем ресурс в папке темы, затем в папке ядра, затем в папке модуля.  *                                                                      *
* Вопросы:                                                                     *
*   Если необходимо что бы ресурс проверялся вначале в модуле?                 *
*   Можно добавить поддержку "тем", если настройка выставлена, искать сначала  *
*  в темах, иначе сначала в модуле.                                            *
*******************************************************************************/
namespace Cms;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

class Theme extends \System\Dispatch
{
	protected $System = FALSE;
	protected $Name   = FALSE;
	
	protected $DefaultPath = NULL;
	protected $CurrentPath = NULL;
	
	protected function construct($inSystem = NULL, $inName = NULL)
	{
		call_user_func_array('parent::construct',func_get_args());
		$this->System = $inSystem;
		$this->Name = $inName;
		$this->DefaultPath = CORE.DS.'theme';
		$this->CurrentPath = MODULES.DS.$this->Name.DS.'theme';
	}
	
    protected function destruct()
    {
		call_user_func_array('parent::destruct', array());
	}
	
	public function getPath($resource,$module = NULL)
	{
		$resource = str_replace('/', DS, $resource);
		$resource = str_replace('\\', DS, $resource);
		$path = $this->CurrentPath.DS.$resource;
		if(
			(strlen($this->Name) > 0)
			and ($this->Name != 'core')
			and (file_exists($path))
		) {
			return $path;
		}
		$path = $this->DefaultPath.DS.$resource;
		if(file_exists($path)) {
			return $path;
		}
		$path = MODULES.DS.$module.DS.'theme'.DS.$resource;
		if(($module !== NULL) and (file_exists($path))) {
			return $path;
		}
		throw new \System\ECore('Ресурс "'.$resource.'" не найден.');
	}
	
	public function getURL($resource, $module = NULL, $full = FALSE)
	{
		$resource = str_replace('/', DS, $resource);
		$resource = str_replace('\\', DS, $resource);
		$protocol = 'http';
		$url = NULL;
		if($full) {
			$full = $protocol.'://'.getenv('HTTP_HOST');
		} else {
			$full = '';
		}
		if(
			(strlen($this->Name) > 0)
			and ($this->Name != 'core')
			and (file_exists($this->CurrentPath.DS.$resource))
		) {
			$url = $full.'/modules/'.$this->Name.'/theme/';
		} else {
			if(file_exists($this->DefaultPath.DS.$resource)) {
				$url = $full.'/core/theme/';
			} else {
				if(
					($module !== NULL)
					and
					(file_exists(MODULES.DS.$module.DS.'theme'.DS.$resource))
				) {
					$url = $full.'/modules/'.$module.'/theme/';
				}
			}
		}
		if ($url !== NULL) {
			$resource = str_replace(DS, '/', $resource);
			return $url.$resource;
		} else {
			throw new \System\ECore('Ресурс "'.$resource.'" не найден.');
		}
	}
	
}