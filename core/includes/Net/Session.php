<?php /*************************************************************************
*  M.PHP5:                                     © 2009-2014 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
* created: 2009.02.01                                                          *
*    path: \Net\Session                                                        * 
*******************************************************************************/
namespace Net;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

/**
 * Сессия клиента.
 */
class Session extends \System\Object
{
	protected static $ConnectionLimit = 0;
	protected static $ClientConnectionLimit = 0;
	
	protected /*Data\Base*/ $System; //База данных
    protected /*Data\Base*/ $Base; //База данных
	protected /*WebClient*/ $WebRequest        = NULL;
    protected /*WebClient*/ $WebClient         = NULL;      // Клиент
	
    protected /*String*/    $SID               = '';        // Идентификатор
    protected /*String*/    $CreateTime        = '';        // Время создания сесии
    protected /*String*/    $UpdateTime        = '';        // Время последнего изменения сесии
    protected /*String*/    $EnterTime         = '';        // Время последнего входа
    protected /*UInt*/      $UID               = 0;         // ID пользователя
	
	protected /*array*/     $Data  = array();
	
    protected function construct(\Cms\System $inSystem = NULL, \Net\WebRequest $inWebRequest = NULL)
    {
		call_user_func_array('parent::construct',func_get_args());
		$this->System = $inSystem;
		$this->Base = $this->System->GetBase();
		$this->WebRequest = $inWebRequest;
        $this->WebClient = $this->WebRequest->getClient();
        if($this->Base !== NULL) {
			$this->checkConnectionsLimit();
			$this->writeQuery();
			$this->identification();
			
			$query='SELECT "key", "value" FROM {sessions_data} WHERE sid = :sid';
			$result = $this->Base->execute($query, array('sid'=>$this->SID));
			$this->Data = array();
			while(($row = $result->fetchArray())!==False) {
				$this->Data[$row[0]]=$row[1];
			}
			
			if(!array_key_exists('device_type',$this->Data)) {
				$this->device_type = $this->WebClient->getBrowser()->Device_Type;
			}
		}
    }
    protected function destruct()
    {
		call_user_func_array('parent::destruct',array());
	}

	public /*Bool*/ function identification()
	{
		$data = FALSE;
		$exit = $this->WebRequest->GetParam('exit');
		dump($exit);
		$sid = $this->WebRequest->GetParam('sid');
		if($sid!==FALSE) {
			$query = 'SELECT create_date, update_date, sid, uid, cookie_date, auth_date FROM {sessions} WHERE sid = :sid';
			$result = $this->Base->query($query,array('sid'=>$sid));
			if($result->numRows()>0) {
				$data = $result->fetchArray(TRUE);
			} else {
				$sid = FALSE;
			}
		}
		$date = time();
		$uid = $this->System->getConfig('core', 'guest_id');
		$Year = $this->System->getConfig('core', 'session_time');
		$cookie_date = $date + $Year;
		$auth_date = $date + $Year;//TODO:getConfig
		if($sid === FALSE) {
			//Идентификатора нет, создаем Новый идентификатор сессии 
			$NewSID=addslashes(md5(rand(1000,9999).mtime().rand(1000,9999)));
			$query = 'INSERT INTO {sessions} VALUES (:create_date, :update_date, :sid, :uid, :cookie_date, :auth_date);';
			$result = $this->Base->query($query,
				array(
					'create_date' => $date,
					'update_date' => $date,
					'sid'         => $NewSID,
					'uid'         => $uid,
					'cookie_date' => $cookie_date,
					'auth_date'   => $auth_date
				)
			);
			$sid =$NewSID;
		} else {
			if(($data['auth_date'] > $date) and ($exit === NULL)) {
				$uid = $data['uid'];
			}
			$query = 'UPDATE {sessions} SET update_date = :update_date, uid = :uid, cookie_date = :cookie_date, auth_date = :auth_date WHERE sid = :sid ;';
			$result = $this->Base->query($query,
				array(
					'sid'         => $sid,
					'update_date' => $date,
					'uid'         => $uid,
					'cookie_date' => $cookie_date,
					'auth_date'   => $auth_date
				)
			);
		}
		$this->SID = $sid;
		$this->UID = $uid;
		$this->WebRequest->SetCOOKIE('sid', $sid, $cookie_date);
	}

