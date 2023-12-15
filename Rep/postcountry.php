<?php

/** Create HTTP POST */

$postdata = http_build_query(
  array(
    'DistributorKey' => '201201100935',
    'CommandName' => 'GetCountryStateArea',
	'CommandParameters' => '<parameters><row><param>COUNTRY_NAME</param><value>AUSTRALIA</value></row><row><param>STATE_NAME</param><value>VICTORIA</value></row></parameters>')
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

/** Instantiate Loop */

foreach ($result->country->area as $entry) {
    
	$str = htmlspecialchars_decode($entry->attributes()->area_name, ENT_QUOTES);
	$str = str_replace("'", "''", $str);

	echo  $str . "<br />";
    echo  $entry->attributes()->state_name . "<br />";
	
/** Connect to SQL Server database */

$serverName = "AKINBOJ-PC"; //(serverName\instanceName)


$connectionInfo = array("Database"=>"TSQL2012");
$conn = sqlsrv_connect( $serverName, $connectionInfo);


/** Insert values into table in database */


$sql = "INSERT INTO CountryState (Area, State) VALUES ('" . $str . "', '" . $entry->attributes()->state_name . "')";
$params = array(
				1, "SQLSRV_PHPTYPE_STRING, SQLSRV_SQLTYPE_NVARCHAR(60)",
				2, "SQLSRV_PHPTYPE_STRING, SQLSRV_SQLTYPE_NVARCHAR(60)"
				);

$stmt = sqlsrv_query( $conn, $sql, $params);
if( $stmt === false ) {
     die( print_r( sqlsrv_errors(), true));
}


}

?>