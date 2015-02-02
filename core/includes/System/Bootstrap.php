<?php /*************************************************************************
*    type: M.PHP5                              © 2009-2014 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
*    path: \System\bootstrap                                                   *
*                                                                              *
*   Ядро, проверяет PHP, подготавливает среду для скриптов использующих классы *
* из директории sources. Позволяет выполниться без ошибок в старых версиях PHP *
* и при отсутствии необходимого функционала. Сопроваждает весь запрос.         *
*    Обязательные для работы классы:                                           *
*      %sources%/system/Exceptions.php                                         *
*      %sources%/system/MemoryObject.php                                       *
*      %sources%/system/Object.php                                             *
*******************************************************************************/
error_reporting(E_ALL);  //Любые ошибки иcключены
/*******************************************************************************
*   Дерективы                                                                  *
*******************************************************************************/
if(!defined('ROOT')){
	exit;
}
if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}
if(!defined('CORE')){
	define('CORE',ROOT.DS.'core');
}
if(!defined('SEM')){
	define('SEM',ROOT.DS.'cache'.DS.'sem');
}
if(!defined('SOURCES')){
	define('SOURCES',CORE.DS.'includes');
}
if(!defined('MODULES')){
	define('MODULES',ROOT.DS.'modules');
}
if(!defined('DATA')){
	define('DATA',getcwd().DS.'data');
}
if(!defined('DEBUG')){
	define('DEBUG', FALSE);  // Включение/отключение отладки(безопасность)
}
/*******************************************************************************
*   Черный список                                                              *
*******************************************************************************/
$file_name=ROOT.DS.'data'.DS.'blacklist.php';
if(file_exists($file_name)) {
	include $file_name;
	if(array_search(getenv('REMOTE_ADDR'),$data)!==FALSE) {
		header('HTTP/1.0 403 NO ACCESS');
		exit;  //Клиент заблокирован
	}
	unset($data);
}
unset($file_name);
/*******************************************************************************
*   ГЛОБАЛЬНЫЕ ПЕРЕМЕННЫЕ                                                      *
*                                                                              *         
*   Все глобальные переменные содержатся в структуре $_.                       *
*******************************************************************************/
/*global*/ /*mix*/ $_ = array(
	'Exception'      => TRUE,          // Включить исключения
	'min_phpv'       => '5.3.0',       // Минимальная версия PHP, для работы
	'max_phpv'       => '6.0.0',       // Максимальная версия PHP, для работы
	'autor'          => 'Selivanovskikh M.G.', // Коопирайты
	'email'          => 'javof@ya.ru', // Коопирайты
	'name'           => 'SHCMS',       // Коопирайты
	'exp_php'        => '.php',        // Расширение файлов PHP (с точкой)
	'version'        => '2.2',         // Версия движка
	'exit'           => TRUE,          // Завершать процесс
	'echo'           => TRUE,          // Запретить вывод клиенту
	'log'            => TRUE,          // Вести лог в режиме отладки
	'log_to_file'    => FALSE,         // Писать лог в файл
	'start_mtime'    => mtime(),
	'start_time'     => (
		(isset($_SERVER)and(array_key_exists('REQUEST_TIME',$_SERVER)))
		?
		$_SERVER['REQUEST_TIME']
		:
		time()
	),
	'total_time'            => 0,
	'error_reporting'       => FALSE,
	'ExceptionLoad'         => FALSE,
	'old_error_handler'     => 0,
	'old_exception_handler' => 0,
	'datalog'               => array(),
	'modules'               => array(),
	'path'        =>        array(
		'bootstrap' => __FILE__,          // этот файл
		'log'     => ROOT.DS.'log.xls',  // Лог выполнения
		'data'    => ROOT.DS.'data'
	),
	'_'                     => NULL,
	'autoload'              => array(
		'PHPExcel' => array('PHPExcel_Autoloader', 'Load')
	),
	'error_types'       =>        array(    //Масив типов ошибок,
		  '1'  => 'E_ERROR',
		  '2'  => 'E_WARNING',
		  '4'  => 'E_PARSE',
		  '8'  => 'E_NOTICE',
		 '16'  => 'E_CORE_ERROR',
		 '32'  => 'E_CORE_WARNING',
		 '64'  => 'E_COMPILE_ERROR',
		'128'  => 'E_COMPILE_WARNING',
		'256'  => 'E_USER_ERROR',
		'512'  => 'E_USER_WARNING',
	   '1024'  => 'E_USER_NOTICE',
	   '2048'  => 'E_STRICT',                             
	   '4096'  => 'E_RECOVERABLE_ERROR',
	   '8192'  => 'E_DEPRECATED',
	  '16384'  => 'E_USER_DEPRECATED',
	  '30719'  => 'E_ALL'
	),
	'msgshow'         =>        array(
		'message'     =>        '',       //Содержимое сообщения
		'dbgstr'      =>        '',       //Содержимое отладочного сообщения
		'dump'        =>        array(),  
		'var'         =>        array(),  //?
		'info'        =>        array(),  //Информация об ошибке
		'trace'       =>        array(),  //стек вызовов
	),
	'str'        =>        array(
		'ENGINE'            =>        'System',
		'HOME'              =>        'Home',
		'AUTOR'             =>        'By',
		'EMAIL'             =>        'E-mail',
		'ERROR'             =>        'ERROR',
		'DEBUG'             =>        'DEBUG',    
		'ERROR_MESSAGE'     =>        'An error has occurred, the details can be seen in debug mode.',
		'INFO_MESSAGE'      =>        'Message Info.',    
		'INFO'              =>        'Information',
		'DEBUG_SHOW'        =>        'This message is displayed in debug mode. When you publish a site, you disable this option for security.',
		'ERROR_SEVERITY'    =>        'Severity',
		'ERROR_LINE'        =>        'Error on line',
		'ERROR_RUNTIME'     =>        'Usage time',
		'ERROR_FILE'        =>        'Error in file',
		'ERROR_CONTEXT'     =>        'Context',
		'CLASS_NAME'        =>        'Class',
		'EXCEPTION_NAME'    =>        'Exception',
		'PARENT_CLASS_NAME'        =>       'Parent class',
		'MODUL_NAME'               =>       'Modul name',
		'HIDE_DETAIL_ERROR'        =>       'Hide details of the problem',
		'SHOW_DETAIL_ERROR'        =>       'Show details of the problem',
		'ERROR_CLASS_NO_FOUND'     =>       'Class "%1$s" no found. File "%2$s".',
		'ERROR_FUNCTION_NOT_DEFINED'  =>    'Function "<u>%1$s()</u>" is not defined.',
		'ERROR_VARIABLE_NOT_DEFINED'  =>    'Variable "<u>$%1$s</u>" is not defined.',
		'ERROR_PHP_VERSION'           =>    'Version "<i>%1$s</i>" PHP are not supported.',
		'ERROR_METHOD_NOT_DEFINED'    =>    'Invoke a method of "<u>%1$s()</u>" is not defined.',
		'ERROR_PROPERTY_NOT_DEFINED'  =>    'Required property "<u>%1$s</u>" is not defined.',
		'ERROR_INI_NO_FOUND'          =>    'Configuration file "<u>%1$s</u>" not found.',
		'ERROR_FILE_NO_FOUND'         =>    'File "<u>%1$s</u>" not found.',
		'ERROR_DIR_NO_FOUND'          =>    'Dir "<u>%1$s</u>" not found.',
		'MEMORY_USE'                  =>    'Memory use',
		'MEMORY_BT'                   =>    '%1$s byte',
		'MEMORY_KB'                   =>    '%1$s KB',
		'MEMORY_MB'                   =>    '%1$s MB',
		'MEMORY_GB'                   =>    '%1$s GB',
		'null'        =>        'null'
	),
	//Используемые функции PHP
	'used_functions'        =>        array(
		'set_error_handler',
		'sprintf',
		'addslashes',
		'ini_set',
		'file_exists',
		'user_error',
		'sprintf',
		'count',
		'array_key_exists',
		'register_shutdown_function',
		'register_tick_function',
		'gmdate',
		'header',
		'mtime',
		'rand',
		'class_exists',
		'memory_get_usage',
		'get_class'
	), // Сюда не входят isset(),unset(), echo, array(), это конструкции языка.
	// Используемые глобальные переменные PHP
	'used_variables'        =>        array(
		//'_SERVER',  // Массив(Может отсутствовать)
		'_COOKIE',  // Массив информации о Cookes
		'_FILES',   // Массив информации о Файле
		'_POST',    // Массив информации о переменных переданых в теле запроса
		'_GET'      // Массив информации о переменных переданых в адресе запроса
	)
);

