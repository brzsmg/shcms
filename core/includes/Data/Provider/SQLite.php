<?php /*************************************************************************
*  S.PHP5:                                         © M.G. Selivanovskikh, 2013 *
* charset: UTF-8                                                               *
* created: 2013.02.01                                                          *
*    path: \Data\Provider\SQLite                                               * 
*                                                                              *
*   SQLite.                                                                    *
*******************************************************************************/
namespace Data\Provider;
echo 'Файл '._FILE_.'требует коректировки';exit;
if(!defined('SOURCES')){Header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

class SQLite extends \Data\Base {
    
    protected $db;
    protected $_NowCreated;
    
    protected function /*void*/ construct($conf=null)
    {
        call_user_func_array('parent::construct',func_get_args());
        $name = false;
        $pass = '';
        if(is_array($conf))
        {
            if(array_key_exists('Data.Base.Name',$conf))
            {
                $name = $conf['Data.Base.Name'];
            }
            if(array_key_exists('Data.Base.Password',$conf))
            {
                $pass = $conf['Data.Base.Password'];
            }
        }
        if(is_string($conf))
        {
            $name = $conf;
        }
        if($name!=false)
        {
            $this->open($name,$pass);
        }
        else
        {
            throw \System\ECore('params error');
        }
    }
	
    protected function destruct()
    {
		call_user_func_array('parent::destruct', array());
	}
	
    protected function open($file_path,$pass)
    {
        if(file_exists($file_path)){
            $this->_NowCreated = false;
            $this->db = new \SQLite3($file_path,SQLITE3_OPEN_READWRITE,$pass);
        }else{
            $this->_NowCreated = true;
            $this->db = new \SQLite3($file_path,SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE,$pass);
        }
        $this->db->busyTimeout(5000);
        $this->db->exec('PRAGMA journal_mode=WAL;');
    }
    
    public function execute($query,$params=null)
    {
		$query = $this->getQuery($query,$params);
        return new \Data\Result($this, $this->db->query($query));
    }
    
	public function tables_exist($tables)
    {
		$cnt = 0;
		$tbs = '';
		if(is_array($tables))
		{
			$cnt = count($tables);
			for($i=0;$i<$cnt;$i++)
			{
				if($i>0)
				{
					$tbs .= ', ';
				}
				$tbs .= '{'.$tables[$i].'}';
			}
		}
		else
		{
			throw new \System\ECore('Параметр "$tables" должен быть массивом.');
		}
		$query = 'SELECT count(*) FROM sqlite_master where type = \'table\' and tbl_name in ('.$tbs.');';
		$query = $this->getQuery($query,null);
		$result = $this->db->query($query);
		$row = $result->fetchArray(SQLITE3_NUM);
		if($row[0]==$cnt)
		{
			return true;
		}
		else
		{
			return false;
		}
		//select * from sqlite_master where type = 'table' and tbl_name = 'abc'
    }
    
    public function begin()
    {
        $this->db->query('BEGIN IMMEDIATE;');
    }
    
    public function commit()
    {
        $this->db->query('COMMIT;');
    }
    
    public function close(){
        $this->db->close();
    }
    
    public function IsNowCreated(){
        return $this->_NowCreated;
    }
    
    public function getBaseType($name, $type)
    {
		throw new \System\ECore('В SQLite не используются типы.');
    }
    
    public function getQueryCreateTable($name,$columns)
    {
		if(count($columns)<1)
		{
			throw new \System\ECore('Таблица не может быть без столбцов.'); 
		}
		$sql = 'CREATE TABLE {'.$name.'} (';
		$first = true;
		foreach($columns as $column => $type)
		{
			if(!$first)
			{
				$sql .= ', ';
			}
			else
			{
				$first = false;
			}
			$sql .= '"' . $column . '"';
		}
		$sql .= ');';
		return $sql;
    }
    
    public function result_numColumns(/*\Data\Result*/ $xResult)
    {
		return $xResult->numColumns();
    }
    
	public function /*string*/ result_columnName(/*\Data\Result*/ $xResult, /*int*/ $column_number)
    {
        return $xResult->columnName($column_number);
    }
    
    public function /*int*/ result_columnType(/*\Data\Result*/ $xResult, /*int*/ $column_number)
    {
        return $xResult->columnType($column_number);
    }
    
	public function /*array*/ result_numRows(/*\Data\Result*/ $xResult)
    {
		//Source: http://php.net/manual/ru/class.sqlite3result.php
		if ($xResult->numColumns() && $xResult->columnType(0) != SQLITE3_NULL) {
			//$xResult->numRows();//Этого метода нету
			$cnt = 0;
			$this->FResult->reset();
			while( $xResult->fetchArray() != false )
			{
				$cnt++;
			}
			$xResult->reset();
			return $cnt;
        }
        else
        {
			return 0;
        }
    }
    
	public function /*array*/ result_fetchArray(/*\Data\Result*/ $xResult, $inAssoc = false)
    {
		if($inAssoc)
		{
			return $xResult->fetchArray(SQLITE3_ASSOC);
		}
		else
		{
			return $xResult->fetchArray(SQLITE3_NUM);
        }
    }
    
    public function /*array*/ result_fetchValue(/*\Data\Result*/ $xResult)
    {
		if($xResult->numRows() > 0)
		{
			$a = $xResult->fetchArray(SQLITE3_NUM);
			return $a[0];
		}
		else
		{
			throw new \System\ECore('Запрос не вернул значение.'); 
		}
    }
}

?>