<?php /*************************************************************************
*    type: SRC.PHP5                                 © 2013 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
* created: 2013.02.01                                                          *
*    path: \Cms\Form                                                           * 
*******************************************************************************/
namespace Cms;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

/**
 * Позволяет автоматизировать создание форм.
 * Обеспечивает безопасность формы от XSS,
 * путем добавления поля form с хешем.
 * Необходимо добавить: если с одного IP отправлено много таких незакрытых
 * форм за день то показывать капчу
 */
class Form extends \System\Object
{
	protected $System = FALSE;
	protected $Edited = FALSE;
	
	protected $Name = FALSE;
	protected $Title = FALSE;
	protected $Inputs = array();
	protected $FID = array();
	
	/**
	 * Создает новую форму. Для сохранения в базу надо вызвать save.
	 */
	protected function construct($inSystem = NULL, $inName = NULL, $inTitle = NULL)
	{
		call_user_func_array('parent::construct',func_get_args());
		$this->System = $inSystem;
		$this->Name = $inName;
		$this->Title = $inTitle;
		$this->Edited = TRUE;
		$this->FID = $this->getNewHash();
		$this->Inputs['form'] = array(
			'type' => 'hidden',
			'name' => 'form',
			'title' => '',
			'value' => $this->FID);
		
	}
	
    protected function destruct()
    {
		call_user_func_array('parent::destruct', array());
	}
	
	/**
	 * Загружает из базы форму. 
	 */
	public static /*Form*/ function getForm()
	{
		//$this->Edited = FALSE;
		////
		//$form = new \Cms\Form();
		////
	}
	
	public function getNewHash()
	{
		return strtoupper(md5(rand(1000,9999).mtime()));
	}

	public function addInput($type, $name, $title, $required = TRUE)
	{
		$this->Edited = TRUE;
		if(array_key_exists($name,$this->Inputs)) {
			throw new \System\ECore('Input already exists.');
		}
		$this->Inputs[$name] = array('type' => $type, 'name' => $name, 'title' => $title, 'value' => '', 'error'=>NULL);
	}
	
	public function getInputs($inRequest)
	{
		$param = $this->Inputs;
		$param['form']['correctly'] = FALSE;
		$param['form']['checks'] = 0;
		$param['form']['failed'] = 0;
		
		$base = $this->System->getBase();
		$ip = $inRequest->GetWebClient()->getAddress();
		$sid = $inRequest->GetSession()->getSID();
		$query = 'SELECT SUM("check_count") FROM {forms} WHERE form = :form and apply = :apply and create_date > :create_date';
		$result = $base->execute($query,
			array(
				'form'        => $this->Name,
				'apply'       => 'N',
				'create_date' => (time() - (60 * 60))
			)
		);
		while( ($row = $result->fetchArray() )!==FALSE) {
			$param['form']['all_failed_access'] = $row[0];
		}
		$query = 'SELECT "id", "name", "value", "hash", "check_count" FROM {forms} WHERE sid = :sid and form = :form and apply = :apply';
		$result = $base->execute($query,
			array(
				'sid'   => $sid,
				'form'  => $this->Name,
				'apply' => 'N'
			)
		);
		if($result->numRows() > 0) {
			while( ($row = $result->fetchArray(TRUE) )!==FALSE) {
				$param[$row["name"]]['id'] = $row["id"];
				$param[$row["name"]]['value'] = $row["value"];
				$this->FID = $row["hash"];
				$param["form"]["checks"] = $row["check_count"];
			}
			
			$request = $inRequest->getWebRequest();
			foreach($param as $name => $input) {
				$cval = $request->getParam($name);
				if($name == 'form') {
					if($cval == $this->FID) {
						$param['form']['correctly'] = TRUE;
					}
					$cval = $this->FID;
				}
				if($cval !== NULL) {
					$param[$name]['value'] = $cval;
				}
			}
			
			if($param['form']['correctly']) {
				$param['form']['checks']++;
			}
			$query = 'UPDATE {forms} SET update_date = :update_date, check_count = :check_count, value = :value WHERE sid = :sid and form = :form and apply = :apply and name = :name';
			foreach($param as $name => $input) {
				$result = $base->execute($query,
					array(
						'update_date' => time(),
						'check_count' => $param['form']['checks'],
						'value'       => $param[$name]['value'],
						'sid'         => $sid,
						'form'        => $this->Name,
						'apply'       => 'N',
						'name'        => $name
					)
				);
			}
		} else {
			$param['form']['correctly'] = NULL;
			$nextval = $base->nextval('forms','id');
			$query = 'INSERT INTO {forms} VALUES (:id, :sid, :form, :apply, :ip, :create_date, :update_date, :hash, :check_count, :name, :value)';
			foreach($param as $name => $input) {
				$base->execute($query,
					array(
						'id'          => $nextval,
						'sid'         => $sid,
						'form'        => $this->Name,
						'apply'       => 'N',
						'ip'          => $ip,
						'create_date' => time(),
						'update_date' => time(),
						'hash'        => $this->FID,
						'check_count' => '0',
						'name'        => $name,
						'value'       => $param[$name]['value']
					), 'id'
				);
				$param[$name]['id'] = $base->getInsertID();
			}
		}
		return $param;
	}
	
	public function close($inRequest)
	{
		$query = 'UPDATE {forms} SET apply = :new_apply WHERE sid = :sid and form = :form and apply = :apply and name = :name';
		foreach($this->Inputs as $name => $input) {
			$result = $this->System->getBase()->execute($query,
				array(
					'sid'         => $inRequest->getSession()->getSID(),
					'form'        => $this->Name,
					'apply'       => 'N',
					'new_apply'   => 'Y',
					'name'        => $name
				)
			);
		}
	}
	
	public function save()
	{
		if($this->Edited == TRUE) {
			$this->Edited == FALSE;
			//Сохранение в БД
		}
	}
}