/*******************************************************************************
*   ГЛОБАЛЬНЫЕ ФУНКЦИИ                                                         *
*******************************************************************************/

/**
 * Функция для отладки переменной
 */
function /*void*/ dump(/*string*/ $inData = '', $file = '')
{
	global $_;
	if((is_string($inData))and($inData == '')) {
		$_['msgshow']['dump'][] = $file.'<br/>Empty data';
	} else if((is_string($inData))or(is_int($inData))) {
		$_['msgshow']['dump'][] = $file.'<br/>'.$inData;
	} else {
		$_['msgshow']['dump'][] = $file.'<br/><pre>'.str_replace("\x0A",'</pre><br/><pre>',print_r($inData,true)).'</pre>';
	}
	//msgshow(TRUE);
}

/**
 * Возвращает серьезность ошибки строкой
 */
function /*string*/ getSeverity($severity)
{
	global $_;
    if(array_key_exists($severity,$_['error_types'])) {
		return $_['error_types'][$severity];
    } else {
		return 'E_UNKNOWN';  //Ошибка не определена, новая версия PHP
    }
}

/**
 * Функция возвращает текущее время в микросекундах
 */
function /*string*/ mtime(/*void*/)
{
	$vtime = explode(" ",microtime());
	return $vtime[1] + $vtime[0];
}

