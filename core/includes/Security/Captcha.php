<?php /*************************************************************************
*  S.PHP5:                                          © 2006-2011 Kruglov Sergei *
* charset: UTF-8                                                               *
*    path: \Security\Captcha.php                                               *
*  source: www.captcha.ru, www.kruglov.ru                                      *
*                                                                              *
*******************************************************************************/
namespace Security;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/
class Captcha extends \System\Object
{
	protected $Keystring = '';
	protected $Alphabet = "0123456789abcdefghijklmnopqrstuvwxyz";
	protected $AllowedSymbols = "0123456789";
	protected $Length = 6;
	protected $Fluctuation_amplitude = 8;
	protected $Foreground = array();
	protected $Background = array();
	protected $Width = 160;
	protected $Height = 80;
	protected $Image = null;
	protected $Noise = false;
	protected function /*void*/ construct($inLength = false)
	{
		call_user_func_array('parent::construct',func_get_args());
		if($inLength!==false) {
			$this->Length = $inLength;
		}
		$this->Foreground = array(mt_rand(0,80), mt_rand(0,80), mt_rand(0,80));
		$this->Background = array(255,255,255);
		$this->GenKeystring();
	}
	
    protected function destruct()
    {
		if($this->Image != null)
		{
			imagedestroy($this->Image);
		}
		call_user_func_array('parent::destruct',array());
    }
	
	public function getKeystring()
	{
		return $this->Keystring;
	}
	
	protected function GenKeystring()
	{
		$keystring='';
		while(true)
		{
			for($i=0;$i<$this->Length;$i++)
			{
				$keystring.=$this->AllowedSymbols[mt_rand(0,strlen($this->AllowedSymbols)-1)];
			}
			if(!preg_match('/cp|cb|ck|c6|c9|rn|rm|mm|co|do|cl|db|qp|qb|dp|ww/', $keystring))
			{
				break;
			}
			$keystring='';
		}
		$this->Keystring = $keystring;
	}

