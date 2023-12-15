<?php

/** Create HTTP POST */
$country = 'Australia';
$state = 'Victoria';
$area = 'Melbourne';

$seek = '<parameters> 
<row><param>COUNTRY</param><value>'. $country .'</value></row>
<row><param>STATE</param><value>'. $state .'</value></row>
<row><param>AREA</param><value>'. $area .'</value></row>
</parameters>';

$postdata = http_build_query(
	array(
	 'DistributorKey' => '201201100935',
	 'CommandName' => 'GetCities',
	 'CommandParameters' => $seek)
);
	 
$opts = array(
  'http' => array(
    'method'  => 'POST',
    'header'  => 'Content-type: application/x-www-form-urlencoded',
    'content' => $postdata)
);

/** Get string output of XML (In URL instance) */

$context  = stream_context_create($opts);
$result = file_get_contents('http://national.atdw.com.au/soap/AustralianTourismWebService.asmx/CommandHandler?', false, $context);

/** Change encoding from UTF-16 to Unicode (UTF-8)
	Parse unstructured tags */
	
$result = str_replace('<?xml version="1.0" encoding="utf-8"?>', '', $result);
$result = str_replace('<string xmlns="http://tempuri.org/soap/AustralianTourismWebService">', '', $result);
$result = str_replace('</string>', '', $result);
$result = str_replace('utf-16', 'utf-8', $result);

$result = simplexml_load_string(trim(html_entity_decode($result)), 'SimpleXMLElement');

// Declare array of results //

$citynames = array();
$longitude = array();
$latitude = array();

// Initiate counter

$c = 0;


// Instantiate chunk array value

$citiesperrow = 5;

/** Instantiate Loop for fetching data from API*/

foreach ($result->area->city as $entry) {

	$lat = $entry->attributes()->geocode_gda_latitude;
	$citylat[$c] = $lat;
	$c++;
	
	$long = $entry->attributes()->geocode_gda_longitude;
	$citylong[$c] = $long;
	$c++;
	
	$city = htmlspecialchars_decode((string)$entry, ENT_QUOTES);
	$city = str_replace("'", "'", $city);
	
	$citynames[$c] = $city;
	$c++;
}

/** Instantiate Loop for displaying array values*/

$citydisplay = array_chunk($citynames, $citiesperrow);

$latdisplay = array_chunk($citylat, $citiesperrow);
$arrlat = json_decode( json_encode($latdisplay) , 1);

$longdisplay = array_chunk($citylong, $citiesperrow);
$arrlong = json_decode( json_encode($longdisplay) , 1);

foreach ($citydisplay as $index => $display) {
  echo '<pre>'; print_r ($display[0]); echo '</pre>';
  echo '<pre>'; print_r ($arrlat[$index][0][0]); echo '</pre>';
  echo '<pre>'; print_r ($arrlong[$index][0][0]); echo '</pre>';
}

?>