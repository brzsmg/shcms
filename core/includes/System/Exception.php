<?php /*************************************************************************
*  H.PHP5:                                     © 2011-2014 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
*    path: \System\Exception                                                   *
*                                                                              *
*    Исключения. Сдесь представлены нативные классы Exception и ErrorException.*
*  Их не нужно подключать к проекту.                                           *
*******************************************************************************/
Header("Location: http://".getenv('HTTP_HOST'));exit;
/******************************************************************************/
class Exception {              
/* Свойства */
  protected $message = 'Unknown exception'; // сообщение исключения
  protected $code = 0; // определенный пользователем код исключения
  protected $file;     // имя файла, где произошло исключение
  protected $line;     // номер строки, где произошло исключение
  private   $trace;    // бэктрейс исключения
  private   $string;   // строковое представление исключения
/* Методы */
  function __construct(
      /*string*/ $message = NULL,
      /*int*/ $code = 0,
      /*Exception*/ $previous = NULL
  ) {
    if (func_num_args()) {
      $this->message = $message;
    }
    $this->code = $code;
    $this->file = __FILE__; // места с ключевым словом throw
    $this->line = __LINE__; // места с ключевым словом throw
    $this->trace = debug_backtrace();
    $this->string = StringFormat($this);
  }
  final function getMessage(/*void*/) {
    return $this->message;
  }
  final function getCode(/*void*/) {
    return $this->code;
  }
  final function getFile(/*void*/) {
    return $this->file;
  }
  final function getLine(/*void*/) {
    return $this->line;
  }
  final function getTrace(/*void*/) {
    return $this->trace;
  }
  final function getTraceAsString(/*void*/) {
    return self::TraceFormat($this);
  }
  function /*string*/ __toString(/*void*/) {
    return $this->string;
  }
  final private function /*void*/ __clone ( /*void*/ ){
    /*source(C++)*/
  }
  static private function StringFormat(Exception $exception) {
    /*source(C++)*/
  }
  static private function TraceFormat(Exception $exception) {
    /*source(C++)*/
  }
}

class ErrorException extends Exception{
  /* Свойства */
  protected /*int*/ $severity;
  /* Методы */
  public function __construct(
      /*string*/$message = '',
      /*int*/$code = 0,
      /*int*/$severity = 1,
      /*string*/$filename = __FILE__,
      /*int*/$lineno = __LINE__,
      /*Exception*/ $previous = NULL
  ){
     /*source(C++)*/
  }
  final public /*int*/ function getSeverity(/*void*/){
    /*source(C++)*/
  }
  /* Наследуемые методы */
//final public /*string*/ function Exception::getMessage(/*void*/);
//final public Exception function Exception::getPrevious(/*void*/);
//final public mixed function Exception::getCode(/*void*/);
//final public string function Exception::getFile(/*void*/);
//final public int function Exception::getLine(/*void*/);
//final public array function Exception::getTrace(/*void*/);
//final public string function Exception::getTraceAsString (/*void*/);
//public /*string*/ function Exception::__toString(/*void*/);
//final private void function Exception::__clone(/*void*/);
}

?>