	public function GenImage()
	{
		$no_spaces = true;
		if($this->Noise)
		{
			//$white_noise_density=0; // no white noise
			$white_noise_density=1/6;
			//$black_noise_density=0; // no black noise
			$black_noise_density=1/30;
		}
		else
		{
			$white_noise_density=0;
			$black_noise_density=0;
		}
		$fontsdir = 'fonts';
		$fonts=array();
		$fontsdir_absolute=CORE.DS.$fontsdir;
		if ($handle = opendir($fontsdir_absolute)) {
			while (false !== ($file = readdir($handle))) {
				if (preg_match('/\.png$/i', $file)) {
					$fonts[]=$fontsdir_absolute.'/'.$file;
				}
			}
			closedir($handle);
		}	

		$alphabet_length=strlen($this->Alphabet);
		
		do{
			$font_file=$fonts[mt_rand(0, count($fonts)-1)];
			$font=imagecreatefrompng($font_file);
			imagealphablending($font, true);

			$fontfile_width=imagesx($font);
			$fontfile_height=imagesy($font)-1;
			
			$font_metrics=array();
			$symbol=0;
			$reading_symbol=false;

			// loading font
			for($i=0;$i<$fontfile_width && $symbol<$alphabet_length;$i++){
				$transparent = (imagecolorat($font, $i, 0) >> 24) == 127;

				if(!$reading_symbol && !$transparent){
					$font_metrics[$this->Alphabet[$symbol]]=array('start'=>$i);
					$reading_symbol=true;
					continue;
				}

				if($reading_symbol && $transparent){
					$font_metrics[$this->Alphabet[$symbol]]['end']=$i;
					$reading_symbol=false;
					$symbol++;
					continue;
				}
			}

			$img=imagecreatetruecolor($this->Width, $this->Height);
			imagealphablending($img, true);
			$white=imagecolorallocate($img, 255, 255, 255);
			$black=imagecolorallocate($img, 0, 0, 0);

			imagefilledrectangle($img, 0, 0, $this->Width-1, $this->Height-1, $white);

			// draw text
			$x=1;
			$odd=mt_rand(0,1);
			if($odd==0) $odd=-1;
			for($i=0;$i<$this->Length;$i++){
				$m=$font_metrics[$this->Keystring[$i]];

				$y=(($i%2)*$this->Fluctuation_amplitude - $this->Fluctuation_amplitude/2)*$odd
					+ mt_rand(-round($this->Fluctuation_amplitude/3), round($this->Fluctuation_amplitude/3))
					+ ($this->Height-$fontfile_height)/2;

				if($no_spaces){
					$shift=0;
					if($i>0){
						$shift=10000;
						for($sy=3;$sy<$fontfile_height-10;$sy+=1){
							for($sx=$m['start']-1;$sx<$m['end'];$sx+=1){
								$rgb=imagecolorat($font, $sx, $sy);
								$opacity=$rgb>>24;
								if($opacity<127){
									$left=$sx-$m['start']+$x;
									$py=$sy+$y;
									if($py>$this->Height) break;
									for($px=min($left,$this->Width-1);$px>$left-200 && $px>=0;$px-=1){
										$color=imagecolorat($img, $px, $py) & 0xff;
										if($color+$opacity<170){ // 170 - threshold
											if($shift>$left-$px){
												$shift=$left-$px;
											}
											break;
										}
									}
									break;
								}
							}
						}
						if($shift==10000){
							$shift=mt_rand(4,6);
						}

					}
				}else{
					$shift=1;
				}
				imagecopy($img, $font, $x-$shift, $y, $m['start'], 1, $m['end']-$m['start'], $fontfile_height);
				$x+=$m['end']-$m['start']-$shift;
			}
		}while($x>=$this->Width-10); // while not fit in canvas

		//noise
		$white=imagecolorallocate($font, 255, 255, 255);
		$black=imagecolorallocate($font, 0, 0, 0);
		for($i=0;$i<(($this->Height-30)*$x)*$white_noise_density;$i++){
			imagesetpixel($img, mt_rand(0, $x-1), mt_rand(10, $this->Height-15), $white);
		}
		for($i=0;$i<(($this->Height-30)*$x)*$black_noise_density;$i++){
			imagesetpixel($img, mt_rand(0, $x-1), mt_rand(10, $this->Height-15), $black);
		}

		$center=$x/2;

		// credits. To remove, see configuration file
		$this->Image=imagecreatetruecolor($this->Width, $this->Height);
		$foreground=imagecolorallocate($this->Image, $this->Foreground[0], $this->Foreground[1], $this->Foreground[2]);
		$background=imagecolorallocate($this->Image, $this->Background[0], $this->Background[1], $this->Background[2]);
		imagefilledrectangle($this->Image, 0, 0, $this->Width-1, $this->Height-1, $background);		
		imagefilledrectangle($this->Image, 0, $this->Height, $this->Width-1, $this->Height+12, $foreground);

		// periods
		$rand1=mt_rand(750000,1200000)/10000000;
		$rand2=mt_rand(750000,1200000)/10000000;
		$rand3=mt_rand(750000,1200000)/10000000;
		$rand4=mt_rand(750000,1200000)/10000000;
		// phases
		$rand5=mt_rand(0,31415926)/10000000;
		$rand6=mt_rand(0,31415926)/10000000;
		$rand7=mt_rand(0,31415926)/10000000;
		$rand8=mt_rand(0,31415926)/10000000;
		// amplitudes
		$rand9=mt_rand(330,420)/110;
		$rand10=mt_rand(330,450)/100;

		//wave distortion

		for($x=0;$x<$this->Width;$x++){
			for($y=0;$y<$this->Height;$y++){
				$sx=$x+(sin($x*$rand1+$rand5)+sin($y*$rand3+$rand6))*$rand9-$this->Width/2+$center+1;
				$sy=$y+(sin($x*$rand2+$rand7)+sin($y*$rand4+$rand8))*$rand10;

				if($sx<0 || $sy<0 || $sx>=$this->Width-1 || $sy>=$this->Height-1){
					continue;
				}else{
					$color=imagecolorat($img, $sx, $sy) & 0xFF;
					$color_x=imagecolorat($img, $sx+1, $sy) & 0xFF;
					$color_y=imagecolorat($img, $sx, $sy+1) & 0xFF;
					$color_xy=imagecolorat($img, $sx+1, $sy+1) & 0xFF;
				}

				if($color==255 && $color_x==255 && $color_y==255 && $color_xy==255){
					continue;
				}else if($color==0 && $color_x==0 && $color_y==0 && $color_xy==0){
					$newred=$this->Foreground[0];
					$newgreen=$this->Foreground[1];
					$newblue=$this->Foreground[2];
				}else{
					$frsx=$sx-floor($sx);
					$frsy=$sy-floor($sy);
					$frsx1=1-$frsx;
					$frsy1=1-$frsy;

					$newcolor=(
						$color*$frsx1*$frsy1+
						$color_x*$frsx*$frsy1+
						$color_y*$frsx1*$frsy+
						$color_xy*$frsx*$frsy);

					if($newcolor>255) $newcolor=255;
					$newcolor=$newcolor/255;
					$newcolor0=1-$newcolor;

					$newred=$newcolor0*$this->Foreground[0]+$newcolor*$this->Background[0];
					$newgreen=$newcolor0*$this->Foreground[1]+$newcolor*$this->Background[1];
					$newblue=$newcolor0*$this->Foreground[2]+$newcolor*$this->Background[2];
				}

				imagesetpixel($this->Image, $x, $y, imagecolorallocate($this->Image, $newred, $newgreen, $newblue));
			}
		}
	}
	public function Send($inRequest)
	{
		$WebRequest = $inRequest->getWebRequest();
		if($this->Image == NULL)
		{
			$this->GenImage();
		}
		$WebRequest->SendHeader('Expires', 'Mon, 26 Jul 1997 05:00:00 GMT');
		$WebRequest->SendHeader('Cache-Control', 'no-store, no-cache, must-revalidate');
		$WebRequest->SendHeader('Cache-Control', 'post-check=0, pre-check=0');
		$WebRequest->SendHeader('Pragma', 'no-cache');
		if(function_exists("imagejpeg"))
		{
			$WebRequest->SendHeader('Content-type', 'image/jpeg');
			imagejpeg($this->Image, NULL, 90);
		}
		else if(function_exists("imagepng"))
		{
			$WebRequest->SendHeader('Content-type', 'image/png');
			imagepng($this->Image);
		}
	}

}