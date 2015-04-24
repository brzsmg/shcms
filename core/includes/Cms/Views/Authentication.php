<?php /*************************************************************************
*    type: SRC.PHP5                            © 2013-2015 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
* created: 2013.02.01                                                          *
*    path: \Cms\Views\Authentication                                           * 
*******************************************************************************/
namespace Cms\Views;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

/**
 * Представление для Аутентификации пользователей.
 */
class Authentication extends \Cms\View
{
	protected function construct($inRequest = NULL)
	{
		//$this->System->getConfig('core', 'section_start')
		call_user_func_array('parent::construct',func_get_args());
		$base = $this->System->getBase();
		$form = $this->createForm($inRequest->getSystem());
		$inputs = $form->getInputs($inRequest);
		$error = NULL;
		$id = NULL;
		$password = NULL;
		if($inputs['form']['correctly']) {
			//$error = 'Не реализовано';
			$robot = FALSE;
			if(($inputs['form']['checks'] > 3)or($inputs['form']['failed'] > 6)) {
				$robot = TRUE;
				$captcha_key = $inRequest->getSession()->captcha_key;
				if(($captcha_key==NULL)or($captcha_key != $inputs['captcha']['value'])) {
					$inputs['captcha']['error'] = 'Проверочные символы введены неверно.';
					$error = 'Ошибки в форме';
				} else {
					$robot = FALSE;
				}
			}
			if(strpos($inputs['login']['value'], '@')!==FALSE) {//Введен ли E-mail
				$value_email = strval($inputs['login']['value']);//НЕ ПРОВЕРЯЕТСЯ!!!
				if($value_email != '') {
					$query = 'SELECT "id" FROM {users_data} WHERE "key" = :key and "value" = :value';
					$result = $base->execute($query,array(
						'key'=>'email',
						'value'=>$value_email
					));
					if($result->numRows()>0) {
						$row = $result->fetchArray();
						$id = $row[0];
					}
				}
				
			} else {
				$value_id = intval($inputs['login']['value']);
				if($value_id != 0) {
					$query = 'SELECT "id" FROM {users} WHERE id = :id and start_date < :now and ((close_date = 0) or(close_date > :now))';
					$result = $base->execute($query,array(
						'id'=>$value_id,
						'now'=>time()
					));
					if($result->numRows()>0) {
						$row = $result->fetchArray();
						$id = $row[0];
					}
				}
			}
			if(strlen($inputs['login']['value']) < 1) {
				$inputs['login']['error'] = 'Заполните это поле.';
				$error = 'Ошибки в форме';
			}
			if(strlen($inputs['password']['value']) < 1) {
				$inputs['password']['error'] = 'Заполните это поле.';
				$error = 'Ошибки в форме';
			}
			if( ($error === NULL) and (!$robot) ) {
				if($id !== NULL) {
					$query = 'SELECT "value" FROM {users_data} WHERE "id" = :id and "key" = :key';
					$result = $base->execute($query,array(
						'id'=>$id,
						'key'=>'password'
					));
					if($result->numRows()>0) {
						$row = $result->fetchArray();
						$password = $row[0];
					}
				}
				if(md5($inputs['password']['value']) === $password) {
					$inputs['form']['accepted'] = TRUE;
					$this->auth($inRequest, $id);
					$form->close($inRequest);
				} else {
					$error = 'Неверный логин или пароль.';
				}
			}
		}
		$this->Data = array(
			'inputs' => $inputs,
			'ajax'   => $inRequest->isAjax(),
			'query'  => $inRequest->getQuery(),
			'error'  => $error,
			'user' => $inRequest->getUser()
		);
	}
	
    protected function destruct()
    {
		call_user_func_array('parent::destruct', array());
	}
	
	public function auth($inRequest, $id)
	{
		$inRequest->setUID($id);
	}
	
	public function createForm($inSystem)
	{
		$form = new \Cms\Form($inSystem, 'Authentication');
		$form->addInput('text', 'login', 'E-mail or ID');
		$form->addInput('password', 'password', 'Password');
		$form->addInput('checkbox', 'remember', 'Remember');
		$form->addInput('captcha', 'captcha', 'Captcha');
		$form->Save();
		return $form;
	}
	
}