<?php /*************************************************************************
*    type: SRC.PHP5                            © 2013-2015 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
* created: 2013.02.01                                                          *
*    path: \Cms\Views\Messages                                                 * 
*******************************************************************************/
namespace Cms\Views;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

/**
 * Представление для Сообщений между пользователями.
 */
class Messages extends \Cms\View
{
	protected function construct($inRequest = NULL, $inSection = NULL)
	{
		call_user_func_array('parent::construct',func_get_args());
		$messages = array();
		$base = $this->System->getBase();
		
		$msgtype = 'inbox';
		if($inRequest->getWebRequest()->getParam('removed') !== NULL) {
			$msgtype = 'removed';
		}
		if($inRequest->getWebRequest()->getParam('sent') !== NULL) {
			$msgtype = 'sent';
		}
		$msg = intval($inRequest->getWebRequest()->getSectPath(2));
		if($msg <1) {
			$msg = $inRequest->getWebRequest()->getParam('id');
		}
		$message = NULL;
				
		if($msg !== NULL) {
			$query = 'SELECT "to", "from", "date_send", "date_read", "title", "message" FROM {messages} WHERE "id" = :id and "to" = :uid';
			$result = $base->execute($query,
				array(
					'id'    => $msg,
					'uid'   => $inRequest->getUser()->id
				)
			);
			if($result->numRows() > 0) {
				while( ($row = $result->fetchArray(TRUE) )!==FALSE) {
					$message = $row;
				}
				if($message['date_read'] == 0) {
					$query = 'UPDATE {messages} SET date_read = :date_read WHERE "id" = :id and "to" = :uid';
					$result = $base->execute($query,
						array(
							'id'        => $msg,
							'uid'       => $inRequest->getUser()->id,
							'date_read' => time()
						)
					);
				}
			}
		} else {
			if($msgtype == 'sent') {
				$query  = 'SELECT t2."value" first_name, t3."value" last_name, t1."id", t1."to", t1."from", t1."date_send", ';
				$query .= 't1."date_read", t1."title", t1."message" ';
				$query .= 'FROM {messages} t1 ';
				$query .= 'LEFT JOIN {users_data} t2 ON t1."from" = t2."id" and t2."key" = :t2_key ';
				$query .= 'LEFT JOIN {users_data} t3 ON t1."from" = t3."id" and t3."key" = :t3_key ';
				$query .= 'WHERE t1."from" = :uid';
			} else if($msgtype == 'removed') {
				$query  = 'SELECT t2."value" first_name, t3."value" last_name, t1."id", t1."to", t1."from", t1."date_send", ';
				$query .= 't1."date_read", t1."title", t1."message" ';
				$query .= 'FROM {messages} t1 ';
				$query .= 'LEFT JOIN {users_data} t2 ON t1."from" = t2."id" and t2."key" = :t2_key ';
				$query .= 'LEFT JOIN {users_data} t3 ON t1."from" = t3."id" and t3."key" = :t3_key ';
				$query .= 'WHERE t1."to" = :uid and t1."date_removed" > 0';
			} else {
				$query  = 'SELECT t2."value" first_name, t3."value" last_name, t1."id", t1."to", t1."from", t1."date_send", ';
				$query .= 't1."date_read", t1."title", t1."message" ';
				$query .= 'FROM {messages} t1 ';
				$query .= 'LEFT JOIN {users_data} t2 ON t1."from" = t2."id" and t2."key" = :t2_key ';
				$query .= 'LEFT JOIN {users_data} t3 ON t1."from" = t3."id" and t3."key" = :t3_key ';
				$query .= 'WHERE "to" = :uid';
			}
			$result = $base->execute($query,
				array(
					't2_key' => 'first_name',
					't3_key' => 'last_name',
					'uid'   => $inRequest->getUser()->id
				)
			);
			if($result->numRows() > 0) {
				while( ($row = $result->fetchArray(TRUE) )!==FALSE) {
					$row['message_preview'] = str_replace('\r',' ',str_replace('\n','',substr($row['message'],0,100)));
					$messages[] = $row;
				}
			}
		}
		$person = NULL;
		try {
			$to = $inRequest->getWebRequest()->getParam('to');
			$person = new \Cms\User($this->System, $to);
		} catch (\Exception $e) {
			$person = NULL;
		}
		$this->Data['create'] = $inRequest->getWebRequest()->getParam('create');
		$this->Data['person'] = $person;
		$this->Data['ajax'] = $inRequest->isAjax();
		$this->Data['message'] = $message;
		$this->Data['messages'] = $messages;
		$this->Data['msgtype'] = $msgtype;
	}
	
    protected function destruct()
    {
		call_user_func_array('parent::destruct', array());
	}
	
}