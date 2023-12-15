<?php

/** Create HTTP POST */

$accomm = 'ACCOMM';
$state = 'Victoria';
$city = '';
$media = 'Yes';
$area = '';
$page = '10';

$seek = '<parameters> 
<row><param>PRODUCT_CATEGORY_LIST</param><value>'. $accomm .'</value></row> 
<row><param>STATE</param><value>'. $state .'</value></row> 
<row><param>SUBURB_OR_CITY</param><value>'. $city .'</value></row>
<row><param>AREA</param><value><![CDATA[Daylesford & Macedon Ranges]]></value></row>
<row><param>MULTIMEDIA_RETURN</param><value>'. $media .'</value></row>
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
//echo '<pre>'; print_r ($result); echo '</pre>';

/** Instantiate Loop */

foreach ($result->product_distribution as $entry) {
    
	$pna = htmlspecialchars_decode($entry->product_record->product_name, ENT_QUOTES);
	$pna = str_replace("'", "'", $pna);
	
	$str = htmlspecialchars_decode($entry->product_record->product_description, ENT_QUOTES);
	$str = str_replace("'", "'", $str);
	
	$image = $entry->product_multimedia->row->server_path;

	
	
	echo  $pna. "<br /><br />";
    echo  $str . "<br /><br />";
	echo '<a href='.$image.'>'.$image.'</a>'. "<br /><br />";
	echo '<img src='.$image.' />'. "<br /><br />"; 
	
	
}


?>
