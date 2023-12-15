<?php

$category = htmlspecialchars($_GET["category"]);

$page = '10';



$seek = '<parameters> 

 
<row><param>PRODUCT_CLASSIFICATION</param><value>'. $category .'</value></row>

<row><param>RESULTS_PER_PAGE</param><value>'. $page .'</value></row>
</parameters>';

$postdata = http_build_query(
	array(
	 'DistributorKey' => '201201100935',
	 'CommandName' => 'QueryProducts',
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

/** Instantiate Loop */

foreach ($result->product_distribution as $entry) {
    
	$pna = htmlspecialchars_decode($entry->product_record->product_name, ENT_QUOTES);
	$pna = str_replace("'", "''", $pna);
	
	$str = htmlspecialchars_decode($entry->product_record->product_description, ENT_QUOTES);
	$str = str_replace("'", "''", $str);
	
	
	echo  $pna. "<br />";
    echo  $str . "<br />";
	
}

?>