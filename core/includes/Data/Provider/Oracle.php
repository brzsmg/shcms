<?php /*************************************************************************
*  S.PHP5:                                          © 2013 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
* created: 2013.02.01                                                          *
*    path: \Data\Provider\Oracle                                               *
*                                                                              *
*   Провайдер для базы Oracle.                                                 *
*******************************************************************************/
namespace Data\Provider;
echo 'Файл '._FILE_.'требует коректировки';exit;
if(!defined('SOURCES')){Header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

class Oracle extends \Data\Base {
    
    protected $db;
    protected $_types = array(
		'blob'    => 'blob',
		'boolean' => 'VARCHAR(1) CHECK ({name} IN (\'Y\',\'N\'))',
		'integer' => 'integer',
		'bigint'  => 'integer',
		'varchar' => 'varchar(100)',
		'text'    => 'text',
		'float'   => 'float'
		
    );
    
	protected function construct($inParam = 0)
	{
		call_user_func_array('parent::construct',func_get_args());
		throw new \System\ECore('Метод не реализован');
	}
	
    protected function destruct()
    {
		call_user_func_array('parent::destruct', array());
	}
	
    private function open($host,$port,$dbname,$user,$password)
    {
		throw new \System\ECore('Метод не реализован');
    }
    public function execute($query, $params=null)
    {
        throw new \System\ECore('Метод не реализован');
    }
    public function tables_exist($tables)
    {
		throw new \System\ECore('Метод не реализован');
    }
    public function begin()
    {
        throw new \System\ECore('Метод не реализован');
    }
    
    public function commit()
    {
		throw new \System\ECore('Метод не реализован');
    }
    
    public function close()
    {
        throw new \System\ECore('Метод не реализован');
    }
    
    public function IsNowCreated()
    {
        throw new \System\ECore('Метод не реализован');
    }
    
    public function getBaseType($name, $type)
    {
		throw new \System\ECore('Метод не реализован');
    }
    public function getQueryCreateTable($name,$columns)
    {
		throw new \System\ECore('Метод не реализован');
    }
    public function result_numColumns(/*\Data\Result*/ $xResult)
    {
		throw new \System\ECore('Метод не реализован');
    }
    public function /*string*/ result_columnName(/*\Data\Result*/ $xResult, /*int*/ $column_number)
    {
        throw new \System\ECore('Метод не реализован');
    }
    
    public function /*int*/ result_columnType(/*\Data\Result*/ $xResult, /*int*/ $column_number)
    {
        throw new \System\ECore('Метод не реализован');
    }
    
	public function /*array*/ result_numRows(/*\Data\Result*/ $xResult)
    {
		throw new \System\ECore('Метод не реализован');
    }
	
    //Вернет FALSE если закончились строки
    public function /*array*/ result_fetchArray(/*\Data\Result*/ $xResult, $inAssoc = false)
    {
		throw new \System\ECore('Метод не реализован');
    }

    public function /*array*/ result_fetchValue(/*\Data\Result*/ $xResult)
    {
		throw new \System\ECore('Метод не реализован');
    }

}