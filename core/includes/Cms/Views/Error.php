<?php /*************************************************************************
*    type: SRC.PHP5                            © 2013-2015 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
* created: 2013.02.01                                                          *
*    path: \Cms\Views\Registration                                             * 
*                                                                              *
*   Представление для Сообщения о ошибке.                                      *
*******************************************************************************/
namespace Cms\Views;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

class Error extends \Cms\View
{
	public function construct($inRequest = NULL, $inSection = NULL)
	{
		call_user_func_array('parent::construct',func_get_args());
		$path = '';
		$wr = $inRequest->getWebRequest();
		for($i = 1; $i <= $wr->getSectPathCount(); $i++) {
			$path .= '/'.$wr->getSectPath($i);
		}
		$this->Data['title'] = _('Error');
		if($path != '') {
			
			$this->Data['message']  = sprintf(_('Page "%s" not found or is not available.'),$path);
		} else {
			$this->Data['message']  = _('Page not found or is not available.');
		}
	}
	
    protected function destruct()
    {
		call_user_func_array('parent::destruct', array());
	}
	
}