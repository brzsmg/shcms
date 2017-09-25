<?php
/**
 * SHCMS
 *
 * @copyright 2013-2017 Selivanovskikh M.G.
 * @license   GNU General Public License v2.0
 */

namespace Cms\Views;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}

/**
 * Представление для Статей.
 */
class User extends \Cms\View
{
	protected function construct($inRequest = NULL, $inSection = NULL)
	{
		call_user_func_array('parent::construct',func_get_args());
		$uid = intval($inRequest->getWebRequest()->getSectPath(2));
		if($uid <1) {
			$uid = $inRequest->getUser()->id;
		}
		$this->Data['user'] = $inRequest->getUser();
		$this->Data['ajax'] = $inRequest->isAjax();
		try {
			$user = new \Cms\User($inRequest->getSystem(),$uid);
			$this->Data['person'] = $user;
			$this->Data['exists'] = TRUE;
		}  catch (\Exception $e) {
			$this->Data['exists'] = FALSE;
		}
		/*$id = 0;
		if(is_object($inSection)) {
			$id = $inSection->data;
		} else {
			$id = $inSection;
		}
		call_user_func_array('parent::create',func_get_args());
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
		}*/
	}
	
    protected function destruct()
    {
		call_user_func_array('parent::destruct', array());
	}
	
}