/**
 * Функция возвращает разницу заданого времени с текущим
 */
function /*string*/ total_time(/*string*/ $value)
{
	$vtime = explode(" ",microtime());
	return ($vtime[1] + $vtime[0])-$value;
}

/**
 * Функция правит разделители директорий
 */
function path($path)
{
    if(DS=='/') {
        return str_replace('\\','/',$path);
    } else {
        return str_replace('/','\\',$path);
    }
}

/**
 * Функция для GetText
 */
 if(function_exists('_')) {
	putenv('LC_ALL=ru_RU');
	setlocale(LC_ALL, 'ru_RU.UTF-8');
	bindtextdomain('core', CORE.DS.'locale');
	textdomain("core");
} else {
	function /*string*/ _(/*string*/ $str='', $n=null)
	{
		global $_;
		if($_['_'] != NULL) {
			return $_['_']($str, $n);
		} else {
			return $str;
		}
	}
}

/**
 * Семафоры
 */
if ( !function_exists('sem_get') ) {
    function sem_get($key) { return fopen(SEM.DS.$key.'.sem', 'w+'); } 
    function sem_acquire($sem_id) { return flock($sem_id, LOCK_EX); } 
    function sem_release($sem_id) { return flock($sem_id, LOCK_UN); } 
}

/**
 * Добавляет события в лог
 */
function /*void*/ _log(/*string*/ $value, /*string*/ $type = 'info')
{
	global $_;
	if(DEBUG and($_['log'])) {
		$_['datalog'][]=array(mtime(),$type,$value);
	}
}

/**
 * Функция возвращает случайный хеш код md5
 */
function /*string*/ randhash(/*void*/)
{
	return md5(rand(1000,9999).mtime());//Псевдослучайное число + время
}

/**
 * Функция конвертирует количество байт в строку
 */
function /*string*/ SizeToStr(/*int*/ $size){
  global $_;
  if($size>=1024) {
    $size=$size/1024;
    if($size>=1024) {
      $size=$size/1024;
      if($size>=1024) {
        $size=$size/1024;
        return sprintf(_($_['str']['MEMORY_GB']),round($size,2));
      } else {
        return sprintf(_($_['str']['MEMORY_MB']),round($size,2));
      }
    } else {
      return sprintf(_($_['str']['MEMORY_KB']),round($size,2));
    }
  }else{
    return sprintf(_($_['str']['MEMORY_BT']),round($size,0));
  }
}

/**
 * Запись данных для сообщения
 */
function /*void*/ write_msgshow(/*string*/ $name, /*string*/ $value){
	global $_;
	if($name=='message'){
		$_['msgshow']['message']=$value;
	}else{
		$_['msgshow']['info'][$name]=array($_['str'][$name],$value);
	}
}

/**
 * Вывод сообщения
 */
