<?php
if(!defined('SOURCES')){header("Location: http://".getenv('HTTP_HOST'));exit;}

$tables[] = array(
	'name'   => 'countries',
	'struct' => array(
		'continent_id'  => 'integer',
		'code'          => 'varchar',
		'country'       => 'varchar',
	),
	
/******************
 * Northern Africa
 ******************/
	'rows' => array(
		array(
			'continent_id' => '015',
			'code'         => 'DZ',
			'country'      => 'Algeria'
		),
		array(
			'continent_id' => '015',
			'code'         => 'EG',
			'country'      => 'Egypt'
		),
		array(
			'continent_id' => '015',
			'code'         => 'EH',
			'country'      => 'Western Sahara'
		),
		array(
			'continent_id' => '015',
			'code'         => 'LY',
			'country'      => 'Libya'
		),
		array(
			'continent_id' => '015',
			'code'         => 'MA',
			'country'      => 'Morocco'
		),
		array(
			'continent_id' => '015',
			'code'         => 'SD',
			'country'      => 'Sudan'
		),
		array(
			'continent_id' => '015',
			'code'         => 'TN',
			'country'      => 'Tunisia'
		),
/******************
 * Western Africa
 ******************/
		array(
			'continent_id' => '011',
			'code'         => 'BF',
			'country'      => 'Burkina Faso'
		),
		array(
			'continent_id' => '011',
			'code'         => 'BJ',
			'country'      => 'Benin'
		),
		array(
			'continent_id' => '011',
			'code'         => 'CI',
			'country'      => 'Ivory Coast'
		),
		array(
			'continent_id' => '011',
			'code'         => 'CV',
			'country'      => 'Cabo Verde'
		),
		array(
			'continent_id' => '011',
			'code'         => 'GH',
			'country'      => 'Ghana'
		),
		array(
			'continent_id' => '011',
			'code'         => 'GM',
			'country'      => 'Gambia'
		),
		array(
			'continent_id' => '011',
			'code'         => 'GN',
			'country'      => 'Guinea'
		),
		array(
			'continent_id' => '011',
			'code'         => 'GW',
			'country'      => 'Guinea-Bissau'
		),
		array(
			'continent_id' => '011',
			'code'         => 'LR',
			'country'      => 'Liberia'
		),
		array(
			'continent_id' => '011',
			'code'         => 'ML',
			'country'      => 'Mali'
		),
		array(
			'continent_id' => '011',
			'code'         => 'MR',
			'country'      => 'Mauritania'
		),
		array(
			'continent_id' => '011',
			'code'         => 'NE',
			'country'      => 'Niger'
		),
		array(
			'continent_id' => '011',
			'code'         => 'NG',
			'country'      => 'Nigeria'
		),
		array(
			'continent_id' => '011',
			'code'         => 'SH',
			'country'      => 'Saint Helena, Ascension and Tristan da Cunha'
		),
		array(
			'continent_id' => '011',
			'code'         => 'SL',
			'country'      => 'Sierra Leone'
		),
		array(
			'continent_id' => '011',
			'code'         => 'SN',
			'country'      => 'Senegal'
		),
		array(
			'continent_id' => '011',
			'code'         => 'TG',
			'country'      => 'Togo'
		),
		
		
/******************
 * Middle Africa
 ******************/
		array(
			'continent_id' => '017',
			'code'         => 'AO',
			'country'      => 'Angola'
		),
		array(
			'continent_id' => '017',
			'code'         => 'CD',
			'country'      => 'Democratic Republic of the Congo'
		),
		array(
			'continent_id' => '017',
			'code'         => 'ZR',
			'country'      => 'Zaire'
		),
		array(
			'continent_id' => '017',
			'code'         => 'CF',
			'country'      => 'Central African Republic'
		),
		array(
			'continent_id' => '017',
			'code'         => 'CG',
			'country'      => 'Congo'
		),
		array(
			'continent_id' => '017',
			'code'         => 'CM',
			'country'      => 'Cameroon'
		),
		array(
			'continent_id' => '017',
			'code'         => 'GA',
			'country'      => 'Gabon'
		),
		array(
			'continent_id' => '017',
			'code'         => 'GQ',
			'country'      => 'Equatorial Guinea'
		),
		array(
			'continent_id' => '017',
			'code'         => 'ST',
			'country'      => 'Sao Tome and Principe'
		),
		array(
			'continent_id' => '017',
			'code'         => 'TD',
			'country'      => 'Chad'
		),
		
/******************
 * Eastern Africa
 ******************/
		array(
			'continent_id' => '014',
			'code'         => 'BI',
			'country'      => 'Burundi'
		),
		array(
			'continent_id' => '014',
			'code'         => 'DJ',
			'country'      => 'Djibouti'
		),
		array(
			'continent_id' => '014',
			'code'         => 'ER',
			'country'      => 'Eritrea'
		),
		array(
			'continent_id' => '014',
			'code'         => 'ET',
			'country'      => 'Ethiopia'
		),
		array(
			'continent_id' => '014',
			'code'         => 'KE',
			'country'      => 'Kenya'
		),
		array(
			'continent_id' => '014',
			'code'         => 'KM',
			'country'      => 'Comoros'
		),
		array(
			'continent_id' => '014',
			'code'         => 'MG',
			'country'      => 'Madagascar'
		),
		array(
			'continent_id' => '014',
			'code'         => 'MU',
			'country'      => 'Mauritius'
		),
		array(
			'continent_id' => '014',
			'code'         => 'MW',
			'country'      => 'Malawi'
		),
		array(
			'continent_id' => '014',
			'code'         => 'MZ',
			'country'      => 'Mozambique'
		),
		array(
			'continent_id' => '014',
			'code'         => 'RE',
			'country'      => 'Réunion'
		),
		array(
			'continent_id' => '014',
			'code'         => 'RW',
			'country'      => 'Rwanda'
		),
		array(
			'continent_id' => '014',
			'code'         => 'SC',
			'country'      => 'Seychelles'
		),
		array(
			'continent_id' => '014',
			'code'         => 'SO',
			'country'      => 'Somalia'
		),
		array(
			'continent_id' => '014',
			'code'         => 'TZ',
			'country'      => 'Tanzania'
		),
		array(
			'continent_id' => '014',
			'code'         => 'UG',
			'country'      => 'Uganda'
		),
		array(
			'continent_id' => '014',
			'code'         => 'YT',
			'country'      => 'Mayotte'
		),
		array(
			'continent_id' => '014',
			'code'         => 'ZM',
			'country'      => 'Zambia'
		),
		array(
			'continent_id' => '014',
			'code'         => 'ZW',
			'country'      => 'Zimbabwe'
		),
		
/******************
 * Southern Africa
 ******************/
		array(
			'continent_id' => '018',
			'code'         => 'BW',
			'country'      => 'Botswana'
		),
		array(
			'continent_id' => '018',
			'code'         => 'LS',
			'country'      => 'Lesotho'
		),
		array(
			'continent_id' => '018',
			'code'         => 'NA',
			'country'      => 'Namibia'
		),
		array(
			'continent_id' => '018',
			'code'         => 'SZ',
			'country'      => 'Swaziland'
		),
		array(
			'continent_id' => '018',
			'code'         => 'ZA',
			'country'      => 'South Africa'
		),
/******************
 * Northern Europe
 ******************/
		array(
			'continent_id' => '154',
			'code'         => 'GG',
			'country'      => 'Guernsey'
		),
		array(
			'continent_id' => '154',
			'code'         => 'JE',
			'country'      => 'Jersey'
		),
		array(
			'continent_id' => '154',
			'code'         => 'AX',
			'country'      => 'Åland Islands'
		),
		array(
			'continent_id' => '154',
			'code'         => 'DK',
			'country'      => 'Denmark'
		),
		array(
			'continent_id' => '154',
			'code'         => 'EE',
			'country'      => 'Estonia'
		),
		array(
			'continent_id' => '154',
			'code'         => 'FI',
			'country'      => 'Finland'
		),
		array(
			'continent_id' => '154',
			'code'         => 'FO',
			'country'      => 'Faroe Islands'
		),
		array(
			'continent_id' => '154',
			'code'         => 'GB',
			'country'      => 'United Kingdom'
		),
		array(
			'continent_id' => '154',
			'code'         => 'IE',
			'country'      => 'Ireland'
		),
		array(
			'continent_id' => '154',
			'code'         => 'IM',
			'country'      => 'Isle of Man'
		),
		array(
			'continent_id' => '154',
			'code'         => 'IS',
			'country'      => 'Iceland'
		),
		array(
			'continent_id' => '154',
			'code'         => 'LT',
			'country'      => 'Lithuania'
		),
		array(
			'continent_id' => '154',
			'code'         => 'LV',
			'country'      => 'Latvia'
		),
		array(
			'continent_id' => '154',
			'code'         => 'NO',
			'country'      => 'Norway'
		),
		array(
			'continent_id' => '154',
			'code'         => 'SE',
			'country'      => 'Sweden'
		),
		array(
			'continent_id' => '154',
			'code'         => 'SJ',
			'country'      => 'Svalbard and Jan Mayen'
		),
		
/******************
 * Western Europe
 ******************/
		array(
			'continent_id' => '155',
			'code'         => 'AT',
			'country'      => 'Austria'
		),
		array(
			'continent_id' => '155',
			'code'         => 'BE',
			'country'      => 'Belgium'
		),
		array(
			'continent_id' => '155',
			'code'         => 'CH',
			'country'      => 'Switzerland'
		),
		array(
			'continent_id' => '155',
			'code'         => 'DE',
			'country'      => 'Germany'
		),
		array(
			'continent_id' => '155',
			'code'         => 'DD',
			'country'      => 'German Democratic Republic'
		),
		array(
			'continent_id' => '155',
			'code'         => 'FR',
			'country'      => 'France'
		),
		array(
			'continent_id' => '155',
			'code'         => 'FX',
			'country'      => 'France, Metropolitan'
		),
		array(
			'continent_id' => '155',
			'code'         => 'LI',
			'country'      => 'Liechtenstein'
		),
		array(
			'continent_id' => '155',
			'code'         => 'LU',
			'country'      => 'Luxembourg'
		),
		array(
			'continent_id' => '155',
			'code'         => 'MC',
			'country'      => 'Monaco'
		),
		array(
			'continent_id' => '155',
			'code'         => 'NL',
			'country'      => 'Netherlands'
		),
/******************
 * Eastern Europe
 ******************/
		array(
			'continent_id' => '151',
			'code'         => 'BG',
			'country'      => 'Bulgaria'
		),
		array(
			'continent_id' => '151',
			'code'         => 'BY',
			'country'      => 'Belarus'
		),
		array(
			'continent_id' => '151',
			'code'         => 'CZ',
			'country'      => 'Czech Republic'
		),
		array(
			'continent_id' => '151',
			'code'         => 'HU',
			'country'      => 'Hungary'
		),
		array(
			'continent_id' => '151',
			'code'         => 'MD',
			'country'      => 'Moldova'
		),
		array(
			'continent_id' => '151',
			'code'         => 'PL',
			'country'      => 'Poland'
		),
		array(
			'continent_id' => '151',
			'code'         => 'RO',
			'country'      => 'Romania'
		),
		array(
			'continent_id' => '151',
			'code'         => 'RU',
			'country'      => 'Russian Federation'
		),
		array(
			'continent_id' => '151',
			'code'         => 'SU',
			'country'      => 'USSR'
		),
		array(
			'continent_id' => '151',
			'code'         => 'SK',
			'country'      => 'Slovakia'
		),
		array(
			'continent_id' => '151',
			'code'         => 'UA',
			'country'      => 'Ukraine'
		),
		
/******************
 * Southern Europe
 ******************/
		array(
			'continent_id' => '039',
			'code'         => 'AD',
			'country'      => ''
		),
		array(
			'continent_id' => '039',
			'code'         => 'AL',
			'country'      => ''
		),
		array(
			'continent_id' => '039',
			'code'         => 'BA',
			'country'      => ''
		),
		array(
			'continent_id' => '039',
			'code'         => 'ES',
			'country'      => ''
		),
		array(
			'continent_id' => '039',
			'code'         => 'GI',
			'country'      => ''
		),
		array(
			'continent_id' => '039',
			'code'         => 'GR',
			'country'      => ''
		),
		array(
			'continent_id' => '039',
			'code'         => 'HR',
			'country'      => ''
		),
		array(
			'continent_id' => '039',
			'code'         => 'IT',
			'country'      => ''
		),
		array(
			'continent_id' => '039',
			'code'         => 'ME',
			'country'      => ''
		),
		array(
			'continent_id' => '039',
			'code'         => 'MK',
			'country'      => ''
		),
		array(
			'continent_id' => '039',
			'code'         => 'MT',
			'country'      => ''
		),
		array(
			'continent_id' => '039',
			'code'         => 'CS',
			'country'      => ''
		),
		array(
			'continent_id' => '039',
			'code'         => 'RS',
			'country'      => ''
		),
		array(
			'continent_id' => '039',
			'code'         => 'PT',
			'country'      => ''
		),
		array(
			'continent_id' => '039',
			'code'         => 'SI',
			'country'      => ''
		),
		array(
			'continent_id' => '039',
			'code'         => 'SM',
			'country'      => ''
		),
		array(
			'continent_id' => '039',
			'code'         => 'VA',
			'country'      => ''
		),
		array(
			'continent_id' => '039',
			'code'         => 'YU',
			'country'      => ''
		),
		
		
		
/******************
 * Northern America
 ******************/
		array(
			'continent_id' => '021',
			'code'         => 'BM',
			'country'      => ''
		),
		array(
			'continent_id' => '021',
			'code'         => 'CA',
			'country'      => ''
		),
		array(
			'continent_id' => '021',
			'code'         => 'GL',
			'country'      => ''
		),
		array(
			'continent_id' => '021',
			'code'         => 'PM',
			'country'      => ''
		),
		array(
			'continent_id' => '021',
			'code'         => 'US',
			'country'      => ''
		),
		
/******************
 * Caribbean
 ******************/
		array(
			'continent_id' => '029',
			'code'         => 'AG',
			'country'      => 'Antigua and Barbuda'
		),
		array(
			'continent_id' => '029',
			'code'         => 'AI',
			'country'      => 'Anguilla'
		),
		array(
			'continent_id' => '029',
			'code'         => 'AN',
			'country'      => 'Netherlands Antilles'
		),
		array(
			'continent_id' => '029',
			'code'         => 'AW',
			'country'      => 'Aruba'
		),
		array(
			'continent_id' => '029',
			'code'         => 'BB',
			'country'      => 'Barbados'
		),
		array(
			'continent_id' => '029',
			'code'         => 'BL',
			'country'      => 'Saint Barthélemy'
		),
		array(
			'continent_id' => '029',
			'code'         => 'BS',
			'country'      => 'Bahamas'
		),
		array(
			'continent_id' => '029',
			'code'         => 'CU',
			'country'      => 'Cuba'
		),
		array(
			'continent_id' => '029',
			'code'         => 'DM',
			'country'      => 'Dominica'
		),
		array(
			'continent_id' => '029',
			'code'         => 'DO',
			'country'      => 'Dominican Republic'
		),
		array(
			'continent_id' => '029',
			'code'         => 'GD',
			'country'      => ''
		),
		array(
			'continent_id' => '029',
			'code'         => 'GP',
			'country'      => ''
		),
		array(
			'continent_id' => '029',
			'code'         => 'HT',
			'country'      => ''
		),
		array(
			'continent_id' => '029',
			'code'         => 'JM',
			'country'      => ''
		),
		array(
			'continent_id' => '029',
			'code'         => 'KN',
			'country'      => ''
		),
		array(
			'continent_id' => '029',
			'code'         => 'KY',
			'country'      => ''
		),
		array(
			'continent_id' => '029',
			'code'         => 'LC',
			'country'      => ''
		),
		array(
			'continent_id' => '029',
			'code'         => 'MF',
			'country'      => ''
		),
		array(
			'continent_id' => '029',
			'code'         => 'MQ',
			'country'      => ''
		),
		array(
			'continent_id' => '029',
			'code'         => 'MS',
			'country'      => ''
		),
		array(
			'continent_id' => '029',
			'code'         => 'PR',
			'country'      => ''
		),
		array(
			'continent_id' => '029',
			'code'         => 'TC',
			'country'      => ''
		),
		array(
			'continent_id' => '029',
			'code'         => 'TT',
			'country'      => ''
		),
		array(
			'continent_id' => '029',
			'code'         => 'VC',
			'country'      => ''
		),
		array(
			'continent_id' => '029',
			'code'         => 'VG',
			'country'      => ''
		),
		array(
			'continent_id' => '029',
			'code'         => 'VI',
			'country'      => ''
		),
/******************
 * Central America
 ******************/
		array(
			'continent_id' => '013',
			'code'         => 'BZ',
			'country'      => ''
		),
		array(
			'continent_id' => '013',
			'code'         => 'CR',
			'country'      => ''
		),
		array(
			'continent_id' => '013',
			'code'         => 'GT',
			'country'      => ''
		),
		array(
			'continent_id' => '013',
			'code'         => 'HN',
			'country'      => ''
		),
		array(
			'continent_id' => '013',
			'code'         => 'MX',
			'country'      => ''
		),
		array(
			'continent_id' => '013',
			'code'         => 'NI',
			'country'      => ''
		),
		array(
			'continent_id' => '013',
			'code'         => 'PA',
			'country'      => ''
		),
		array(
			'continent_id' => '013',
			'code'         => 'SV',
			'country'      => ''
		),
		
		
/******************
 * South America
 ******************/
		array(
			'continent_id' => '005',
			'code'         => 'AR',
			'country'      => ''
		),
		array(
			'continent_id' => '005',
			'code'         => 'BO',
			'country'      => ''
		),
		array(
			'continent_id' => '005',
			'code'         => 'BR',
			'country'      => ''
		),
		array(
			'continent_id' => '005',
			'code'         => 'CL',
			'country'      => ''
		),
		array(
			'continent_id' => '005',
			'code'         => 'CO',
			'country'      => ''
		),
		array(
			'continent_id' => '005',
			'code'         => 'EC',
			'country'      => ''
		),
		array(
			'continent_id' => '005',
			'code'         => 'FK',
			'country'      => ''
		),
		array(
			'continent_id' => '005',
			'code'         => 'GF',
			'country'      => ''
		),
		array(
			'continent_id' => '005',
			'code'         => 'GY',
			'country'      => ''
		),
		array(
			'continent_id' => '005',
			'code'         => 'PE',
			'country'      => ''
		),
		array(
			'continent_id' => '005',
			'code'         => 'PY',
			'country'      => ''
		),
		array(
			'continent_id' => '005',
			'code'         => 'SR',
			'country'      => ''
		),
		array(
			'continent_id' => '005',
			'code'         => 'UY',
			'country'      => ''
		),
		array(
			'continent_id' => '005',
			'code'         => 'VE',
			'country'      => ''
		),
		
		
		
/******************
 * Central Asia
 ******************/
		array(
			'continent_id' => '143',
			'code'         => 'TM',
			'country'      => ''
		),
		array(
			'continent_id' => '143',
			'code'         => 'TJ',
			'country'      => ''
		),
		array(
			'continent_id' => '143',
			'code'         => 'KG',
			'country'      => ''
		),
		array(
			'continent_id' => '143',
			'code'         => 'KZ',
			'country'      => ''
		),
		array(
			'continent_id' => '143',
			'code'         => 'UZ',
			'country'      => ''
		),
		
		
/******************
 * Eastern Asia
 ******************/
		array(
			'continent_id' => '030',
			'code'         => 'CN',
			'country'      => ''
		),
		array(
			'continent_id' => '030',
			'code'         => 'HK',
			'country'      => ''
		),
		array(
			'continent_id' => '030',
			'code'         => 'JP',
			'country'      => ''
		),
		array(
			'continent_id' => '030',
			'code'         => 'KP',
			'country'      => ''
		),
		array(
			'continent_id' => '030',
			'code'         => 'KR',
			'country'      => ''
		),
		array(
			'continent_id' => '030',
			'code'         => 'MN',
			'country'      => ''
		),
		array(
			'continent_id' => '030',
			'code'         => 'MO',
			'country'      => ''
		),
		array(
			'continent_id' => '030',
			'code'         => 'TW',
			'country'      => ''
		),

/******************
 * Southern Asia
 ******************/
		array(
			'continent_id' => '034',
			'code'         => 'AF',
			'country'      => ''
		),
		array(
			'continent_id' => '034',
			'code'         => 'BD',
			'country'      => ''
		),
		array(
			'continent_id' => '034',
			'code'         => 'BT',
			'country'      => ''
		),
		array(
			'continent_id' => '034',
			'code'         => 'IN',
			'country'      => ''
		),
		array(
			'continent_id' => '034',
			'code'         => 'IR',
			'country'      => ''
		),
		array(
			'continent_id' => '034',
			'code'         => 'LK',
			'country'      => ''
		),
		array(
			'continent_id' => '034',
			'code'         => 'MV',
			'country'      => ''
		),
		array(
			'continent_id' => '034',
			'code'         => 'NP',
			'country'      => ''
		),
		array(
			'continent_id' => '034',
			'code'         => 'PK',
			'country'      => ''
		),
/******************
 * South-Eastern Asia
 ******************/
		array(
			'continent_id' => '035',
			'code'         => 'BN',
			'country'      => ''
		),
		array(
			'continent_id' => '035',
			'code'         => 'ID',
			'country'      => ''
		),
		array(
			'continent_id' => '035',
			'code'         => 'KH',
			'country'      => ''
		),
		array(
			'continent_id' => '035',
			'code'         => 'LA',
			'country'      => ''
		),
		array(
			'continent_id' => '035',
			'code'         => 'MM',
			'country'      => ''
		),
		array(
			'continent_id' => '035',
			'code'         => 'BU',
			'country'      => ''
		),
		array(
			'continent_id' => '035',
			'code'         => 'MY',
			'country'      => ''
		),
		array(
			'continent_id' => '035',
			'code'         => 'PH',
			'country'      => ''
		),
		array(
			'continent_id' => '035',
			'code'         => 'SG',
			'country'      => ''
		),
		array(
			'continent_id' => '035',
			'code'         => 'TH',
			'country'      => ''
		),
		array(
			'continent_id' => '035',
			'code'         => 'TL',
			'country'      => ''
		),
		array(
			'continent_id' => '035',
			'code'         => 'TP',
			'country'      => ''
		),
		array(
			'continent_id' => '035',
			'code'         => 'VN',
			'country'      => ''
		),
		
/******************
 * Western Asia
 ******************/
		array(
			'continent_id' => '145',
			'code'         => 'AE',
			'country'      => ''
		),
		array(
			'continent_id' => '145',
			'code'         => 'AM',
			'country'      => ''
		),
		array(
			'continent_id' => '145',
			'code'         => 'AZ',
			'country'      => ''
		),
		array(
			'continent_id' => '145',
			'code'         => 'BH',
			'country'      => ''
		),
		array(
			'continent_id' => '145',
			'code'         => 'CY',
			'country'      => ''
		),
		array(
			'continent_id' => '145',
			'code'         => 'GE',
			'country'      => ''
		),
		array(
			'continent_id' => '145',
			'code'         => 'IL',
			'country'      => ''
		),
		array(
			'continent_id' => '145',
			'code'         => 'IQ',
			'country'      => ''
		),
		array(
			'continent_id' => '145',
			'code'         => 'JO',
			'country'      => ''
		),
		array(
			'continent_id' => '145',
			'code'         => 'KW',
			'country'      => ''
		),
		array(
			'continent_id' => '145',
			'code'         => 'LB',
			'country'      => ''
		),
		array(
			'continent_id' => '145',
			'code'         => 'OM',
			'country'      => ''
		),
		array(
			'continent_id' => '145',
			'code'         => 'PS',
			'country'      => ''
		),
		array(
			'continent_id' => '145',
			'code'         => 'QA',
			'country'      => ''
		),
		array(
			'continent_id' => '145',
			'code'         => 'SA',
			'country'      => ''
		),
		array(
			'continent_id' => '145',
			'code'         => 'NT',
			'country'      => ''
		),
		array(
			'continent_id' => '145',
			'code'         => 'SY',
			'country'      => ''
		),
		array(
			'continent_id' => '145',
			'code'         => 'TR',
			'country'      => ''
		),
		array(
			'continent_id' => '145',
			'code'         => 'YE',
			'country'      => ''
		),
		array(
			'continent_id' => '145',
			'code'         => 'YD',
			'country'      => ''
		),
		
		
/******************
 * Australia and New Zealand
 ******************/
		array(
			'continent_id' => '053',
			'code'         => 'AU',
			'country'      => 'Australia'
		),
		array(
			'continent_id' => '053',
			'code'         => 'NF',
			'country'      => 'Norfolk Island'
		),
		array(
			'continent_id' => '053',
			'code'         => 'NZ',
			'country'      => 'New Zealand'
		),
/******************
 * Melanesia
 ******************/
		array(
			'continent_id' => '054',
			'code'         => 'FJ',
			'country'      => 'Fiji'
		),
		array(
			'continent_id' => '054',
			'code'         => 'NC',
			'country'      => 'New Caledonia'
		),
		array(
			'continent_id' => '054',
			'code'         => 'PG',
			'country'      => 'Papua New Guinea'
		),
		array(
			'continent_id' => '054',
			'code'         => 'SB',
			'country'      => 'Solomon Islands'
		),
		array(
			'continent_id' => '054',
			'code'         => 'VU',
			'country'      => 'Vanuatu'
		),
/******************
 * Micronesia
 ******************/
		array(
			'continent_id' => '057',
			'code'         => 'FM',
			'country'      => 'Micronesia'
		),
		array(
			'continent_id' => '057',
			'code'         => 'GU',
			'country'      => 'Guam'
		),
		array(
			'continent_id' => '057',
			'code'         => 'KI',
			'country'      => 'Kiribati'
		),
		array(
			'continent_id' => '057',
			'code'         => 'MH',
			'country'      => 'Marshall Islands'
		),
		array(
			'continent_id' => '057',
			'code'         => 'MP',
			'country'      => 'Northern Mariana Islands'
		),
		array(
			'continent_id' => '057',
			'code'         => 'NR',
			'country'      => 'Nauru'
		),
		array(
			'continent_id' => '057',
			'code'         => 'PW',
			'country'      => 'Palau'
		),
/******************
 * Polynesia
 ******************/
		array(
			'continent_id' => '061',
			'code'         => 'AS',
			'country'      => 'American Samoa'
		),
		array(
			'continent_id' => '061',
			'code'         => 'CK',
			'country'      => 'Cook Islands'
		),
		array(
			'continent_id' => '061',
			'code'         => 'NU',
			'country'      => 'Niue'
		),
		array(
			'continent_id' => '061',
			'code'         => 'PF',
			'country'      => 'French Polynesia'
		),
		array(
			'continent_id' => '061',
			'code'         => 'PN',
			'country'      => 'Pitcairn'
		),
		array(
			'continent_id' => '061',
			'code'         => 'TK',
			'country'      => 'Tokelau'
		),
		array(
			'continent_id' => '061',
			'code'         => 'TO',
			'country'      => 'Tonga'
		),
		array(
			'continent_id' => '061',
			'code'         => 'TV',
			'country'      => 'Tuvalu'
		),
		array(
			'continent_id' => '061',
			'code'         => 'WF',
			'country'      => 'Wallis and Futuna'
		),
		array(
			'continent_id' => '061',
			'code'         => 'WS',
			'country'      => 'Samoa'
		),
	)
);