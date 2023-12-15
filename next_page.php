<?php

/** Create HTTP POST */

$location = "";
if(isset($_GET['cityname'])){ $location = htmlspecialchars($_GET['cityname']); }

$apikey = "";
if(isset($_GET['api'])){ $apikey = htmlspecialchars($_GET['api']); }

$pagenumber = "";
if(isset($_GET['page'])){ $pagenumber = htmlspecialchars($_GET['page']); }
$page = '10';

$seek = '<parameters> 
<row><param>API_QUERY_ID</param><value>'. $apikey .'</value></row> 
<row><param>PAGE_NUMBER</param><value>'. $pagenumber .'</value></row> 
<row><param>RESULTS_PER_PAGE</param><value>'. $page .'</value></row>
</parameters>';

$postdata = http_build_query(
	array(
	 'DistributorKey' => '201201100935',
	 'CommandName' => 'QueryProductsNextPage',
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
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Holiday Planning - List of Accommodation</title>
<meta name="Generator" content="Serif WebPlus X6">
<meta name="viewport" content="width=960">

<!-- CSS Style for homepage-->
<link rel="stylesheet" type="text/css"href="http://localhost/Yemi/css/next_page.css" />
</head>

<body style="background:#ffffff;">
<div style="background-color:transparent; margin-left:auto; margin-right:auto; position:relative;  height:700px;">

<!-- Top banner image for the website -->

<div id="banner"><img src="http://localhost/Yemi/free.jpg" >
</div>
<div id="menu">
	
	<!-- This button would reference the Home Page-->
    <a href="index.html" id="nav_1_B1" class="Button1" style="display:block;position:absolute;left:0px;top:4px;width:136px;height:33px;"><span>Home</span></a>
	
	<!-- This button would reference the page that returns all regions in Victoria-->
    <a href="page2.html" id="nav_1_B2" class="Button2" style="display:block;position:absolute;left:146px;top:4px;width:136px;height:33px;"><span>Region</span></a>
    
	<!-- This button would reference the page that returns destinations-->
	<a href="page5.html" id="nav_1_B3" class="Button2" style="display:block;position:absolute;left:292px;top:4px;width:136px;height:33px;"><span>Destination</span></a>
    
	<!-- This page page would reference the form for interactive search by the user-->
	<a href="page4.html" id="nav_1_B4" class="Button2" style="display:block;position:absolute;left:438px;top:4px;width:136px;height:33px;"><span>Interactive&nbsp;Search</span></a>
</div>


<?php
//echo '<pre>'; print_r ($result); echo '</pre>';

/** Instantiate Loop */

foreach ($result->total_records_found as $total) {
	
	// Declare if statement to parse cities with no records
	
	if ($total == 0) {
	
	echo '<div style="position:absolute;left:300px;top:220px;width:auto;height:auto;overflow:hidden;">
			<p class="Wp-Body-P"><span class="Body-C">Sorry there are no results found for this location</span></p>
			</div>'."<br/><br/>";
	
	//echo 'Sorry there are no results found for this location'.'<br/><br/>';
	break;
	}
}

	echo '<div style="position:relative;left:170px;top:150px;width:auto;height:208px;">';
	foreach ($result->product_distribution as $entry) {
    
	$pna = htmlspecialchars_decode($entry->product_record->product_name, ENT_QUOTES);
	$pna = str_replace("'", "'", $pna);
	
	$str = htmlspecialchars_decode($entry->product_record->product_description, ENT_QUOTES);
	$str = str_replace("'", "'", $str);
	
	$productid = $entry->product_record->product_id;
	
	// Instantiate images
	$image = $entry->product_multimedia->row->server_path;
	
	// Instantiate video
	$vid = $entry->product_multimedia->row->attribute_id_multimedia_file;
	
	// Divs for display begins here
	echo '<div style="position:relative;left:auto;top:auto;width:100%;height:229px;background: transparent url(http://localhost/Yemi/wpbc578c2f_06.png) no-repeat top left;">';
	
	// Declare if statement to return media either as video or images
	if ($vid == '.YTV') {
		
		// Embed youtube video on the webpage
		preg_match(
        '/[\\?\\&]v=([^\\?\\&]+)/',
        $image,
        $matches
		);
		$id = $matches[1];
 
		$width = '280';
		$height = '229';
		echo '<object width="' . $width . '" height="' . $height . '"><param name="movie" value="http://www.youtube.com/v/' . $id . '&amp;hl=en_US&amp;fs=1?rel=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/' . $id . '&amp;hl=en_US&amp;fs=1?rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="' . $width . '" height="' . $height . '"></embed></object>'. "<br /><br />";
		}

	
	else {
		echo '<img src='.$image.' width=280; height=229/>'. "<br /><br /><br/>";
		}
		
	
	// Declare substring as a variable
	$desc = substr($str, 0, 240);
	
	//echo  '<a href=single_product.php?product_id='.$productid.'>'.$pna.'</a>'. "<br /><br />";
    //echo  substr($str, 0, 300).'.....<a href=single_product.php?product_id='.$productid.'><i><b>(more)</b></i></a>' . "<br /><br />";
	//echo '<a href='.$image.'>'.$image.'</a>'. "<br /><br />";

	echo	'<div style="position:absolute;left:300px;top:16px;width:auto;height:auto;overflow:hidden;">
			<p class="Wp-Body-P"><span class="Body-C"><a href=single_product.php?product_id='.$productid.'>'.$pna.'</a></span></p>
			</div>';
	
	echo '<img src="http://localhost/Yemi/wpf014934c_06.png" border="0" width="21" height="19" alt="" style="position:absolute;left:386px;top:7px;">';
    echo '<img src="http://localhost/Yemi/wp301f4af1_06.png" border="0" width="21" height="19" alt="" style="position:absolute;left:429px;top:7px;">';
    echo '<img src="http://localhost/Yemi/wpb16993b7_06.png" border="0" width="21" height="19" alt="" style="position:absolute;left:450px;top:7px;">';
    echo '<img src="http://localhost/Yemi/wp301f4af1_06.png" border="0" width="21" height="19" alt="" style="position:absolute;left:408px;top:7px;">';
    echo '<img src="http://localhost/Yemi/wpf014934c_06.png" border="0" width="21" height="19" alt="" style="position:absolute;left:365px;top:7px;">';
	
	echo	'<div style="position:absolute;left:300px;top:41px;width:auto;height:auto;overflow:hidden;">
			<p class="Wp-Body-P"><span class="Body-C">'.$productid.'</span></p>
			</div>';
			
	echo	'<div style="position:absolute;left:300px;top:73px;width:410px;height:104px;overflow:hidden;">
			<p class="Wp-Body-P"><span class="desc">'.$desc.'......<a href=single_product.php?product_id='.$productid.'><i><b>(more)</b></i></a></span></p>
			</div>';
	
	echo 	'<div style="position:absolute;left:780px;top:22px;width:auto;height:auto; background-color:#530054; border: 1px solid #ffffff;overflow:hidden;padding:4px 0px 0px;">
			<p class="Body-P"><span class="Body-C-C2">Check Availability</span></p>
			</div>';
}
	



$pagenumber--;

if($pagenumber < 1){
  $pagenumber = 1;
  echo '<a href=next_page.php?api='.$apikey.'&page='.$pagenumber.'>Previous</a><br>';
  $pagenumber++;
  echo '<a href=next_page.php?api='.$apikey.'&page='.$pagenumber.'>Next</a><br>';
  }
  
  else {
  echo '<a href=next_page.php?api='.$apikey.'&page='.$pagenumber.'>Previous</a><br>';
  $pagenumber = $pagenumber + 2;
  echo $pagenumber. "<br/>";
  echo '<a href=next_page.php?api='.$apikey.'&page='.$pagenumber.'>Next</a><br>';
  }

?>