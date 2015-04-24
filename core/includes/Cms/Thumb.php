<?php /*************************************************************************
*    type: SRC.PHP5                                 © 2015 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
* created: 2015.02.01                                                          *
*    path: \Cms\Thumb                                                          * 
*******************************************************************************/
namespace Cms;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/

/**
 * Представление для документа
 */
class Thumb extends \System\Dispatch
{
	protected $System = NULL;
	protected $Base = NULL;
	protected $Path = NULL;

	protected function construct($inSystem = NULL, $params = NULL)
	{
		call_user_func_array('parent::construct',func_get_args());
		$this->System = $inSystem;
		$this->Base = $this->System->getBase();
		$url = '/cache/thumbs/';
		if($params == NULL) {
			throw new \System\ECore('Не заданы параметры.');
		}
		if(!array_key_exists('id',$params)){
			throw new \System\ECore('Не задан идентификатор документа.');
		}
		if(!array_key_exists('width',$params)){
		  $params['width']=1;
		}
		if(!array_key_exists('height',$params)){
		  $params['height']=1;
		}
		if(!array_key_exists('mode',$params)){
		  $params['mode']=0;
		}
		if(!array_key_exists('format',$params)){
		  $params['format'] = FALSE;
		}
		if(!array_key_exists('quality',$params)){
		  $params['quality']=100;
		}
		if(!array_key_exists('bg',$params)){
		  $params['bg']=0xFFFFFF;
		}
		$query = 'SELECT * FROM {docs_thumb}';
		$query .= ' WHERE "doc_id" = :doc_id';
		$query .= ' and "width" = :width';
		$query .= ' and "height" = :height';
		$query .= ' and "mode" = :mode';
		$query .= ' and "format" = :format';
		$query .= ' and "quality" = :quality';
		$result = $this->Base->execute($query, array(
			'doc_id'  => $params['id'],
			'width'  => $params['width'],
			'height'  => $params['height'],
			'mode'  => $params['mode'],
			'format'  => $params['format'],
			'quality'  => $params['quality'],
		));
		$thumb = $result->fetchArray(TRUE);
		$exists = FALSE;
		$destname = '';
		if($thumb !== FALSE) {
			$destname = $thumb['name'];
			if (file_exists(ROOT.$url.$destname)){
				$exists = TRUE;
			}
		}
		
		if(!$exists){
			$query = 'SELECT * FROM {docs} WHERE "id" = :id';
			$result = $this->Base->execute($query, array(
				'id'  => $params['id']
			));
			$doc = $result->fetchArray(TRUE);
			if($row === FALSE) {
				throw new \System\ECore('Указан не существующий идентификатор документа.');
			}
			$src = ROOT.$doc['path'];
			if (!file_exists($src)){
			  throw new \System\ECore('Невозможно содать превью для файла "'.$filename.'", так как он не существует.');
			}
			if($thumb === FALSE) {
				$time = time();
				$destname = rand(11,99).date('Y',$time).rand(11,99).date('m',$time);
				$destname .= rand(11,99).date('d',$time).rand(11,99).date('H',$time);
				$destname .= rand(11,99).date('i',$time).rand(11,99);
				$destname .= date('s',$time).rand(11,99);
				if($params['format'] === FALSE) {
					$ext = explode('.',$src);
					$ext = $ext[count($ext)-1];
					$destname .= '.'.$ext;
				} else {
					$destname .= '.'.$params['format'];
				}
			}
			$dest = ROOT.$url.$destname;
			if(!$this->img_resize($src,$dest,$params['width'],$params['height'],$params['format'],$params['mode'],$params['bg'],$params['quality'])){
				throw new \System\ECore('Невозможно содать превью для файла "'.$filename.'".');
			}
		}
		if($thumb === FALSE) {
			$query = 'INSERT INTO {docs_thumb}';
			$query .= '("doc_id", "width", "height", "mode", "format", "quality", "name")';
			$query .= ' VALUES (:doc_id, :width, :height, :mode, :format, :quality, :name)';
			$this->Base->execute($query, array(
				'doc_id'   => $params['id'],
				'width'    => $params['width'],
				'height'   => $params['height'],
				'mode'     => $params['mode'],
				'format'   => $params['format'],
				'quality'  => $params['quality'],
				'name'     => $destname
			));
		}
		$this->Path = $url.$destname;
	}
	
	public function getPath()
	{
		return $this->Path;
	}
	
    protected function destruct()
    {
		call_user_func_array('parent::destruct', array());
	}

	///Эту функцию нужно перенести в include, сделать объект \Source\Image
	public function img_resize($src, $dest, $dest_width=0, $dest_height=0, $dest_format=False, $mode=0, $rgb=0xFFFFFF, $quality=100){
		if (!file_exists($src)){return False;}
		$src_size = getimagesize($src);
		if($src_size === false){return False;}
		if($dest_width==0){$dest_width=$src_size[0];}
		if($dest_height==0){$dest_height=$src_size[1];}
		$src_format = strtolower(substr($src_size['mime'], strpos($src_size['mime'], '/')+1));
		$src_img_create_func = 'imagecreatefrom'.$src_format;
		$src_img_func  = 'image'.$src_format;
		if(!function_exists($src_img_create_func)){return False;}
		if(!function_exists($src_img_func)){return False;}

		if(($dest_format)and($dest_format!='')){
			$dest_img_func = 'image'.$dest_format;
			if(!function_exists($dest_img_func)){return False;}
		}else{
			$dest_format = $src_format;
			$dest_img_func = $src_img_func;
		}

		$img_left=0;
		$img_top=0;
		$img_width=$dest_width;
		$img_height=$dest_height;

		if($mode!=0){
			$x_ratio = $dest_width / $src_size[0];
			$y_ratio = $dest_height / $src_size[1];

			$ratio       = min($x_ratio, $y_ratio);
			$use_x_ratio = ($x_ratio == $ratio);

			$img_width   =  $use_x_ratio ? $dest_width  : floor($src_size[0] * $ratio);
			$img_height  = !$use_x_ratio ? $dest_height : floor($src_size[1] * $ratio);
		}
		if($mode==1){
			$img_left    =  $use_x_ratio ? 0            : floor(($dest_width  - $img_width) / 2);
			$img_top     = !$use_x_ratio ? 0            : floor(($dest_height - $img_height) / 2);
		}

		$img_src  = $src_img_create_func($src);
		if($mode==2){
			$img_dest = imagecreatetruecolor($img_width, $img_height);
		}else{
			$img_dest = imagecreatetruecolor($dest_width, $dest_height);
		}
		if($dest_format=='png'){
			imageSaveAlpha($img_dest, True);
		}
		imagefill($img_dest, 0, 0, $rgb);

		imagecopyresampled($img_dest, $img_src, $img_left, $img_top, 0, 0,
			$img_width, $img_height, $src_size[0], $src_size[1]);

		if($dest_format=='jpeg'){
			$dest_img_func($img_dest, $dest, $quality);
		}else{
			$dest_img_func($img_dest, $dest);
		}

		chmod($dest,0777);

		imagedestroy($img_src);
		imagedestroy($img_dest);

		return True;
	}
	
	

}