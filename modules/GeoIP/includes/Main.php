<?php /*************************************************************************
*  S.PHP5:                                          © 2013 Selivanovskikh M.G. *
* charset: UTF-8                                                               *
* created: 2013.02.01                                                          *
*    path: \Modules\GEO\Main.php                                               *
*                                                                              *
*******************************************************************************/
namespace Modules\GEO;
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}
/******************************************************************************/
/*
//Активити по умолчанию
$system->addController('', function($inSession, $inResponce) {
});*/
/*
$system->addActivity('geo', function($inSystem, $inSession) {
	$client = $inSession->GetClient();
	$responce = new \Net\Response();
	$responce->AddBody(
	'<!DOCTYPE html><html><head>'.
	'<meta content="text/html; charset=UTF-8" http-equiv="content-type"></head>'.
	'<body style="background-color: #EEEEEE;">Русский<br/>'.$client->GetAuthUser().'<br/>'.$client->GetSectPathCount().'<br/>'.$client->GetSectPath(1).'<br/>'.$client->GetGET().'</body></html>'.
	'<img alt="captcha" src="/captcha" / style="border: 1px solid #777777;">'
	);
	$client->SendResponse($responce);
});*/

//$system->install->listen('EvtCheckInstall');
//$system->install->listen('EvtInstall');
//echo 'GeoIP<br/>';

class GeoIP extends \System\Object
{
	protected $System = NULL;
	protected $Base = NULL;
	
	protected function construct($inSystem = NULL)
	{
        call_user_func_array('parent::construct',func_get_args());
		$this->System = $inSystem;
		$this->System->Listen('EvtRequest',array($this,'onRequest'));
		$this->Base = $this->System->getBase();
		if($this->Base !== NULL) {
			$query = 'SELECT COUNT(*) FROM {geoip};';
			$result = $this->Base->execute($query);
			if($result->fetchValue()<1) {
				$this->update($this->Base);
			}
		}
	}
	
	public function onRequest($inRequest)
	{
		if($this->Base === NULL) {
			return;
		}
		/*if($inRequest->getWebRequest()->getSectPath(2)!='dyn'){
			return;
		}*/
		if($inRequest->getWebRequest()->getSectPath(1)!='geoip.js'){
			return;
		}
		/*$f = fopen('data/log/access.log','r');
		$query = 'INSERT INTO {queries} VALUES (:sid, :uid, :date, :ip, :query, :user_agent)';
		while(($row = fgets($f))!==FALSE) {
			$row = trim($row);
			if($row=='') {
				continue;
			}
			$row = explode(' ', $row);
			$this->Base->execute($query,array(
				'sid'        => 'ABCD123456789',
				'uid'        => '2000',
				'date'       => '1419941218',
				'ip'         => $row[0],
				'query'      => '/',
				'user_agent' => 'UNKNOWN'
			));
		}
		fclose($f);*/
		
		
		
		//$ip = '37.49.224.251';
		//$ip = $inRequest->getWebClient()->getAddress();
		//$ip = explode('.', $ip);
		//$bip = ((((($ip[0] * 256) + $ip[1]) * 256) +  $ip[2]) * 256) + $ip[3];
		//$query = 'SELECT t1.country, t2.city, t2.region, t2.district, t2.lat, t2.lng FROM {geoip} t1 LEFT JOIN {geoip_cities} t2 ON t1.city_id = t2.city_id WHERE t1.start_block < :start_block  and t1.end_block > :end_block;';
		//$query = 'SELECT CODE FROM {countries} LEFT JOIN {continents} ON continent_id = id ORDER BY continent';
		$query = 'SELECT ip FROM {queries} group by ip';
		$ips = array();
		$result = $this->Base->execute($query);
		while(($row = $result->fetchArray()) !==FALSE) {
			$ip = explode('.', $row[0]);
			$ips[] = array(
				$row[0],
				((((($ip[0] * 256) + $ip[1]) * 256) +  $ip[2]) * 256) + $ip[3]
			);
		}
		$couns = array();
		$query = 'SELECT t1.country, t2.country FROM {geoip} t1 LEFT JOIN {countries} t2 ON t1.country = t2.code WHERE t1.start_block < :start_block  and t1.end_block > :end_block;';
		foreach($ips as $bip) {
			$result = $this->Base->execute($query, array(
				'start_block' => $bip[1],
				'end_block' => $bip[1]
			));
			$row = $result->fetchArray();
			if(!array_key_exists($row[0], $couns)) {
				$couns[$row[0]] = array(
					'counts'  => 1,
					'code'    => $row[0],
					'country' => $row[1],
					'ips' => $bip[0],
				);
			}
			$couns[$row[0]]['counts']++;
			$couns[$row[0]]['ips'] .= ', '.$bip[0];
		}
		
		echo'google.load("visualization", "1", {packages:["geochart"]}); ';
		echo'google.setOnLoadCallback(drawRegionsMap); ';
		echo'function drawRegionsMap() { ';
        echo'var data = google.visualization.arrayToDataTable([ ';
		echo'[\'Country\', \'Страна\',\'Посетителей\'],';
		$i=0;
		foreach($couns as $coun => $v) {
			/*if($v['code'] == ''){
				echo $v['ips'];
			}*/
			if($i!=0){echo', ';}
			echo '[\''.$v['code'].'\', \''.$v['country'].'\', '.$v['counts'].']';
			$i++;
		}
		
        echo']); ';
        echo'var options = { ';
			//displayMode: 'text',
		echo'  colorAxis: {colors: [\'#AAFFAA\', \'004400\']}, ';
		echo'  backgroundColor: \'#FFFFFF\', ';
		echo'  datalessRegionColor: \'#EEEEEE\' ';
        echo'}; ';
        echo'var chart = new google.visualization.GeoChart(document.getElementById(\'regions_div\')); ';
        echo'chart.draw(data, options); ';
      echo'}';
		
		
		exit;
		
		/*$result = $this->Base->execute($query, array(
			'start_block' => $bip,
			'end_block' => $bip
		));
		$i = 0;
		while(($row = $result->fetchArray()) !==FALSE) {
			$i++;
			echo '[\''.$row[0].'\', '.($i*100).'],';
		}
		$row = $result->fetchArray();
		echo'<meta charset="UTF-8">';
		var_dump($row);exit;*/
	}
	
