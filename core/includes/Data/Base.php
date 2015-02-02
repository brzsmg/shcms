<?php /*************************************************************************
*    type: SRC.PHP5                                 © 2013 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
* created: 2013.02.01                                                          *
*    path: \Data\Base                                                          * 
*******************************************************************************/
namespace Data;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

/**
 * База данных.
 */
class Base extends \System\Object
{
    /*public $type;          // Тип базыданных
    public $host;          // Хост c базойданных
    public $port;          // Порт c базойданных
    public $path;          // Сокет c базойданных
    public $user;          // Имя пользователя базыданных
    public $password;      // Пароль пользователя базыданных
    public $dbname;        // Имя БазыДанных
    public $tables;        // Массив имен таблиц
    public $link;          // Главная ссылка на соединение с базойданных
    public $prefix;        // Префикс таблиц
    public $conected;      // Установлено ли соединение
    */
    protected $table_quote = '"';
    protected $column_quote = '\'';
    protected $value_quote = '\'';
    protected $prefix;
	protected $writelog = TRUE;
	protected $InsertID;
//# Конструкторы #//
    protected function construct($conf=NULL)
    {
        call_user_func_array('parent::construct',func_get_args());
        if(array_key_exists('Data.Base.Table.Prefix',$conf)) {
            $this->prefix = $conf['Data.Base.Table.Prefix'];
        }
    }
	
    protected function destruct()
    {
		call_user_func_array('parent::destruct', array());
	}
	
//# Методы #//
	public function enableLog($enable = TRUE)
	{
		if($enable) {
			$this->writelog = TRUE;
		} else {
			$this->writelog = FALSE;
		}
	}
	
	/**
	 * Синоним метода execute
	 */
    public function query($query, $params=NULL)
    {
		if($this->writelog) {
			\System\Console::info('Execute query: '.$query);
		}
		return $this->executeQuery($query, $params);
    }
	
    public function execute($query, $params=NULL, $id=NULL)
    {
		if($this->writelog) {
			\System\Console::info('Execute query: '.$query);
		}
        return $this->executeQuery($query, $params, $id);
    }
	
    protected function executeQuery($query, $params=NULL, $id=NULL)
    {
        throw new \System\ECore('abstract function');
    }
	
    public function tables_exist($tables)
    {
		throw new \System\ECore('abstract function');
    }
	
    public function begin()
    {
        throw new \System\ECore('abstract function');
    }
    
    public function commit()
    {
		throw new \System\ECore('abstract function');
    }
    
    public function close(){
        throw new \System\ECore('abstract function');
    }
    /*preparation query*/
    public function getQuery($query, $params=NULL)
    {
        if(!is_string($query)){
            throw new \System\ECore('is not string');
        }
        $query = preg_replace(
			'/{([^}]+)}/',
			$this->table_quote.$this->prefix.'$1'.$this->table_quote,
			$query);
        if($params!==NULL){
            if(!is_array($params)){
                throw new \System\ECore('is not array');
            }
            foreach($params as $key=>$value){
                //addslashes
				if($value !== NULL){
					$value = str_replace('\\','\\\\',$value);
					$value = str_replace('\'','\\\'',$value);
					$value = str_replace(':',':\\\\',$value);
					$query = str_replace(
						':'.$key,
						$this->value_quote.$value.$this->value_quote,
						$query
					);
				} else {
					$query = str_replace(':'.$key, 'NULL', $query);
				}
            }
			$query = str_replace(':\\\\',':',$query);
        }
        return $query;
    }
    
    public static function getBase($config)
    {
        if(!array_key_exists('Data.Base.Type',$config)) {
            throw new \System\ECore('Data.Base.Type no found');
        }
        $class='\\Data\\Provider\\'.$config['Data.Base.Type'];
        if(!class_exists($class)) {
            throw new \System\ECore('Provider Class no found');
        } else {
            return new $class($config);
        }
    }

}