function /*void*/ msgshow(/*bool*/ $info = FALSE, /*bool*/ $nosend = FALSE){        
//function /*void*/ show_error(/*void*/){    
  global $_;
  /*string*/ $show='';
  if(!$nosend){
  $show.='<!DOCTYPE html>'.
         '<html>'."\n".
         '<head>'."\n".
         '  <!-- HeaderEdit -->'."\n".
         '    <meta charset="UTF-8" />'."\n".
         '    <meta http-equiv="X-UA-Compatible" content="IE=edge" />'."\n".
         ''."\n".
         '    <title>'._($_['str']['ENGINE']).'</title>'."\n".
         '  <!-- Meta -->'."\n".
         '    <meta name="autor" content="Javof"><!-- mailto:javof@mail.ru -->'."\n".
         '    <meta name="generator" content="NotePad">'."\n".
         '    <meta name="robots" content="none">'."\n".
         ''."\n".
         '  <!-- Source -->'."\n".
         '    <style type="text/css">'."\n".
         '      body{ background-color: #1073AA;color: #FFFFFF;}'.
         '      .error{font-family: serif;font-size:80px;}'.
         '      td.trace{border: 1px solid black;}'.
         '      a{ font-size:14px; color:#E0E0F0;  }'."\n".
         '      a:Hover{ color:#F0F0FF;  }'."\n".
         '      .key{color:#000000;font: 0.92em/1.4 Arial,sans-serif;}'."\n".
         '      .value{color:#000000;font-size:14px;font-family: Arial, sans-serif;font-weight:bold;}'."\n".
         '      .select{color:#990000;}'."\n".
         '    </style>'."\n".
         '<head>'."\n".
         '<body>'."\n";
  }  
  $show.='  <p align="left">'."\n".
         '    <div class="error" title="';
  if(($info)and(DEBUG)) {
    $show.=_($_['str']['DEBUG']);
  } else {
    $show.=_($_['str']['ERROR']);
  }    
  $show.='">:(</div>';/*...*/
    
  $show.=/*...*/'<br/>'."\n"."\n".
         '    <dd><font color="#FFFFFF">';
  if($_['msgshow']['message']==''){
    if(($info)and(DEBUG)) {
      $show.=_($_['str']['INFO_MESSAGE']);
    } else {
      $show.=_($_['str']['ERROR_MESSAGE']);
    }
  }else{
    $show.=$_['msgshow']['message'];
  }
  $show.='<br/><br/></font></dd>'."\n";
  if(DEBUG){           
    $_['msgshow']['info']['memory_use']=array($_['str']['MEMORY_USE'],SizeToStr(memory_get_usage()));
    $_['msgshow']['info']['errruntime']=array($_['str']['ERROR_RUNTIME'],sprintf('%f',total_time($_['start_time'])));
    $error_table='<table style="background:#FFFFFF; border: 1px solid #646464;">';
    if(!$info){
		if(array_key_exists('severity', $_['msgshow']['info']))
		{
			$error_table.='<tr><td class="key">'._($_['msgshow']['info']['severity'][0]).': </td><td class="value">'.$_['msgshow']['info']['severity'][1].' ['.$_['msgshow']['info']['severity'][2].']<br/></td></tr>';
		}
    }
    foreach($_['msgshow']['info'] as $key => $value) {
      if(($key!='severity')and($key!='context')) {
        $error_table.='<tr><td class="key">'._($value[0]).': </td><td class="value">'.$value[1].'<br/></td></tr>';
      }
    }
    $error_table.='</table>';
    $show.='<script type="text/javascript">'."\n".
           '<!--'."\n".
           '  function showTip(on){'."\n".
           '    if (!on) {'."\n".
           '      document.getElementById("error_message").style.display="none";'."\n".
           '      document.getElementById("debug").style.display="block";'."\n".
           '    }else{'."\n".
           '      document.getElementById("error_message").style.display="block";'."\n".
           '      document.getElementById("debug").style.display="none";'."\n".
           '    }'."\n".
           '  }'."\n".
           '-->'."\n".
           '</script>'."\n".
           '<div id="error_message" style="background:#808080; border: 1px solid #000000; display:none; font-size:10pt; padding:4; width:80%;">'."\n".
           '<a style="cursor:help;color:#FFFFFF;text-decoration:underline;" onclick="showTip(0)"><b>'._($_['str']['HIDE_DETAIL_ERROR']).'</b></a><hr>'."\n".
           ''._($_['str']['DEBUG_SHOW']).'<br/><br/><font size="+1">'._($_['msgshow']['dbgstr']).'</font><br/><br/>'."\n".
           ''._($_['str']['INFO']).':<br/>'.$error_table.''."\n".
           '  <br/><a href="/">'._($_['str']['HOME']).'</a> | '._($_['str']['AUTOR']).': &copy; '.$_['autor'].' | '._($_['str']['EMAIL']).': <a href="mailto:'.$_['email'].'">'.$_['email'].'</a>'."\n".
           '</div>'."\n".
           '<a id="debug" style="display:block; cursor:help;color:#FBFBFC;text-decoration:underline;" onclick="showTip(1)"><b>'._($_['str']['SHOW_DETAIL_ERROR']).'</b></a>'."\n";
  }   
  $show.=  '</html>'."\n";
	if(!$nosend) {
		ob_clean();  // Стираем все лишнее
		header("Expires: Thu, 01 Jan 1970 00:00:01 GMT"); // Срок действия прошел
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // всегда новый
		header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
		header("Pragma: no-cache"); // HTTP/1.0
		header("Content-type: text/html; charset=UTF-8");
		echo $show;
		ob_flush();   //Отпрявляем
		exit;
	} else {                  
		return $show; //Возвращаем
	}
}

