<?php /************************************************************************
* M.PHP5: \Types\Checker                                     © 2009-2013 Javof *
*                                                                              *
*   Класс проверки значений и типов.                                           *
*******************************************************************************/
namespace Types;
if(!defined('SOURCES')){Header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

class Checker extends \System\Object{
    function /*int*/ intlen(/*int*/ $i)
    {
        return strlen((string)$i);
    }
    function /*bool*/ int(/*int*/ $i, /*bool*/ $un=false, /*int*/ $len=false){  // Проверяет целые числа
        if( ! is_int($i) ){
            return false;
        }
        if(($un==true)and($i<0)){
            return false;
        }
        if($len===false){
            return true;
        }
        if(intlen($i)>$len){
            return false;
        }
        return true;
    }
    function /*bool*/ str(/*string*/ $str, $len=false){ // Проверяет длину строки
        if( ! is_string($str) ){
            return false;
        }
        if($len===false){
            return true;
        }
        if( strlen($str) > (int)$len ){
            return false;
        }else{
            return true;
        }
    }
  
    function /*bool*/ name(/*string*/ $str,$len=100){
        if( ! is_string($str) ){
            return false;
        }
        if (!preg_match('/^[a-z0-9]{1,'.$len.'}$/i', $str)){
            return false;
        }
        return true;
    }
    function /*bool*/ culture(/*string*/ $str){
        if (!preg_match('/^(ru|en)$/i', $str)){
            return false;
        }
        return true;
    }
    function /*bool*/ bool_true(/*string*/ $str){
      if (!preg_match('/^(true|yes|on|1)$/i', $str)){
          return false;
      }
      return true;
    }
    function /*bool*/ pathname(/*string*/ $str){
      if (!preg_match('/^[a-z0-9]$|[a-z0-9\/\\\\]{1,512}[a-z0-9]$/i', $str,$m)){ // Пропускает не все доступные символы
          return false; 
      }
      return true;
    }
    function /*bool*/ email(/*string*/ $str){ //Проверяет Email адреса
      if (!preg_match("/^([a-z0-9_\.-]+)@([a-z0-9_\.-]+)\.([a-z\.]{2,6})$/", $str)){//\i
          return false; 
      }
      return true;
    }
    function /*bool*/ fsname(/*string*/ $str){
      if (!preg_match('/^[a-z0-9\._-]{1,100}\$/', $str)){ // Пропускает не все доступные символы   //TODO: error \$
          return false;
      }else{
          return true;
      }
      return true;
    }
    function /*bool*/ dbname(/*string*/ $str){ // Проверяет имена в Базах данных
        if (!preg_match("/^[a-z0-9_]{2,50}\$/", $str)){  //TODO: error \$
            return false;
        }else{
            return true;
        }
        return true;
    }                 
    function /*bool*/ site(/*string*/ $str){ //Проверяет URL
        if(!preg_match("/^((http://)|(https://))((([a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z;]{2,3}))|(([0-9]{1,3}\.){3}([0-9]{1,3})))((/|\?)[a-z0-9~#%&'_\+=:;\?\.-]*)*)\$\i", $str)){     //TODO: error \$
            return false;
        }else{
            return true;
        }
    }
}
/***************************************************************************/ ?>