<?php /*************************************************************************
*    type: SRC.PHP5                                © M.G. Selivanovskikh, 2013 *
* charset: UTF-8                                                               *
* created: 2013.02.01                                                          *
*    path: \Cms\System                                                         *
*******************************************************************************/
namespace Cms;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

/**
 * Content Managment System
 */
class System extends \System\Dispatch
{
	protected $Server = FALSE;
	protected $DB = NULL;
	protected $Config = array();
	protected $Text = FALSE;
	protected $ConnectionLimit = 2; //Количество подключений в секунду
	protected $ClientConnectionLimit = 0; //Количество подключений в секунду(для IP)
	protected $Install = NULL;
	public $Module = array();
	public $Controllers = array();
	//public $Service = array();   //Службы создаваемые модулями
	
	protected function construct($inServer = NULL)
	{
		call_user_func_array('parent::construct',func_get_args());
		if($inServer == FALSE) {
			throw new \System\ECore('server no found.');
		}
		$this->Server = $inServer;
		$config = new \Data\Config(DATA.DS.'config.cfg.php');
		$this->Config['core'] = $config->GetArray();
		$this->Text = new \System\Text($this->Config['core']);
		$this->AddEvent('EvtRequest');
		$this->Server->Listen('EvtRequest',array($this,'onRequest'));
		$sem = \sem_get('base');
		\sem_acquire($sem);
		if(file_exists(DATA.DS.'access.cfg.php')) {
			$this->openBase();
		}
		$this->loadModules();
		if(file_exists(DATA.DS.'access.cfg.php')) {
			$this->loadConfiguration();
			$this->Controllers[''] = 'Sections';
			$this->addController('captcha', 'Captcha');
			$this->addController('upload', 'Upload');
		}
		\sem_release($sem);
	}
	
    protected function destruct()
    {
		if($this->DB != NULL) {
			$this->DB->close();
        }
        call_user_func_array('parent::destruct', array());
    }
	
	public function openBase()
	{
		$access = new \Data\Config(DATA.DS.'access.cfg.php');
		$this->DB = \Data\Base::getBase($access->GetArray());
	}
	
    public function getBase()
    {
        return $this->DB;
    }
	
	private function loadConfiguration()
	{
		$query = 'SELECT "module", "key", "value" FROM {configuration}';
		$result = $this->DB->query($query);
		while(($row = $result->fetchArray())!==false) {
			if(!array_key_exists($row[0],$this->Config)) {
				$this->Config[$row[0]] = array();
			}
			$this->Config[$row[0]][$row[1]] = $row[2];
		}
	}
	public function getConfig($module = NULL, $key = NULL)
	{
		if($module === NULL) {
			return $this->Config;
		}
		if(array_key_exists($module,$this->Config)) {
			if(array_key_exists($key,$this->Config[$module])) {
				return $this->Config[$module][$key];
			}
		}
		return NULL;
	}
    public function setConnectionLimit($inLimit)
    {
		\Net\Session::setConnectionLimit($inLimit);
    }
    
    public function setClientConnectionLimit($inLimit)
    {
		\Net\Session::setClientConnectionLimit($inLimit);
    }
	
    public function onRequest($inWebRequest)
    {
		$request = new \Cms\Request($this,$inWebRequest);
		$this->Report('EvtRequest', $request);
		$controller = $this->getController($request);
		$key = \Security\Context::enableUserContext($request->getUser()->id);
		$controller->executeRequest($request);
		\Security\Context::enableSystemContext($key);
    }
    
    public function loadModules()
    {
		global $_;
		$system = $this; //Используется в Main модуля
		$handle = opendir(MODULES);
		if ($handle === FALSE) {
			return FALSE;
		}
		while (($entry = readdir($handle)) !== FALSE) {
			if((!is_dir(MODULES.DS.$entry))or($entry == '.')or($entry == '..')) {
				continue;
			}
			$this->Module[$entry] = array();
			$main = MODULES.DS.$entry.DS.'includes'.DS.'Main.php';
			if(file_exists($main)) {
				_log('Action: Include "'.$main.'";');
				include $main;
				$this->Module[$entry]['message'] = 'Модуль "'.$entry.'" успешно подключен.';
				\System\Console::info($this->Module[$entry]['message']);
			} else {
				$this->Module[$entry]['message'] = 'Не найден загрузочный файл модуля."'.$entry.'"';
				\System\Console::warning($this->Module[$entry]['message']);
			}
			$_['modules'][$entry]='';
		}
		return TRUE;
    }
	
	public function getModules()
	{
		return $this->Module;
	}
	
    public function getController($inRequest)
	{
		$path = '';
		$class = '\\Cms\\Controllers\\'.$this->Controllers[''];
		if($inRequest->GetWebRequest()->GetSectPathCount()>0) {
			$path = $inRequest->GetWebRequest()->GetSectPath(1);
			if(array_key_exists($path, $this->Controllers)) {
				$class = '\\Cms\\Controllers\\'.$this->Controllers[$path];
			}
		}
		if(class_exists($class)) {
			return new $class($this);
		} else {
			throw new \System\ECore('Не найден класс контроллера.');
		}
	}
	
    /**
	 * Поддержка Controller обеспечивается правильным ".htaccess"
	 */
    public function addController(/*string*/ $path, $method)
	{
		//Сделать проверку $path
		//Сделать $path паттерном?
		if(!array_key_exists($path, $this->Controllers)) {
			$this->Controllers[$path] = $method;
		} else {
			\System\Console::warning('Activity '.$path.' уже занята.');
		}
    }
	
}