function _ini_set($key,$value)
{
	if(($key=='expose_php')and($value=='off')) {
		if(version_compare(PHP_VERSION,'5.3.0', '>=')) {
			header_remove('X-Powered-By');
		} else {
			header('X-Powered-By: ');
		}
		return TRUE;//Устанавливается только в файле ini.php
	} else if($key=='zend.ze1_compatibility_mode') {
		if(version_compare(PHP_VERSION,'5.3.0', '>=')) {
			return TRUE;
		}
	} else if($key=='exit_on_timeout') {
		if(version_compare(PHP_VERSION,'5.3.0', '<=')) {
			return FALSE;
		}
	} else if($key=='asp_tags') {
		if(version_compare(PHP_VERSION,'4.0.0', '>')) {
			return TRUE;
		}
	} else if($key=='short_open_tag') {
		if(version_compare(PHP_VERSION,'4.0.0', '>')) {
			return FALSE;
		}
	} else if($key=='safe_mode') {
		if(version_compare(PHP_VERSION,'5.4.0', '>')) {
			return TRUE;
		}
		return FALSE;
	} else if($key=='track_vars') {
		if(version_compare(PHP_VERSION,'4.0.3', '>')) {
			return TRUE;
		}
	} else if($key=='register_globals') {
		if(version_compare(PHP_VERSION,'4.2.3', '>')) {
			return TRUE;
		}
	} else if($key=='magic_quotes_gpc') {
		if(version_compare(PHP_VERSION,'4.2.3', '>')) {
			return TRUE;
		}
	}
	$old = ini_set($key,$value);
	if($old===FALSE) {
		trigger_error(sprintf('Невозможно установить параметр "%s" значением "%s"',$key,$value));
	}
	return TRUE;
}

function include_source($filename)
{
	_log('Action: Include "'.$filename.'";');
	include $filename;
}
/*******************************************************************************
*   ГЛОБАЛЬНЫЕ СОБЫТИЯ                                                         *
*******************************************************************************/

        //Событие: Произошла ошибка (Обработчик ошибок)
function /*void*/ __error(
	/*int*/ $severity,
	/*string*/ $errstr,
	/*string*/ $errfile,
	/*int*/ $errline,
	/*mix*/ $context
) {
	global $_;
	if($_['error_reporting']) {
		if((error_reporting() & $severity) === 0) {
			return;
		}
	}
	$e=FALSE;
	if($_['ExceptionLoad']) {
		$scee = '\\System\\__createErrorException';
		$e=$scee($severity, $errstr, $errfile, $errline, $context);
	}
	$type=getSeverity($severity);
	if($e!==FALSE){
		$_['msgshow']['info']['exception']=array($_['str']['EXCEPTION_NAME'],get_class($e));
	}
	$_['msgshow']['info']['severity']=array($_['str']['ERROR_SEVERITY'],$type,$severity);
	$_['msgshow']['dbgstr']=$errstr;
	$_['msgshow']['info']['errfile']=array($_['str']['ERROR_FILE'],$errfile);
	$_['msgshow']['info']['errline']=array($_['str']['ERROR_LINE'],$errline);
	$_['msgshow']['info']['context']=array($_['str']['ERROR_CONTEXT'],$context);
	msgshow();
	return TRUE; //отключаем глобальную переменную $php_errormsg
}
        //Событие: Исключение необработано
