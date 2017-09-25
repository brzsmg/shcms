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
 * Браузер клиента
 */
class Browser extends \System\Object
{
	protected $Browscap = NULL;
	protected $Agent = NULL;
	protected $Data = NULL;
	
	protected function construct($inAgent = NULL)
	{
		call_user_func_array('parent::construct',func_get_args());
		$this->Agent = $inAgent;
	}
	
    protected function destruct()
    {
		call_user_func_array('parent::destruct', array());
	}
	
	private function init()
	{
		if($this->Data === NULL)
		{
			$this->Browscap = new \Net\Browscap('cache');
			$this->Browscap->localFile = 'data/full_php_browscap.ini';
			$this->Data = $this->Browscap->getBrowser($this->Agent);
		}
	}
	
	public function __get($Key)
	{
		$this->init();
		return $this->Data->{$Key};
	}

	public function executeRequest($inRequest)
	{
		throw new \System\ECore('Абстрактный метод');
	}

}