	protected function update($base)
	{
		
		$cidr = ROOT.DS.'data'.DS.'geoip'.DS.'cidr_optim.txt';
		$cities = ROOT.DS.'data'.DS.'geoip'.DS.'cities.txt';
		if( (!file_exists($cidr)) or (!file_exists($cities)) ) {
			return;
		}
		$query = 'DELETE FROM {geoip};';
		$base->execute($query);
		$query = 'DELETE FROM {geoip_cities};';
		$base->execute($query);

		$f = fopen($cities,'r');
		$base->enableLog(FALSE);
		$base->begin();
		$query = 'INSERT INTO {geoip_cities} VALUES (:city_id, :city, :region, :district, :lat, :lng)';
		while(($row = fgets($f))!==FALSE)
		{
			$row = trim(iconv('cp1251', 'utf-8',$row));
			if($row=='') {
				continue;
			}
			$row = explode(chr(9), $row);
			$base->execute($query,array(
				'city_id'  => $row[0],
				'city'     => $row[1],
				'region'   => $row[2],
				'district' => $row[3],
				'lat'      => $row[4],
				'lng'      => $row[5]
			));
			unset($row);
		}
		$base->commit();
		fclose($f);
		$f = fopen($cidr,'r');
		$base->begin();
		$query = 'INSERT INTO {geoip} VALUES (:start_block, :end_block, :block, :country, :city_id)';
		while(($row = fgets($f))!==FALSE) {
			$row = trim($row);
			if($row=='') {
				continue;
			}
			$row = explode(chr(9), $row);
			$base->execute($query, array(
				'start_block' => $row[0],
				'end_block'   => $row[1],
				'block'       => $row[2],
				'country'     => $row[3],
				'city_id'     => $row[4] == '-' ? NULL : $row[4]
			));
			unset($row);
		}
		$base->commit();
		fclose($f);
		$base->enableLog(TRUE);

	}
}

$g = new GeoIP($system);





/*$system->Listen('EvtSessionResponse',
	//array($this,'OnNewSession')
	function($inSession, $inResponce)
	{
		$client = $inSession->GetClient();
		
        $inResponce->AddBody(
        '<!DOCTYPE html><html><head>'.
        '<meta content="text/html; charset=UTF-8" http-equiv="content-type"></head>'.
        '<body>Русский<br/>'.$client->GetAuthUser().'<br/>'.$client->GetSectPathCount().'<br/>'.$client->GetSectPath(1).'<br/>'.$client->GetGET().'</body></html>');
        
        $client->SendResponse($inResponce);
	}
);*/