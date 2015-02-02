<?php /*************************************************************************
*  S.PHP5:                                         © M.G. Selivanovskikh, 2013 *
* charset: UTF-8                                                               *
* created: 2013.02.01                                                          *
*    path: \Data\Provider\PostgreSQL                                           *
*                                                                              *
*   PostgreSQL.                                                                *
*******************************************************************************/
namespace Data\Provider;
if(!defined('SOURCES')){Header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

class MySQL extends \Data\Base {
    
    protected $db;
	protected $persistent = TRUE;
    protected $_NowCreated;
    protected $_types = array(
		'blob'    => 'blob',
		'boolean' => 'char(1)',
		'integer' => 'integer',
		'bigint'  => 'integer',
		'char'    => 'char(1)',
		'varchar' => 'varchar(100)',
		'text'    => 'text',
		'float'   => 'float'
		
    );
    
    protected function /*void*/ construct($conf=null)
    {
        call_user_func_array('parent::construct',func_get_args());
        $this->table_quote = '';
        $this->column_quote = '`';
        $this->value_quote ='\'';
        $name = false;
        $host = '';
        $port = '3306';
        $user = '';
        $pass = '';
        if(is_array($conf))
        {
            if(array_key_exists('Data.Base.Name',$conf)) {
                $name = $conf['Data.Base.Name'];
            }
            if(array_key_exists('Data.Base.User',$conf)) {
                $user = $conf['Data.Base.User'];
            }
            if(array_key_exists('Data.Base.Password',$conf)) {
                $pass = $conf['Data.Base.Password'];
            }
            if(array_key_exists('Data.Base.Host',$conf)) {
                $host = $conf['Data.Base.Host'];
            }
            if(array_key_exists('Data.Base.Port',$conf)) {
                $port = (int) $conf['Data.Base.Port'];
            }
        }
        if(is_string($conf)) {
            $name = $conf;
        }
        if($name!=false) {
            $this->open($host,$port,$name,$user,$pass);
        } else {
            throw \System\ECore('params error');
        }
    }
	
    protected function destruct()
    {
		call_user_func_array('parent::destruct', array());
	}
	
    private function open($host,$port,$dbname,$user,$password)
    {
		if($this->persistent) {
			$this->db = mysql_connect($host,$user,$password);
		} else {
			$this->db = mysql_connect($host,$user,$password);
		}
		mysql_select_db($dbname);
	}
	
    protected function executeQuery($query, $params=NULL, $autoinc=NULL)
    {
		
		$query = $this->getQuery($query,$params);
		$query = str_replace('"', '`', $query);
		$result = mysql_query($query);
		if($autoinc !== NULL) {
			$this->InsertID = mysql_insert_id();
		}
		if(is_bool($result)) {
			if(!$result) {
				throw new \System\ECore(mysql_error());
			}
			return $result;
		} else {
			return new \Data\Result($this,$result);
        }
    }
	
    public function tables_exist($tables)
    {
		$cnt = 0;
		$tbs = '';
		if(is_array($tables)) {
			$cnt = count($tables);
			for($i=0;$i<$cnt;$i++) {
				if($i>0) {
					$tbs .= ', ';
				}
				$tbs .= '\''.$this->prefix.$tables[$i].'\'';
			}
		} else {
			throw new \System\ECore('Параметр "$tables" должен быть массивом.');
		}
		$query = 'SELECT count(*) FROM information_schema.tables where table_name in ('.$tbs.');';
		$query = $this->getQuery($query,null);
		$result = mysql_query($query);
		$row = mysql_fetch_row($result);
		if($row[0] == $cnt) {
			return TRUE;
		} else if($row[0] > 0) {
			return $row[0];
		} else {
			return FALSE;
		}
    }
    public function begin()
    {
        mysql_query('BEGIN;');
    }
    
    public function commit()
    {
		mysql_query('COMMIT;');
    }
    
    public function close()
    {
        mysql_close($this->db);
    }
    
    public function IsNowCreated()
    {
        return $this->_NowCreated;
    }
    
    public function getBaseType($name, $type)
    {
		if(array_key_exists($type,$this->_types)) {
			return str_replace('{name}', $name, $this->_types[$type]);
		} else {
			throw new \System\ECore('Неизвестный тип данных.');
		}
    }
	
    public function getQueryCreateTable($table)
    {
		$name = $table['name'];
		$columns = $table['struct'];
		$identity = NULL;
		$identity_set = FALSE;
		if(array_key_exists('identity', $table)) {
			if( ($table['identity'] != NULL) and (is_string($table['identity'])) ) {
				$identity = $table['identity'];
			}
		}

		if(count($columns)<1) {
			throw new \System\ECore('Таблица не может быть без столбцов.'); 
		}
		$sql = 'CREATE TABLE {'.$name.'} (';
		$first = true;
		foreach($columns as $column => $type) {
			if(!$first) {
				$sql .= ', ';
			} else {
				$first = false;
			}
			
			$sql .= $this->column_quote . $column . $this->column_quote;
			$sql .= ' ' . $this->getBaseType($column,$type);
			if($column == $identity) {
				$sql .= ' NOT NULL AUTO_INCREMENT';
				$identity_set = TRUE;
			}
		}
		if($identity_set) {
			$sql .= ', PRIMARY KEY  (`'.$identity.'`) ';
		}
		$sql .= ');';
		
		return $sql;
    }
	
    public function createTable($table) {
		$this->executeQuery($this->getQueryCreateTable($table));
	}
	
	public function nextval($table, $field)
	{
		return NULL;
	}

    public function getInsertID()
    {
		return $this->InsertID;
    }
	
    public function /*string*/ result_columnName(/*\Data\Result*/ $xResult, /*int*/ $column_number)
    {
        return mysql_field_name($xResult, $column_number);
    }
    
    public function /*int*/ result_columnType(/*\Data\Result*/ $xResult, /*int*/ $column_number)
    {
        return mysql_field_type($xResult, $column_number);
    }
    
	public function /*array*/ result_numRows(/*\Data\Result*/ $xResult)
    {
		return mysql_num_rows($xResult);
    }
	
    //Вернет FALSE если закончились строки
    public function /*array*/ result_fetchArray(/*\Data\Result*/ $xResult, $inAssoc = false)
    {
		if($inAssoc) {
			//pg_fetch_array
			return mysql_fetch_assoc($xResult);
		} else {
			return mysql_fetch_row($xResult);
		}
    }

    public function /*array*/ result_fetchValue(/*\Data\Result*/ $xResult)
    {
		if(mysql_num_rows($xResult)>0) {
			$a = mysql_fetch_row($xResult);
			return $a[0];
		} else {
			throw new \System\ECore('Запрос не вернул значение.'); 
		}
    }

}