<?php /*************************************************************************
*    type: SRC.PHP5                                 © 2013 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
* created: 2013.02.01                                                          *
*    path: \Cms\View                                                           * 
*******************************************************************************/
namespace Cms;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

/**
 * Представление для страницы или Ajax запроса.
 * Оно возвращает Данные, Заголовки.
 * Имя шаблона как имя класса.
 */
class View extends \System\Dispatch
{
	protected $System = FALSE;
	protected $Links = array();
	protected $Block = NULL;
	protected $Data = array();
	//protected static $Views = array();
	
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