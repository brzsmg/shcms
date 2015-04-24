<?php /*************************************************************************
*    type: SRC.PHP5                            © 2013-2014 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
* created: 2013.02.01                                                          *
*    path: \System\Exceptions                                                  *                                          
*******************************************************************************/
namespace System;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/
	if(!class_exists('Exception')){
		die('impossible');
		//require_once 'MException.h.php';
	}
	if(!class_exists('ErrorException')){
		die('impossible');
		//require_once 'MException.h.php';
	}

class ECore extends \Exception
{
	function __construct($message = NULL, $code = 0, $previous = NULL) {
		parent::__construct($message, $code, $previous);
		\System\Console::warning($message);
	}

}

class EError extends \ErrorException
{
	function __construct(
		$message = '',
		$code = 0,
		$severity = 1,
		$filename = __FILE__,
		$lineno = __LINE__,
		$previous = NULL
	) {
		parent::__construct($message, $code, $severity, $filename, $lineno, $previous);
		\System\Console::warning('['.\getSeverity($severity).'] '._($message));
	}
}

class EWarning extends \System\EError{}
class EParse extends \System\EError{}
class ENotice extends \System\EError{}
class ECoreError extends \System\EError{}
class ECoreWarning extends \System\EError{}
class ECompileError extends \System\EError{}
class ECompileWarning extends \System\EError{}
class EUserError extends \System\EError{}
class EUserWarning extends \System\EError{}
class EUserNotice extends \System\EError{}
class EStrict extends \System\EError{}
class ERecoverableError extends \System\EError{}
class EDeprecated extends \System\EError{}
class EUserDeprecated extends \System\EError{}

class EMathError extends \System\EWarning{}
class EDivByZero extends \System\EMathError{}
class EUndefined extends \System\EWarning{}
  
//Создает исключение ErrorException
function __createErrorException($severity, $errstr, $errfile, $errline, $context)
{
	//return если исключение не перехватываемое
	throw __getErrorException($severity, $errstr, $errfile, $errline, $context);
}

function __getErrorException($severity, $errstr, $errfile, $errline, $context)
{
	if($severity == E_ERROR){
		return new \System\EError($errstr, 0, $severity, $errfile, $errline);
	} else if($severity == E_WARNING) {
		if(strpos($errstr, 'Division by zero')!==false) {
			return new \System\EDivByZero($errstr, 0, $severity, $errfile, $errline);
		} else {
			return new \System\EWarning($errstr, 0, $severity, $errfile, $errline);
		}
	} else if($severity == E_PARSE) {
		return new \System\EParse($errstr, 0, $severity, $errfile, $errline);
	} else if($severity == E_NOTICE) {
		return new \System\ENotice($errstr, 0, $severity, $errfile, $errline);
	} else if($severity == E_CORE_ERROR) {
		return new \System\ECoreError($errstr, 0, $severity, $errfile, $errline);
	} else if($severity == E_CORE_WARNING) {
		return new \System\ECoreWarning($errstr, 0, $severity, $errfile, $errline);
	} else if($severity == E_COMPILE_ERROR) {
		return new \System\ECompileError($errstr, 0, $severity, $errfile, $errline);
	} else if($severity == E_COMPILE_WARNING) {
		return new \System\EUserWarning($errstr, 0, $severity, $errfile, $errline);
	} else if($severity == E_USER_ERROR) {
		return new \System\System\EUserError($errstr, 0, $severity, $errfile, $errline);
	} else if($severity == E_USER_WARNING) {
		return new \System\EUserWarning($errstr, 0, $severity, $errfile, $errline);
	} else if($severity == E_USER_NOTICE) {
		return new \System\EUserNotice($errstr, 0, $severity, $errfile, $errline);
	} else if($severity == E_STRICT) {
		return new \System\EStrict($errstr, 0, $severity, $errfile, $errline);
	} else if($severity == E_RECOVERABLE_ERROR) {
		return new \System\ERecoverableError($errstr, 0, $severity, $errfile, $errline);
	} else if($severity == E_DEPRECATED) {
		return new \System\EDeprecated($errstr, 0, $severity, $errfile, $errline);
	} else if($severity == E_USER_DEPRECATED) {
		return new \System\EUserDeprecated($errstr, 0, $severity, $errfile, $errline);
	} else {
		//Ошибка не определена, возможно новая версия PHP
		return new \System\EError($errstr, 0, $severity, $errfile, $errline);
	}
}