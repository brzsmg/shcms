<?php /*************************************************************************
*    type: SRC.PHP5                            © 2013-2015 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
* created: 2013.02.01                                                          *
*    path: \Cms\Views\Article                                                  * 
*******************************************************************************/
namespace Cms\Views;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

/**
 * Представление для Статей.
 */
class Article extends \Cms\View
{

	protected function construct($inRequest = NULL, $inSection = NULL)
	{
		call_user_func_array('parent::construct',func_get_args());
		
		$id = 0;
		if(is_object($inSection)) {
			$id = $inSection->data;
		} else {
			$id = $inSection;
		}
		$db = $inRequest->getSystem()->getBase();
		$query = 'SELECT name, article FROM {articles} WHERE id = :id';
		$result = $db->query($query, array('id'=>$id));
		$row = $result->fetchArray();
		if($row !== FALSE) {
			$this->Data['title'] = $row[0];
			$this->Data['content'] = $row[1];
			$this->Block = '<h4>'.$row[0].'</h4>'.$row[1].'';
			$this->Links[] = '<link rel="icon" type="image/png" href="main.png" />';
			$this->Links[] = '<script type="text/javascript" src="jquery.js"></script>';
		} else {
			throw new \System\ECore('Article no found.');
		}
	}
	
    protected function destruct()
    {
		call_user_func_array('parent::destruct', array());
	}
}