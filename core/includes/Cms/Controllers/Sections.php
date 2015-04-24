<?php /*************************************************************************
*    type: SRC.PHP5                            © 2013-2015 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
* created: 2013.02.01                                                          *
*    path: \Cms\Controllers\Sections                                           * 
*******************************************************************************/
namespace Cms\Controllers;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

/**
 * Контроллер для разделов.
 */
class Sections extends \Cms\Controller
{
	
	protected function construct($inSystem = NULL)
	{
		call_user_func_array('parent::construct',func_get_args());
	}
	
    protected function destruct()
    {
        call_user_func_array('parent::destruct',array());
    }
	
	public function executeRequest($inRequest)
	{
		$section = $this->getSection($inRequest);
		$view = \Cms\View::create($inRequest,$section->view,$section->data);
		$theme_name = $this->System->GetConfig('core','theme');
		$theme = new \Cms\Theme($this->System, $theme_name);
		$page = new \Cms\Page($inRequest, $theme, $view);
		$page->assign('title', $section->title);
		$page->assign('section', $section);
		if($inRequest->isBlock()) {
			$page->load(NULL,'json');
		} else {
			$page->load('Page');
		}
		$inRequest->sendResponse($page);
	}
	
	private function getSection($inRequest)
	{
		$WebRequest = $inRequest->getWebRequest();
		$path = '';
		if($WebRequest->GetSectPathCount()>0) {
			$path = $WebRequest->GetSectPath(1);
		}
		$section = NULL;
		if(($path != '')/*and($path != 'index.php')*/) {
			try {
				$section = new \Cms\Section($this->System, NULL, $path);
			} catch(\Exception $e) {
				$section = FALSE;
				\System\Console::error('Section no found.');
			}
		} else {
			$section_id = $WebRequest->GetParam('s','GET');
			if($section_id !== NULL) {
				try {
					$section = new \Cms\Section($this->System, (int)$section_id);
				} catch(\Exception $e) {
					$section = FALSE;
					\System\Console::error('Section no found.');
				}
			}
		}
		if($section === NULL) {
			$section = new \Cms\Section($this->System, (int)$this->System->getConfig('core', 'section_start'));
		}
		if(($section !== NULL)and($section !== FALSE)) {
			//Проверяем доступ
			if(!$inRequest->getUser()->getAccess($section)) {
				$section = FALSE;
				\System\Console::error('No access to the section.');
			}
		}
		if(($section === FALSE)or($section->view == '')) {
			$section = new \Cms\Section($this->System, (int)$this->System->getConfig('core', 'section_error'));
		}
		return $section;
	}
	
}