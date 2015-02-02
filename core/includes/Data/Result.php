<?php /*************************************************************************
*  S.PHP5:                                         © M.G. Selivanovskikh, 2013 *
* charset: UTF-8                                                               *
* created: 2013.02.01                                                          *
*    path: \Data\Result                                                        * 
*                                                                              *
*   Результат запроса.                                                         *
*******************************************************************************/
namespace Data;
if(!defined('SOURCES')){Header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

class Result extends \System\Object{
	protected $FProvider;
    protected $FResult;
    
    protected function construct($xProvider = null, $xResult = null){
		call_user_func_array('parent::construct',func_get_args());
		$this->FProvider = $xProvider;
        $this->FResult = $xResult;
    }
	
    protected function destruct()
    {
		call_user_func_array('parent::destruct', array());
	}
	
	public function /*int*/ getInserID(/*void*/)
    {
        return $this->FProvider->result_getInsertID($FResult);
    }
	
    public function /*int*/ numColumns(/*void*/)
    {
        return $this->FProvider->result_numColumns($FResult);
    }
    
    public function /*string*/ columnName(/*int*/ $column_number)
    {
        return $this->FResult->columnName($column_number);
    }
    
    public function /*int*/ columnType(/*int*/ $column_number)
    {
        return $this->FResult->columnType($column_number);
    }
	
    //Вернет FALSE если закончились строки
    public function /*array*/ fetchArray(/*bool*/ $inAssoc = false)
    {
		return $this->FProvider->result_fetchArray($this->FResult, $inAssoc);
    }
    
    public function /*array*/ fetchValue(/*void*/)
    {
		return $this->FProvider->result_fetchValue($this->FResult);
    }
    
    public function /*array*/ numRows(/*void*/)
    {
        return $this->FProvider->result_numRows($this->FResult);
    }
    
    public function /*bool*/ IsNotNull(/*void*/)
    {
        if ($this->numColumns() && $this->FResult->columnType(0) != SQLITE3_NULL) 
        { 
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function /*bool*/ finalize ( /*void*/ )
    {
        return $this->FResult->finalize();
    }
    
    public function /*bool*/ reset ( /*void*/ )
    {
        return $this->FResult->reset();
    }

}