<?php

/** Create HTTP POST */
$accomm = 'ACCOMM';
$media = 'Yes';

$place = "";
if(isset($_GET['regionname'])){ $place = htmlspecialchars($_GET['regionname']); }

$location = "";
if(isset($_GET['cityname'])){ $location = htmlspecialchars($_GET['cityname']); }

$category = "";
if(isset($_GET['category_type'])){ $category = htmlspecialchars($_GET['category_type']); }

$lat = "";
if(isset($_GET['latitude'])){ $lat = htmlspecialchars($_GET['latitude']); }

$lng = "";
if(isset($_GET['longitude'])){ $lng = htmlspecialchars($_GET['longitude']); }

//print $place. "<br /><br />";
//print $location. "<br /><br />";
//print $category. "<br /><br />";

//$place = htmlspecialchars($_GET['cityname']);

$page = '10';



$seek = '<parameters> 
<row><param>PRODUCT_CATEGORY_LIST</param><value>'. $accomm .'</value></row>
<row><param>STATE</param><value>VICTORIA</value></row> 
<row><param>AREA</param><value>'. $place .'</value></row>
<row><param>SUBURB_OR_CITY</param><value>'. $location .'</value></row>
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
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Holiday Planning - List of Accommodation</title>
<meta name="Generator" content="Serif WebPlus X6">
<meta name="viewport" content="width=960">

<!-- CSS Style for homepage-->
<link rel="stylesheet" type="text/css"href="http://localhost/Yemi/css/category.css" />
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


<!-- This is the wrapper div--> 
<div style="position:absolute;left:50px;top:156px;width:auto;height:auto;"> 
<!-- This block holds the display for the breadcrumbs -->
<div style="float:left;width:auto;height:40px;margin-right:5px;overflow:hidden;font-size:14.5px;">
<p class="Wp-Body-P"><span class="crumbs"><a class="hlink_1" href="index.html" style="text-decoration:none;font-weight:bold;">Home</a></span></p>
</div>
<div style="float:left;width:auto;height:35px;margin-right:5px;overflow:hidden;font-weight:bold;">
<p class="Wp-Body-P"><span class="crumbs">&gt;</span></p>
</div>
<div style="float:left;width:auto;height:40px`;margin-right:5px;overflow:hidden;">
<p class="Wp-Body-P"><span class="crumbs"><a class="hlink_1" href="page2.html" style="text-decoration:none;font-weight:bold;">Region</a></span></p>
</div>
<div style="float:left;width:auto;height:35px;margin-right:5px;overflow:hidden;font-weight:bold;">
<p class="Wp-Body-P"><span class="crumbs">&gt;</span></p>
</div>
<div style="float:left;width:auto;height:40px;margin-right:5px;overflow:hidden;font-weight:bold;">
<?php 
if ($location == null) {
echo
'<p class="Wp-Body-P"><span class="crumbs"><a class="hlink_1" href="getcities.php?areaname='.$_GET['regionname'].'" style="text-decoration:none;">'.$_GET['regionname'].'</a> &gt;</span></p>';
}
else {
echo
'<p class="Wp-Body-P"><span class="crumbs"><a class="hlink_1" href="getcities.php?areaname='.$_GET['regionname'].'" style="text-decoration:none;">'.$_GET['regionname'].'</a> &gt;
<a class="hlink_1" href="dest_instance.php?regionname='.$place.'&cityname='.$location.'&latitude='.$lat.'&longitude='.$lng.'" style="text-decoration:none;">'.$location.'</a> &gt'; 
}
?>
</div> 
<div style="float:left;width:auto;height:35px;margin-right:5px;overflow:hidden;font-weight:bold;">
<?php
if (($location == null and $_GET['category_type'] == null)) {
	echo '<p class="Wp-Body-P"><span class="crumbs"> <a href="accommodation.php?regionname='.$place.'" style="text-decoration:none;">Accommodation Type</a></span></p>';
	}
	elseif ($location == null and $_GET['category_type'] != null) {
	echo '<p class="Wp-Body-P"><span class="crumbs"> <a href="accommodation.php?regionname='.$place.'" style="text-decoration:none;">Accommodation Type</a></span> &gt; '.$_GET['category_type'].'</p>';
	}	
	elseif ($location != null and $_GET['category_type'] == null) {
	echo
'<p class="Wp-Body-P"><span class="crumbs"> <a class="hlink_1" href="accommodation.php?regionname='.$_GET['regionname'].'&cityname='.$_GET['cityname'].'&latitude='.$lat.'&longitude='.$lng.'" style="text-decoration:none;">Accommodation Type</a></span></p>';
}
else 
echo
'<p class="Wp-Body-P"><span class="crumbs"> <a class="hlink_1" href="accommodation.php?regionname='.$_GET['regionname'].'&cityname='.$_GET['cityname'].'&latitude='.$lat.'&longitude='.$lng.'" style="text-decoration:none;">Accommodation Type</a> &gt; '.$_GET['category_type'].'</span></p>';
?>
</div> 
</div>



<?php
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
	$pna = str_replace("@", "at", $pna);
	
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

$api = $result->api_query_id;
$pgn = 2;
echo '<a href=next_page.php?api='.$api.'&page='.$pgn.'>Next</a><br>';

?>

<div id="nav_1_B2M" style="position:absolute;visibility:hidden;width:118px;height:86px;background: transparent url('http://localhost/Yemi/wp0c67d84a_06.png') no-repeat scroll left top;">
<a href="each region page.html" id="nav_1_B2M_L1" class="Button3" style="display:block;position:absolute;left:19px;top:10px;width:80px;height:33px;"><span>Each&nbsp;Region</span></a>
<a href="shell.html" id="nav_1_B2M_L2" class="Button3" style="display:block;position:absolute;left:19px;top:43px;width:80px;height:33px;"><span>Shell</span></a>
</div>
<div id="nav_1_B3M" style="position:absolute;visibility:hidden;width:137px;height:86px;background: transparent url('http://localhost/Yemi/wpc63bb249_06.png') no-repeat scroll left top;">
<a href="listofaccomm.html" id="nav_1_B3M_L1" class="Button4" style="display:block;position:absolute;left:19px;top:10px;width:99px;height:33px;"><span>AccommodationList</span></a>
<a href="accomm_instance.html" id="nav_1_B3M_L2" class="Button5" style="display:block;position:absolute;left:19px;top:43px;width:99px;height:33px;"><span>Accomm_Instance</span></a>
</div>
<script type="text/javascript" src="wpscripts/jsMenu.js"></script>
<script type="text/javascript">
wpmenustack.setCurrent(['nav_1_B3M_L1']);
wpmenustack.setRollovers([['nav_1_B1',''],['nav_1_B2','nav_1_B2M',{"m_vertical":true}],['nav_1_B3','nav_1_B3M',{"m_vertical":true}],['nav_1_B4','']]);
wpmenustack.setMenus(['nav_1_B2M','nav_1_B3M'],{"m_vOffset":2,"m_vAlignment":1});
</script>
</div>
</body>
</html>