function /*void*/ __uncaughtException(/*TException*/ $exception)
{
	global $_;
    $_['msgshow']['dbgstr']=$exception->getMessage(); 
    $_['msgshow']['info']['exception']=array($_['str']['EXCEPTION_NAME'],get_class($exception));
    
    $e_severity = (method_exists(get_class($exception),'getSeverity'))== TRUE;
    $e_trace = (method_exists(get_class($exception),'getTrace'))== TRUE;
    $type='UNKNOWN';
    if($e_severity and isset($_['error_types'][$exception->getSeverity()]))
    {
        $type=$_['error_types'][$exception->getSeverity()];
    }
	if($e_severity)
	{
		$_['msgshow']['info']['severity']=array($_['str']['ERROR_SEVERITY'],$type,$exception->getSeverity());
	}
	if($e_trace)
	{
        $trace = '<table class="trace">';
        foreach($exception->getTrace() as $t){
            $trace .= '<tr class="trace">';
            if(array_key_exists('file',$t) and array_key_exists('line',$t)){
                $f = basename($t['file']);
                $trace .= '<td class="trace" title="'.$t['file'].'">'.$f.'(<span class="select">'.$t['line'].'</span>)</td>';
            }else{
                $trace .= '<td class="trace"></td>';
            }
            $trace .= '<td class="trace">';
            if(array_key_exists('class',$t)) {
                $trace .= '<span class="select">[</span>'.$t['class'].'<span class="select">]</span>';
            }
            if(array_key_exists('type',$t)) {
                $trace .= '<span class="select">'.$t['type'].'</span>';
            }
            if(array_key_exists('function',$t)) {
                $trace .= ''.$t['function'].'';
            }
            $trace .= '</td>';
            $trace .= '</tr>';
        }
        $trace .= '</table>';
        $_['msgshow']['info']['trace']=array('Trace',$trace);
    } 
    $_['msgshow']['info']['errfile']=array($_['str']['ERROR_FILE'],$exception->getFile());
    $_['msgshow']['info']['errline']=array($_['str']['ERROR_LINE'],$exception->getLine());                                     
    msgshow(); // Показываем ошибку всегда, так как исключение не обработано
}
        //Событие: Запрос несуществующего класса
function /*void*/ __autoload($class_name)
{
	global $_;
	$autoloader = '';
	foreach($_['autoload'] as $key=>$value) {
		if(strrpos($class_name,$key)===0) {
			$autoloader = $key;
			break;
		}
	}
	if($autoloader != '') {
		call_user_func($_['autoload'][$autoloader],$class_name);
	} else {
		$filename=SOURCES.DS.path($class_name).$_['exp_php'];
		if(file_exists($filename)) {
			include_source($filename);
		} else {
			foreach($_['modules'] as $mod=>$value) {
				$filename=MODULES.DS.$mod.DS.'includes'.DS.path($class_name).$_['exp_php'];
				if(file_exists($filename)) {
					
					include_source($filename);
					return;
				}
			}
			//throw new \System\ECore(sprintf($_['str']['ERROR_CLASS_NO_FOUND'],$class_name,$filename));
		}
	}
}
        //Событие: Завершена работа
function /*void*/ __shutdown(/*void*/)
{
	if (
		$error = error_get_last()
		AND
		$error['type'] & ( E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR)
	) {
		$exeption = \System\__getErrorException($error["type"],$error["message"],$error["file"],$error["line"],null);
		__uncaughtException($exeption);
	}
}
        //Событие: Тик
function /*void*/ __tick(/*void*/)
{

}

/*******************************************************************************
*   ERROR SET                                                                  *
*******************************************************************************/
_log('Begin script.');
$_['old_error_handler'] = set_error_handler('__error');  // Обработчик ошибок
_log('Action: Error handlers set.');