	public function setUID($inUID)
	{
		$this->UID = $inUID;
		$query = 'UPDATE {sessions} SET uid = :uid WHERE sid = :sid ;';
		$result = $this->Base->query($query,
			array(
				'sid'         => $this->SID,
				'uid'         => $this->UID
			)
		);
	}
	
	public static function setConnectionLimit($inLimit)
    {
        Session::$ConnectionLimit = $inLimit;
    }
    
    public static function setClientConnectionLimit($inLimit)
    {
        Session::$ClientConnectionLimit = $inLimit;
    }
    
    protected function checkConnectionsLimit()
    {
        if(Session::$ConnectionLimit != FALSE)
        {
            $query = 'SELECT count(*) FROM {queries} WHERE "date" > :date';
            $r = $this->Base->execute($query, array('date'=>time()-1));
            $d = $r->fetchArray();
            //var_dump($d);exit;
            if($d[0]>Session::$ConnectionLimit) {
                throw new \Cms\ELimit('Too many connections.');
            }
        }
        
        if(Session::$ClientConnectionLimit != FALSE)
        {
            $query = 'SELECT count(*) FROM {queries} WHERE ip = :ip and "date" > :date;';
            $r = $this->Base->execute($query,array('ip'=>$this->WebClient->GetAddress(),'date'=>time()-1));
            $d = $r->fetchArray();
            if($d[0]>Session::$ClientConnectionLimit) {
                throw new \Cms\ELimit('Too many connections.');
            }
        }
    }
    
    protected function writeQuery()
    {
        $query = 'INSERT INTO {queries}(date, ip, query, user_agent) VALUES(:date, :ip, :query, :user_agent);';
        $this->Base->begin();
        $this->Base->execute($query, array(
          'date'       => time(),
          'ip'         => $this->WebClient->GetAddress(),
          'query'      => $this->WebRequest->GetQuery(),
          'user_agent' => $this->WebClient->GetAgent()
        ));
        $this->Base->commit();
    }
	
	//public /*Void*/ function Update(/*Void*/)
	/*{
		global $mdl;
		$SessionData = $mdl['users']->SelectSession($this->FSID);
		$this->FCreateTime  = $SessionData['create_time'];
		$this->FUpdateTime  = $SessionData['update_time'];
		$this->FEnterTime   = $SessionData['enter_time'];
		$this->FUID         = $SessionData['user_id'];
		$this->FUser        = false;
		unset($SessionData);
	}*/
	
	public /*String*/ function getSID(/*Void*/)
	{
		return $this->SID;
	}
	
	public /*UInt*/ function getUID(/*Void*/)
	{
		return $this->UID;
	}
	
	public function __get($field)
	{
		if(array_key_exists($field,$this->Data)) {
			return $this->Data[$field];
		} else {
			return NULL;
		}
	}
	
	public function __set($field,$value)
	{
		if(array_key_exists($field,$this->Data)) {
			$query='UPDATE {sessions_data} SET "value" = :value WHERE "sid" = :sid and "key" = :key';
			$result = $this->Base->execute($query, array(
				'sid'   => $this->SID,
				'key'   => $field,
				'value' => $value
			));
		} else {
			$query='INSERT INTO {sessions_data} VALUES(:sid, :key, :value)';
			$result = $this->Base->execute($query, array(
				'sid'   => $this->SID,
				'key'   => $field,
				'value' => $value
			));
		}
		$this->Data[$field] = $value;
	}
	
	/**
	 * Тип устройства, вычесленный при создании сессии
	 */
	public /*String*/ function getDeviceType(/*Void*/)
	{
		return $this->DeviceType;
	}
}