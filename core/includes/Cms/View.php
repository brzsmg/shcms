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
 * Представление для страницы или Ajax запроса.
 * Оно возвращает Данные, Заголовки, не передавая их сразу клиенту
 * Имя шаблона как имя класса.
 */
class View extends \System\Dispatch
{
	protected $System = FALSE;
	protected $ModuleName = 'Core';
	protected $Links = array();
	protected $Block = NULL;
	protected $Data = array();
	//protected static $Views = array();
	
	/**
	 * Конструктор
	 *
	 * @inRequest Запрос
	 * @name Имя вьюхи
	 * @data Параметры для вьюхи
	 */
	public static function create($inRequest, $name, $data)
	{
		$view_class = '\\Cms\\Views\\'.$name;
		if(!class_exists($view_class)) {
			throw new \System\ECore('Представление "'.$view_class.'" не найдено.');
		}
		return new $view_class($inRequest, $data);
	}
	
	protected function construct($inRequest = NULL)
	{
		call_user_func_array('parent::construct',func_get_args());
		$this->System = $inRequest->getSystem();
	}
	
    protected function destruct()
    {
		call_user_func_array('parent::destruct', array());
	}
	
	/**
	 * Возвращает данные представления
	 */
	public function getTemplatePath()
	{
		$name = substr(get_called_class(),strlen('\\Cms\\Views'));
		return path($name);
	}
	
	/**
	 * Возвращает имя модуля вьюхи
	 */
	public function getModuleName()
	{
		return $this->ModuleName;
	}
	
	/**
	 * Возвращает данные представления
	 */
	public function getData()
	{
		return $this->Data;
	}
	
	/**
	 * Возвращает ответ в виде HTML
	 */
	public function getBlock()
	{
		return $this->Block;
	}
	
	/**
	 * Возвращает ссылки на ресурсы, необходимые коду HTML, одинаковые ссылки не повторяются
	 */
	public function getLinks()
	{
		return $this->Links;
	}
	
	/**
	 * Возвращает ответ в виде массива данных
	 */
	public function getArrayData()
	{
		return $this->Data;
	}
	
	/*public function addView($name, $class, $description)
	{
		$this->Views[$name] = array($name, $class, $description);
	}*/
	
}