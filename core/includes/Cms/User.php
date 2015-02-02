<?php /*************************************************************************
*    type: SRC.PHP5                            © 2013-2015 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
* created: 2013.02.01                                                          *
*    path: \Cms\User                                                           * 
*******************************************************************************/
namespace Cms;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

/**
 * Пользователь системы
 */
class User extends \System\Dispatch //\Cms\Item
{
	protected $System = NULL; //HIDE
	protected $Base = NULL; //HIDE
	
	protected $_id = NULL;
	protected $CreateDate = NULL;
	protected $UpdateDate = NULL;
	protected $Balance = FALSE;
	
	protected $Access = FALSE;//Сюда кешируем доступ
	
	protected static $DefaultAccess = FALSE;
	
	protected $Data = FALSE;
	
	
	protected function construct($inSystem = NULL, $inUID = NULL)
	{
		call_user_func_array('parent::construct',func_get_args());
		$this->System = $inSystem;
		$this->Base = $this->System->getBase();
		$this->_id = $inUID;
		if($this->Base != FALSE) {
			$query ='SELECT "create_date","update_date" FROM {users} WHERE "id" = :id';
			$result = $this->Base->execute( $query, array('id'=>$this->_id) );
			if($result->numRows()<1) {
				throw new \System\ECore('Такого пользователя не существует.');
			} else {
				$row = $result->fetchArray();
				$this->CreateDate = $row[0];
				$this->UpdateDate = $row[1];
			}
		
			$query='SELECT t1."key", t2."value" FROM {users_fields} t1 LEFT JOIN {users_data} t2 ON t1.key = t2.key and t2.id = :id';
			$result = $this->Base->execute($query, array('id'=>$this->_id));
			$this->Data = array();
			while(($row = $result->fetchArray())!==False) {
				$this->Data[$row[0]]=$row[1];
			}
		}
	}
	
    protected function destruct()
    {
		call_user_func_array('parent::destruct', array());
	}
	
	public function __get($field)
	{
    if($field == 'id') {
      return $this->_id;
    } else {
      if($this->Data == FALSE) {
        throw new \System\ECore('Невозможно получить параметр "'.$field.'".');
      }
      if(array_key_exists($field,$this->Data)) {
        return $this->Data[$field];
      } else if($field == 'balance') {
        return $this->getBalance();
      } else if($field == 'create_date') {
        return $this->CreateDate;
      } else if($field == 'update_date') {
        return $this->UpdateDate;
      } else {
        return NULL;
        //throw new \System\ECore('Field no found');
      }
		}
	}
	
	public function __set($field,$value)
	{
		if(array_key_exists($field,$this->Data)) {
			if($this->Data[$field] !== NULL) {
				$query='UPDATE {users_data} SET "value" = :value WHERE "id" = :id and "key" = :key';
				$result = $this->Base->execute($query, array(
					'id'  => $this->_id,
					'key' => $field,
					'value' => $value
				));
			} else {
				$query='INSERT INTO {users_data} VALUES(:id, :key, :value)';
				$result = $this->Base->execute($query, array(
					'id'  => $this->_id,
					'key' => $field,
					'value' => $value
				));
			}
			//var_dump($result);exit;
			//TODO: check $result
		} else {
			throw new \System\ECore('Field "'.$field.'" no found.');
			//throw new \System\ECore('Field no found');
		}
	}
	
	public function getAvatar()
	{
		$fa = '/files/users/'.$this->_id.'.png';
		if (file_exists(ROOT.path($fa))) {
			return $fa;
		} else {
			return '/files/users/2000.png';
		}
	}
	
	public function getBalance()
	{
		if($this->Balance !== FALSE) {
			return $this->Balance;
		} else {
			$query = 'SELECT "balance" FROM {balance} WHERE "uid" = :uid and "end_date" is NULL';
			$result = $this->Base->query($query,array('uid'=>$this->_id));
			while(($row=$result->fetchArray()) !== FALSE) {
				$this->Balance = $row[0];
				return $this->Balance;
			}
			$this->Balance = NULL;
			return $this->Balance;
		}
	}
	
	public function UpdateBalance($update, $reason)
	{
		if($this->Balance !== FALSE) {
			return $this->Balance;
		} else {
			if(($update != NULL) and (intval($update) < 1)){
				throw new \System\ECore('Ошибка в значении "'.$update.'" для проведения операции.');
			}
			$time = time();
			$new_balance = 0;
			$query = 'SELECT "balance" FROM {balance} WHERE "uid" = :uid and "end_date" is NULL';
			$result = $this->Base->execute( $query, array('uid'=>$this->_id) );
			if(($row=$result->fetchArray()) !== FALSE) {
				$query = 'UPDATE {balance} SET "end_date" = :end_date WHERE "uid" = :uid and "end_date" is NULL';
				$this->Base->execute($query, array(
					'uid'      => $this->_id,
					'end_date' => $time
				));
				$new_balance = intval($row[0]);
			}
			$new_balance += intval($update);

			$query = 'INSERT INTO {balance} ("uid", "start_date", "end_date", "balance", "update", "reason") VALUES (:uid, :start_date, :end_date, :balance, :update, :reason)';
			$this->Base->execute($query, array(
				'uid'      => $this->_id,
				'start_date' => $time,
				'end_date' => NULL,
				'balance' => $new_balance,
				'update' => $update,
				'reason' => $reason
			));
			$this->Balance = $new_balance;
		}
	}
	
