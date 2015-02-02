<?php /*************************************************************************
*    type: SRC.PHP5                                © M.G. Selivanovskikh, 2013 *
* charset: UTF-8                                                               *
* created: 2013.02.01                                                          *
*    path: \Data\Config                                                        * 
*                                                                              *
*   Конфигурация из фалйа.                                                     *
*******************************************************************************/
namespace Data;
if(!defined('SOURCES')){Header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

class Config extends \System\MemoryObject
{
    protected $_data;
    protected function construct($file = '')
	{
        call_user_func_array('parent::construct',func_get_args());
        $type=strrpos($file,'.');
        $type=substr($file,$type+1);
        if($type=='php') {
            if(!file_exists($file)) {
                throw new \System\ECore('File no found.');
            }
            include $file;
            if(!isset($data)) {
                throw new \System\ECore('Data no found.');
            }
            $this->_data = $data;
            unset($data);
        } else {
            throw new \System\ECore(sprintf('Config type "%s" unknown.',$type));
        }
    }
	
    protected function destruct()
    {
		call_user_func_array('parent::destruct', array());
	}
	
    public function getValue($key, $def = 'F_DEF')
	{
        if(!array_key_exist($key,$this->_data)) {
            if($def=='F_DEF') {
                throw new \System\ECore('Key no found.');
            }
            return $def;
        }
        return $this->_data[$key];
    }
    public /*mix*/function getArray()
	{
        return $this->_data;
    }
}