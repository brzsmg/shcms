<?php /*************************************************************************
*    type: SRC.PHP5                                 © 2013 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
* created: 2013.02.01                                                          *
*    path: \Data\Provider\PostgreSQL                                           *
*******************************************************************************/
namespace Data\Provider;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

/**
 * Провайдер для СУБД PostgreSQL
 */
class PostgreSQL extends \Data\Base {
    
    protected $db;
	protected $persistent = TRUE;//TRUE;
    protected $_NowCreated;
    protected $_types = array(
		'blob'    => 'bytea',
		'boolean' => 'char(1)',
		'integer' => 'integer',
		'bigint'  => 'bigint',
		'char'    => 'char(1)',
		'varchar' => 'varchar(100)',
		'text'    => 'text',
		'float'   => 'numeric'
		
    );
    
    protected function /*void*/ construct($conf=null)
    {
        call_user_func_array('parent::construct',func_get_args());
        $name = false;
        $host = '';
        $port = '5432';
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
		$strconnect = 'host='.$host.' port='.$port.' dbname='.$dbname.' user='.$user.' password='.$password;
		if($this->persistent) {
			$this->db = pg_pconnect($strconnect);
		} else {
			$this->db = pg_connect($strconnect);
		}
		
	}
	
    protected function executeQuery($query, $params=NULL, $autoinc=NULL)
    {
		$query = $this->getQuery($query,$params);
		if($autoinc !== NULL) {
			//$query .= ' RETURNING "'.$id.'"';
		}
		//$query = str_replace('`', '\'', $query);
		$result = pg_query($this->db,$query);
		if($autoinc !== NULL) {
			if(array_key_exists($autoinc,$params)) {
				$this->InsertID = $params[$autoinc];
			}
		}
		if(is_bool($result)) {
			if(!$result) {
				throw new \System\ECore(pg_last_error());
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
		$result = pg_query($this->db,$query);
		$row = pg_fetch_row($result);
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
        pg_query($this->db,'BEGIN;');
    }
    
    public function commit()
    {
		pg_query($this->db,'COMMIT;');
    }
    
    public function close()
    {
        pg_close($this->db);
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
			$sql .= '"' . $column . '" ' . $this->getBaseType($column,$type);
		}
		$sql .= ');';
		return $sql;
    }
	
    public function createTable($table)
	{
		$this->executeQuery($this->getQueryCreateTable($table));
		if(array_key_exists('identity', $table)) {
			if( ($table['identity'] != NULL) and (is_string($table['identity'])) ) {
				$query = 'CREATE SEQUENCE '.$this->table_quote.$this->prefix;
				$query .= $table['name'].'_'.$table['identity'];
				$query .= $this->table_quote.' START 1';
				$this->executeQuery($query);
			}
		}
	}
	
	public function nextval($table, $field)
	{
		$query = 'SELECT nextval(\''.$this->table_quote.$this->prefix;
		$query .= $table.'_'.$field.$this->table_quote.'\')';
		$result = $this->executeQuery($query);
		$this->InsertID = $result->fetchValue();
		return $this->InsertID;
	}
	
    public function getInsertID()
    {
		return $this->InsertID;
    }
	
    public function result_numColumns(/*\Data\Result*/ $xResult)
    {
		return pg_num_fields($xResult);
    }
    public function /*string*/ result_columnName(/*\Data\Result*/ $xResult, /*int*/ $column_number)
    {
        return pg_field_name($xResult, $column_number);
    }
    
    public function /*int*/ result_columnType(/*\Data\Result*/ $xResult, /*int*/ $column_number)
    {
        return pg_field_type($xResult, $column_number);
    }
    
	public function /*array*/ result_numRows(/*\Data\Result*/ $xResult)
    {
		return pg_num_rows($xResult);
    }
	
    //Вернет FALSE если закончились строки
    public function /*array*/ result_fetchArray(/*\Data\Result*/ $xResult, $inAssoc = false)
    {
		if($inAssoc) {
			//pg_fetch_array
			return pg_fetch_assoc($xResult);
		} else {
			return pg_fetch_row($xResult);
		}
    }

    public function /*array*/ result_fetchValue(/*\Data\Result*/ $xResult)
    {
		if(pg_num_rows($xResult)>0) {
			$a = pg_fetch_row($xResult);
			return $a[0];
		} else {
			throw new \System\ECore('Запрос не вернул значение.'); 
		}
    }

}