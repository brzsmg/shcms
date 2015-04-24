<?php /*************************************************************************
*    type: SRC.PHP5                            © 2013-2015 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
* created: 2013.02.01                                                          *
*    path: \Cms\Page                                                           * 
*******************************************************************************/
namespace Cms;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

/**
 * Формируемая для пользователя страница.
 */
class Page extends \Net\Response
{
	protected $Server = NULL;
	protected $Request = NULL;
	protected $Theme = NULL;
	protected $View = NULL;
	
	protected $Views = array();
	protected $Blocks = array();
	
	//Массив данных для генерации страницы
	protected $Data = array();

//Справочник представлений для разделов
//Представление содержит вьюхи для блоков.

//Для шаблона должно быть:
// * полностью собрано меню
// * Сессия(+клиент,+пользователь)
// * Информация о блоках и вьюхах

//Пока можно не отделять блоки от вьюх.
//Блоки (находядся в шаблоне):
// * content(content)
// * user_panel(user_panel)
// * left_panel(main_menu)
// * right_panel
// * bottom_panel

//Вьюхи (привязываются к блокам):
// * content([core\theme\]tpl\content.tpl)
// * user_panel([core\theme\]tpl\user_panel.tpl)
// * main_menu([core\theme\]tpl\menu.tpl)
// * example([modules\example\theme\]tpl\my.tpl)
	
	protected function construct($inRequest = NULL, $inTheme = NULL, $inView = NULL)
	{
		call_user_func_array('parent::construct',func_get_args());
		$this->System = $inRequest->getSystem();
		$this->Server = $inRequest->getWebServer();
		$this->Request = $inRequest;
		$this->View = $inView;
		
		
		$this->Theme = $inTheme;
                
		$this->cachedir = CACHE.DS.'templates';//TODO: из конфига
		
		$this->assign('config', $this->Request->getSystem()->getConfig());
		$this->assign('statistic', new \Cms\Statistic($this->Request));
		$this->assign('session', $this->Request->getSession());
		$this->assign('user', $this->Request->getUser());

		$this->assign('debug', $this->getDebug());
	}
	
    protected function destruct()
    {
		call_user_func_array('parent::destruct', array());
	}
	
	protected function fetch($path,$module = NULL)
	{
		$data = new \Smarty_Data;
		$data->assign($this->Data);
		$tplpath = $this->Theme->GetPath('tpl'.DS.$path.'.tpl',$module);
		$tpl = $this->smarty->createTemplate($tplpath,$data);
		error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
		$result = $tpl->fetch();
		error_reporting(E_ALL);
		return $result;
	}
	
	public function load($inTpl = NULL, $inFormat = NULL)
	{
		$smarty_path = SOURCES.DS.'Lib'.DS.'Smarty'.DS.'Smarty.class.php';
		include_source($smarty_path);
		
		$this->smarty = new \Smarty();
		$this->smarty->compile_check = True;
		$this->smarty->compile_dir = $this->cachedir.DS; //Общая папка
		$this->smarty->cache_dir = $this->cachedir.DS;   //Общая папка
		$this->smarty->template_dir = dirname($this->Theme->GetPath('tpl'));
		$this->smarty->registerPlugin('function','view', array($this,'tpl_view'));
		$this->smarty->registerPlugin('function','theme', array($this,'tpl_theme'));
		$this->smarty->registerPlugin('function','link', array($this,'tpl_link'));
		$this->smarty->registerPlugin('function','send', array($this,'tpl_send'));
		$this->smarty->registerPlugin('function','thumb', array($this,'tpl_thumb'));
		$this->smarty->registerPlugin('modifier','plural', array($this,'tpl_plural'));

		
		//$view = $this->getView($this->ViewName);
		$this->assign($this->View->getData());
		$this->Blocks['content'] = $this->fetch($this->View->getTemplatePath());
		$html = NULL;
		
		if($inTpl != NULL ) {
			$this->assign('block', $this->Blocks);
			$html = $this->fetch($inTpl);
		} else {
			$html = $this->Blocks['content'];
		}
		if($inFormat == 'json') {
			$result = array(
				'state' => 'success',
				'body' => $html,
				'debug_log' => $this->Data['debug']['log']
			);
			$this->Body = $this->_json_encode($result);
			/*$this->Body = '{'."\r\n\t".'"body": ';
			$this->Body .= json_encode($html);
			$this->Body .= ','."\r\n\t".'"debug_log": ';
			$this->Body .= json_encode($this->Data['debug']['log']);
			$this->Body .= "\r\n".'}';
			print_r($this->Body);exit;*/
		} else {
			$this->Body = $html;

		}
	}
	/**
	 * devilan@o2.pl
	 * @param type $arr
	 * @return type
	 */
	public function _json_encode($arr)
	{
			//convmap since 0x80 char codes so it takes all multibyte codes (above ASCII 127). So such characters are being "hidden" from normal json_encoding
			/*array_walk_recursive($arr, function (&$item, $key) { if (is_string($item)) $item = mb_encode_numericentity($item, array (0x80, 0xffff, 0, 0xffff), 'UTF-8'); });
			return mb_decode_numericentity(json_encode($arr), array (0x80, 0xffff, 0, 0xffff), 'UTF-8');*/
			return json_encode($arr);
	}
	
//
	public function tpl_thumb($params) {
		if(array_key_exists('size',$params)) {
			$s = explode('x',$params['size']);
			if($s>1) {
				$params['width']  = $s[0];
				$params['height'] = $s[1];
			}
		}
		$thumb = new \Cms\Thumb($this->System, $params);
		return $thumb->getPath();
	}
	
