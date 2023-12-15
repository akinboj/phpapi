<?php

/** Create HTTP POST */
$accomm = 'ACCOMM';
$media = 'Yes';
$place = 'Melbourne';

$category = "";
if(isset($_GET['category'])){ $category = htmlspecialchars($_GET['category']); }

//$place = htmlspecialchars($_GET['cityname']);

$page = '10';



$seek = '<parameters> 
<row><param>PRODUCT_CATEGORY_LIST</param><value>'. $accomm .'</value></row> 
<row><param>SUBURB_OR_CITY</param><value>'. $place .'</value></row>
<row><param>PRODUCT_CLASSIFICATION</param><value>'.$category.'</value></row>
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

/** Instantiate Loop */

foreach ($result->total_records_found as $total) {
	
	// Declare if statement to parse cities with no records
	
	if ($total == 0) {
	echo 'Sorry there are no results found for this location'.'<br/><br/>';
	break;
	}
	
foreach ($result->product_distribution as $entry) {
    
	$pna = htmlspecialchars_decode($entry->product_record->product_name, ENT_QUOTES);
	$pna = str_replace("'", "'", $pna);
	
	$str = htmlspecialchars_decode($entry->product_record->product_description, ENT_QUOTES);
	$str = str_replace("'", "'", $str);
	
	// Instantiate images
	$image = $entry->product_multimedia->row->server_path;
	
	// Instantiate video
	$vid = $entry->product_multimedia->row->attribute_id_multimedia_file;
	
	echo  $pna. "<br /><br />";
    echo  $str . "<br /><br />";
	echo '<a href='.$image.'>'.$image.'</a>'. "<br /><br />";
	
	// Declare if statement to return media either as video or images
	if ($vid == '.YTV') {
		
		// Embed youtube video on the webpage
		preg_match(
        '/[\\?\\&]v=([^\\?\\&]+)/',
        $image,
        $matches
		);
		$id = $matches[1];
 
		$width = '400';
		$height = '300';
		echo '<object width="' . $width . '" height="' . $height . '"><param name="movie" value="http://www.youtube.com/v/' . $id . '&amp;hl=en_US&amp;fs=1?rel=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/' . $id . '&amp;hl=en_US&amp;fs=1?rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="' . $width . '" height="' . $height . '"></embed></object>'. "<br /><br />";
		}

	
	else {
		echo '<img src='.$image.' />'. "<br /><br />";
		}
		

}

}

?>