if(DEBUG) {
	/*
	 * Проверяем наличее необходимых функций
	 */
	$cnt = count($_['used_functions']);
	for($i = 0; $i < $cnt; $i++) {
		if(!function_exists($_['used_functions'][$i])){
			trigger_error(sprintf($_['str']['ERROR_FUNCTION_NOT_DEFINED'],$_['used_functions'][$i]));
		}
	}
	/*
	 * Проверяем наличее необходимых переменных
	 */
	$cnt = count($_['used_variables']);
	for($i = 0; $i < $cnt; $i++) {
		if(!isset(${$_['used_variables'][$i]})){
			trigger_error(sprintf($_['str']['ERROR_VARIABLE_NOT_DEFINED'],$_['used_variables'][$i]));
		}
	}
	/*
	 * Проверяем что работаем в заданом интервале версий PHP
	 */
	if(
		(version_compare(PHP_VERSION,$_['min_phpv'], '<='))
		or
		(version_compare(PHP_VERSION,$_['max_phpv'], '>='))
	) {
		trigger_error(sprintf($_['str']['ERROR_PHP_VERSION'],PHP_VERSION));
	}
}
if(function_exists('spl_autoload_register')){
	spl_autoload_register('__autoload'); // Обработчик запроса классов
}       
register_shutdown_function('__shutdown');  // Обработчик Завершения работы
//register_tick_function('__tick');        // Обработчик Тика
//Некоторые версии Apache крашаться при установленных shutdown и tick.
_log('Action: Check complited.');

if($_['Exception']){
  $filename=SOURCES.DS.'System'.DS.'Exceptions'.$_['exp_php'];
  if(file_exists($filename)){
    include_source($filename);//Подключение файла(Безопасность)
  }else{
    trigger_error(sprintf('Не могу найти файл %s',$filename));
  }
  unset($filename);
  //Дальше trigger_error не используется.
  
  set_exception_handler('__uncaughtException');                 // Обработчик исключений
  $_['ExceptionLoad'] = True;
  _log('Action: Exception handler set;');
}/*if*/

/*******************************************************************************
*   Настраеваем PHP                                                            *
*******************************************************************************/       

_ini_set('date.timezone','Asia/Yekaterinburg'); // Устанавливаем локальное время
_ini_set('display_errors','0');                 // Отключаем показ ошибок
_ini_set('exit_on_timeout','0');                // Отключаем завершение при timeout
_ini_set('expose_php', 'off');                  // Скрываем X-Powered-By
_ini_set('zend.ze1_compatibility_mode', 'off'); // Отключаем копирование классов
_ini_set('asp_tags','0');                       // Отключаем ASP теги
_ini_set('short_open_tag','0');                 // Отключаем короткие PHP теги
_ini_set('safe_mode', 'off');                   // Отключаем безопасный режим
_ini_set('track_vars', 'on');                   // Включаем входящие переменные в асоциативные масивы
_ini_set('register_globals', 'off');            // Создание глобальных входящих переменных
_ini_set('magic_quotes_gpc', 'off');            // Отключаем заQuote для Inputa

if(DEBUG){
    _ini_set('display_errors','1');             // Включаем показ ошибок
}
_log('Action: "php.ini" configurated.');

function bootstrap($exec)
{
    global $_;
/*******************************************************************************
*   Запускаем приложение                                                       *
*******************************************************************************/
    ob_start();  // Пишем все в буфер
    if(file_exists($exec)) {
        //Глобальный блок try
        //Возможно этот блок отловит не все исключения
        //На этот случай задан set_exception_handler
        try {
            include_source($exec);
        } catch(Exception $e) {
			__uncaughtException($e);
        }
    } else {
        header('HTTP/1.0 404 Not Found');
		exit;
    }
    if($_['echo']) {
        ob_flush();
    }
    ob_clean();
/*******************************************************************************
*   Завершаем работу                                                           *
*******************************************************************************/
    _log('End script.');
    if(DEBUG and($_['log'])and($_['log_to_file'])) {
      /*handle*/ $fp=fopen($_['path']['log'],'w');
      /*int*/$t0=0;
      /*int*/$t=$_['datalog'][0][0];
      /*int*/$dt=0;
      foreach($_['datalog'] as $key){
        $dt=((int)($key[0]*10000))-((int)($t*10000));
        $t0+=$dt;
        $t=$key[0];
        fputs($fp,"".$t0."\x09".$dt."\x09".$key[1]."\x09".$key[2]."\n");
      }
      unset($t0);
      unset($t);
      unset($dt);
      fclose($fp);
      chmod ($_['path']['log'], 0777);
      unset($fp);
    }
    if($_['exit']) {
      exit;   // Останавливаем трансляцию
    }
}
$_['error_reporting'] = TRUE;//Включаем штатную обработку ошибок
_log('Bootstrap loaded.');