	public function tpl_plural($n,$n0='иев',$n1='ий',$n2='ия')
	{
		if((4 < $n) && ($n < 21)){
			return $n0;
		}
		$n = $n % 10;
		if ($n==1) {
			return $n1;
		} elseif(($n > 4) ||($n==0)) {
			return $n0;
		} else {
			return $n2;
		}
	}
	/**
	 * Функция делает ссылку, либо вызов функции JS в зависимости
	 * от типа устройства пользователя.
	 */
	public function tpl_link($params)
	{
		if((array_key_exists('path',$params)) and (array_key_exists('popup',$params))) {
			if($this->Request->getSession()->device_type == 'Desktop') {
				return 'href="'.$params['path'].'" onclick="link(\''.$params['path'].'\'); return false;"';
			}
		}
		return 'href="'.$params['path'].'"';
	}
	
	/**
	 * Отправка формы
	 */
	public function tpl_send($params)
	{
		if(array_key_exists('form',$params)) {
			if($this->Request->getSession()->device_type == 'Desktop') {
				if(array_key_exists('popup',$params)) {
					return ' onclick="send(\''.$params['form'].'\',true); return false;"';
				} else {
					return ' onclick="send(\''.$params['form'].'\',false); return false;"';
				}
			}
		}
		return '';
	}
	/**
	 * Возвращает путь к ресурсу для текущей темы
	 */
	public function tpl_theme($params)
	{
		if(array_key_exists('path',$params)) {
			return $this->Theme->GetURL($params['path']);
		}
	}
	
	/**
	 * Подключает View
	 */
	public function tpl_view($params)
	{
		if(array_key_exists('name',$params)) {
			if(array_search($params['name'], $this->Views) !== FALSE) {
				throw new \System\ECore('Рекурсивная загрузка View.');
			}
			if(!array_key_exists('data', $params))
			{
				$params['data'] = NULL;
			}
			//$this->Views[] = $params['name'];//TODO нужно вернуть
			$view = \Cms\View::create($this->Request, $params['name'], $params['data']);
			$this->assign($view->getData());
			return $this->fetch($view->getTemplatePath(),$view->getModuleName());
		} else {
			throw new \System\ECore('Название представления не указано.');
		}
	}
	
	public function assign($var, $value = NULL)
	{
		if(is_array($var)) {
			$this->Data = array_merge($this->Data,$var);
		} else {
			if(array_key_exists($var,$this->Data)) {
				throw new \System\ECore('Var allready assigned');
			}
			$this->Data[$var] = $value;
		}
	}

	protected function getDebug()
	{
		$debug = array();
		if(DEBUG) {
			$debug['enable'] = true;
			$debug['info'] = '<i>'._('This message is displayed in debug mode. When you publish a site, you disable this option for security.').'</i><br/><br/>';
			$debug['info'] .= _('Memory use').': <b>'.\System\Console::getUsageTime().'</b><br/>';
			$debug['info'] .= _('Usage time').': <b>'.total_time(\System\Console::getStartTime()).'</b><br/>';
			$start = \System\Console::getStartTime();
			$log = \System\Console::getLog();

			$debug['log'] = '';
			$ds = 'N';
			$cnt = count($log);
			for($i = 0; $i < $cnt; $i++) {
				if($log[$i][1] == 'error') {
					$ds = 'Y';
				}
				$time = str_pad(round(($log[$i][0]-$start)*1000),3,'0',STR_PAD_LEFT);
				$debug['log'] .= '<div class="debug-'.$log[$i][1].'">'.$time.': '._($log[$i][2]).'</div>';
			}
			$debug['log'] = str_replace("\r", '', $debug['log']);
			$debug['log'] = str_replace("\n", '', $debug['log']);
			$debug['log'] = str_replace('\\', '\\\\', $debug['log']);
			$debug['log'] = str_replace('\'', '\\\'', $debug['log']);

			$debug['dump'] = \System\Console::getDump();
			$debug['console_show'] = $ds;
		} else {
			$debug['enable'] = false;
		}
		return $debug;
	}

}