	public function getAccess($inObject, $right = '')
	{
		$table = '';
		$id = 0;
		if(is_string($inObject)) {
			$table = $inObject;
		}
		$table = $inObject->getTable();
		$id = $inObject->getID();
		
		if(User::$DefaultAccess === FALSE) {
			User::$DefaultAccess = array();
			$query = 'SELECT "source", "oid", "right", "value" FROM {access} WHERE "uid" = :uid';
			$result = $this->Base->query($query, array('uid'=>'0'));
			while(($row=$result->fetchArray()) !== FALSE) {
				if($row[3] == 'Y') {
					User::$DefaultAccess[$row[0]][$row[1]][$row[2]] = 'Y';
				} else {
					User::$DefaultAccess[$row[0]][$row[1]][$row[2]] = 'N';
				}
			}
		}
		if($this->Access === FALSE) {
			$this->Access = array();
			$query = 'SELECT "source", "oid", "right", "value" FROM {access} WHERE "uid" = :uid';
			$result = $this->Base->query($query,array('uid'=>$this->_id));
			while(($row=$result->fetchArray()) !== FALSE) {
				if($row[3] == 'Y') {
					$this->Access[$row[0]][$row[1]][$row[2]] = 'Y';
				} else {
					$this->Access[$row[0]][$row[1]][$row[2]] = 'N';
				}
			}
		}
		$ret = NULL;
		//TODO: Далее идет ужасный кот(код)
		if(array_key_exists($table, User::$DefaultAccess)) {
			if(array_key_exists($id, User::$DefaultAccess[$table])) {
				if(array_key_exists($right, User::$DefaultAccess[$table][$id])) {
					$ret = User::$DefaultAccess[$table][$id][$right];
				} else if(array_key_exists('', User::$DefaultAccess[$table][$id])) {
					$ret = User::$DefaultAccess[$table][$id][''];
				}
			} else if(array_key_exists('0', User::$DefaultAccess[$table])) {
				if(array_key_exists($right, User::$DefaultAccess[$table]['0'])) {
					$ret = User::$DefaultAccess[$table]['0'][$right];
				} else if(array_key_exists('', User::$DefaultAccess[$table]['0'])) {
					$ret = User::$DefaultAccess[$table]['0'][''];
				}
			}
		} else if(array_key_exists('', User::$DefaultAccess)) {
			if(array_key_exists($id, User::$DefaultAccess[''])) {
				if(array_key_exists($right, User::$DefaultAccess[''][$id])) {
					$ret = User::$DefaultAccess[''][$id][$right];
				} else if(array_key_exists('', User::$DefaultAccess[''][$id])) {
					$ret = User::$DefaultAccess[''][$id][''];
				}
			} else if(array_key_exists('0', User::$DefaultAccess[''])) {
				if(array_key_exists($right, User::$DefaultAccess['']['0'])) {
					$ret = User::$DefaultAccess['']['0'][$right];
				} else if(array_key_exists('', User::$DefaultAccess['']['0'])) {
					$ret = User::$DefaultAccess['']['0'][''];
				}
			}
		}
		if(array_key_exists($table, $this->Access)) {
			if(array_key_exists($id, $this->Access[$table])) {
				if(array_key_exists($right, $this->Access[$table][$id])) {
					$ret = $this->Access[$table][$id][$right];
				} else if(array_key_exists('', $this->Access[$table][$id])) {
					$ret = $this->Access[$table][$id][''];
				}
			} else if(array_key_exists('0', $this->Access[$table])) {
				if(array_key_exists($right, $this->Access[$table]['0'])) {
					$ret = $this->Access[$table]['0'][$right];
				} else if(array_key_exists('', $this->Access[$table]['0'])) {
					$ret = $this->Access[$table]['0'][''];
				}
			}
		} else if(array_key_exists('', $this->Access)) {
			if(array_key_exists($id, $this->Access[''])) {
				if(array_key_exists($right, $this->Access[''][$id])) {
					$ret = $this->Access[''][$id][$right];
				} else if(array_key_exists('', $this->Access[''][$id])) {
					$ret = $this->Access[''][$id][''];
				}
			} else if(array_key_exists('0', $this->Access[''])) {
				if(array_key_exists($right, $this->Access['']['0'])) {
					$ret = $this->Access['']['0'][$right];
				} else if(array_key_exists('', $this->Access['']['0'])) {
					$ret = $this->Access['']['0'][''];
				}
			}
		}
		if($ret == 'Y') {
			return true;
		} else {
			return False;
		}
	}
	
	public static function addUser($inRequest, $inData) {
		
	}
	
	public static function removeUser($inRequest, $inData) {
		
	}
	
	public static function getUser($inRequest, $inData) {
		
	}
	
}