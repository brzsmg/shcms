<?php
/**
 * SHCMS
 *
 * @copyright 2013-2017 Selivanovskikh M.G.
 * @license   GNU General Public License v2.0
 */

namespace Cms\Controllers;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}

/**
 * Контроллер приема файлов формы
 */
class Upload extends \Cms\Controller
{
	private $config = array(
		'maxsize'  => 100000000,
		'allowext' => array('gif','jpg','jpe','jpeg','png')
	);

//# Конструкторы #//
	protected function construct($system = NULL)
	{
		call_user_func_array('parent::construct',func_get_args());
	}
	
    protected function destruct()
    {
        call_user_func_array('parent::destruct',array());
    }
	
//# Методы #//
	public function executeRequest($inRequest)
	{
		
		try {
			$Base = $inRequest->getSystem()->getBase();
			//$form = $inRequest->getWebRequest()->getParam('form');
			//$ads = $inRequest->getWebRequest()->getParam('ads');
			$id = $inRequest->getWebRequest()->getParam('id');
			$result = NULL;
			if($id!==null){//$form !== NULL) {
				/*$query = 'SELECT "id" FROM {forms} WHERE hash = :hash and name = :name';
				$result = $Base->execute($query,array(
					'hash' => $form,
					'name' => 'docs'
				));
				$input = $result->fetchArray(TRUE);
				if($input == FALSE) {
					throw new \System\ECore('Такой формы не существует.');
				}*/
				$query = 'SELECT COUNT(*) FROM {docs} WHERE parent_table = :parent_table and parent_id = :parent_id';
				$result = $Base->execute($query, array(
					'parent_table' => 'md_organizations',
					'parent_id'    => $id//$input['id']
				));
				$docs_count = $result->fetchValue();
				$file = $this->save();
				$nextval = $Base->nextval('docs','id');
				$query = 'INSERT INTO {docs} (';
				$query .= '"id", "parent_table", "parent_id", "position", "name", "description", "type", "mime", "size", "path", "data"';
				$query .= ') VALUES (:id, :parent_table, :parent_id, :position, :name, :description, :type, :mime, :size, :path, :data)';
				$result = $Base->execute($query, array(
					'id'           => $nextval,
					'parent_table' => 'md_organizations',//'forms',
					'parent_id'    => $id,//$input['id'],
					'position'     => ($docs_count+1),
					'name'         => $file["name"],
					'description'  => '',
					'type'         => 'doc',
					'mime'         => $file["mime"],
					'size'         => $file["size"],
					'path'         => $file["path"],
					'data'         => NULL,
				));
				$id = $Base->getInsertID();
				
				$result = array(
					'state' => 'success',
					'id'    => $id,
					'path'  => $file["path"]
				);
			} else {

			}
		} catch(Exception $e) {
			$error = $e->getMessage();
			if($error === NULL) {
				$error = 'Server upload unknown error';
			}
			$result = array(
				'state' => 'error',
				'error' => $error,
			);
		}
		$response = new \Net\Response();
		$response->addBody(json_encode($result));
		$inRequest->sendResponse($response);
	}
	
	private function save() {
		if (!isset($_FILES)) {
			throw new Exception('Upload file no found.');
		}
		if(!array_key_exists('Filedata',$_FILES)) {
			throw new Exception('Upload file no found parametr name.');
		}
		if(!array_key_exists('error',$_FILES['Filedata'])) {
			throw new Exception('Upload file server error.');
		}
		if ($this->config['maxsize'] < $_FILES['Filedata']['size']) {
			throw new Exception('Big size.');
		}
		if (is_array($_FILES['Filedata']['error'])) {
			throw new Exception('Upload Multiple Files no supported.');
		}
		$ar = explode('.', strtolower($_FILES['Filedata']['name']));
		$ext = end($ar);
		if (!in_array($ext, $this->config['allowext'] )) {
			throw new Exception('Extension no supported.');
		}

		if ($_FILES["Filedata"]["error"] != UPLOAD_ERR_OK) {
			if($_FILES["Filedata"]["error"] == UPLOAD_ERR_INI_SIZE) {
				throw new Exception("Слишком большой файл для сервера.");
			} else if($_FILES["Filedata"]["error"] == UPLOAD_ERR_FORM_SIZE) {
				throw new Exception("Слишком большой файл.");
			} else if($_FILES["Filedata"]["error"] == UPLOAD_ERR_PARTIAL) {
				throw new Exception("Загружаемый файл был получен только частично.");
			} else if($_FILES["Filedata"]["error"] == UPLOAD_ERR_NO_FILE) {
				throw new Exception("Файл не был загружен.");
			} else {
				throw new Exception("Upload file error.");
			}
		}
		$tmp_name = $_FILES["Filedata"]["tmp_name"];
		$name = $_FILES["Filedata"]["name"];
		$path = '/files/docs/'.md5(time()).rand(10000,99999).'.'.$ext;
		//move_uploaded_file
		copy($tmp_name, ROOT.$path);
		return array(
			'name' => $name,
			'mime' => $_FILES["Filedata"]["type"],
			'size' => $_FILES["Filedata"]["size"],
			'path' => $path
			
		);
	}
		
}