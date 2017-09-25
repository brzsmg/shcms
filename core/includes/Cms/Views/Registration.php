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
 * Представление для Регистрации.
 */
class Registration extends \Cms\View
{
	protected $System = FALSE;
	protected $Base = FALSE;
	
	protected $types = array(
		'',
		'text',
		'checkbox',
		'radiobox',
	);
	protected function construct($inRequest = NULL)
	{
		call_user_func_array('parent::construct',func_get_args());
		$this->System = $inRequest->getSystem();
		$this->Base	= $this->System->getBase();
		
		$form = $this->getForm($inRequest->getSystem());
		$error = NULL;
		$inputs = $form->getInputs($inRequest);
		if($inputs['form']['correctly']) {
			//$error = 'Не реализовано';
			$robot = TRUE;
			$captcha_key = $inRequest->getSession()->captcha_key;
			if(($captcha_key==NULL)or($captcha_key != $inputs['captcha']['value'])) {
				$inputs['captcha']['error'] = 'Проверочные символы введены неверно.';
				$error = 'Ошибки в форме';
			} else {
				$robot = FALSE;
			}
			$inRequest->getSession()->captcha_key = NULL;
			if($robot == FALSE) {
				$sem = \sem_get('registration');
				\sem_acquire($sem);
				$data = array();
				$query = 'SELECT "key", "title", "input", "required", "registration", "default" FROM {users_fields}';
				$result = $this->Base->query($query, array());
				if($result->numRows() > 0) {
					while( ($row = $result->fetchArray(TRUE) )!==FALSE) {
						if($row['registration'] == 'Y') {
							$value = $inputs[$row['key']]['value'];
							if($row['required'] == 'Y') {
								if(strlen($inputs[$row['key']]['value']) < 1) {
									$inputs[$row['key']]['error'] = 'Заполните это поле';
								}
							}
							if($row['key'] === 'email') {
								$query = 'SELECT "id" FROM {users_data} WHERE "key" = :key and "value" = :value';
								$sub_result = $this->Base->query($query, array(
									'key' => $row['key'],
									'value' => $inputs[$row['key']]['value'],
									)
								);//echo 'j';
								if($sub_result->numRows() > 0) {
									$error = 'Ошибки в форме';
									$inputs['email']['error'] = 'Пользователь с таким Email уже существует';
								}
							}
							//Проверка VALUE
							$data[$row['key']] = $value;
						} else {
							$data[$row['key']] = $row['default'];
						}
					}
				}
				if($error === NULL) {
					$nextval = $this->Base->nextval('users','id');
					$query = 'INSERT INTO {users} ("id", "start_date", "close_date", "create_date", "update_date", "create_user", "update_user", "reason") VALUES (:id, :start_date, :close_date, :create_date, :update_date, :create_user, :update_user, :reason)';
					$time = time();
					$result = $this->Base->execute($query, array(
						'id'          => $nextval,
						'start_date'  => $time,
						'close_date'  => 0,
						'create_date' => $time,
						'update_date' => $time,
						'create_user' => '2000',
						'update_user' => '2000',
						'reason'      => 'Registration new user.'
					), 'id');
					$id = $this->Base->getInsertID();
					foreach($data as $key => $value) {
						if($key == 'password') {
							$value = md5($value);
						}
						$query = 'INSERT INTO {users_data} ("id", "key", "value") VALUES (:id, :key, :value)';
						$result = $this->Base->query($query, array(
							'id'    => $id,
							'key'   => $key,
							'value' => $value,
						));
					}
					$inRequest->setUID($id);
				}
				\sem_release($sem);
			}
		}
		$this->Data = array(
			'inputs' =>$inputs,
			'query'=>$inRequest->getQuery(),
			'error'=> $error,
			'user' => $inRequest->getUser()
		);
	}
	
    protected function destruct()
    {
		call_user_func_array('parent::destruct', array());
	}
	
	public function getForm($inSystem)
	{
		$form = \Cms\Form::getForm($inSystem,'Registration');
		if($form == FALSE) {
			$form = new \Cms\Form($inSystem, 'Registration');
			$query = 'SELECT "key", "title", "input", "required", "registration", "default" FROM {users_fields} WHERE "registration" = :registration ORDER BY "position"';
			$result = $this->Base->query($query, array('registration' => 'Y'));
			if($result->numRows() > 0) {
				while( ($row = $result->fetchArray(TRUE) )!==FALSE) {
					$form->addInput($row['input'],$row['key'],$row['title']);
					if($row['key'] == 'password') {
						$form->addInput('password', 'pwrepeat', 'Repeat password');
					}
				}
			}
			$form->addInput('captcha', 'captcha', 'Captcha');
			$form->Save();
		}
		return $form;
	}

}