<?php

/** Create HTTP POST */
$country = 'Australia';
$state = 'Victoria';

// GET areaname from previous page (page2.html)
$area = "";

if(isset($_GET['areaname'])){ $area = htmlspecialchars($_GET['areaname']); }
//print $area. "<br />";


//$area = htmlspecialchars($_GET['areaname']);

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
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<!-- Block of html code extracted from page2.html:
To retain major formatting of the page -->

<html lang="en">
<head>
<link rel="stylesheet" href="zebra_pagination.css" type="text/css">
<link rel="stylesheet" href="style.css" type="text/css">
<meta charset="utf-8">
<link rel="stylesheet" href="reset.css" type="text/css">
		
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Holiday Planning - Each Region</title>
<meta name="Generator" content="Serif WebPlus X6">
<meta name="viewport" content="width=960">

<!-- CSS Style for homepage-->
<link rel="stylesheet" type="text/css"href="http://localhost/Yemi/css/getcities.css" />
</head>

<body style="background:#ffffff;">
<div style="background-color:transparent; margin-left:auto; margin-right:auto; position:relative;  height:700px;">

<!-- This is the wrapper div--> 
<div style="position:absolute;left:50px;top:156px;width:auto;height:auto;font-size:14.5px;"> 
<!-- This block holds the display for the beadcrumbs -->
<div style="float:left;width:auto;height:40px;margin-right:5px;overflow:hidden;">
<p class="Wp-Body-P"><span class="crumbs"><a class="hlink_1" href="index.html" style="text-decoration:none;font-weight:bold;">Home</a></span></p>
</div>
<div style="float:left;width:auto;height:35px;margin-right:5px;overflow:hidden;font-weight:bold;">
<p class="Wp-Body-P"><span class="crumbs">&gt;</span></p>
</div>
<div style="float:left;width:auto;height:40px;margin-right:5px;overflow:hidden;">
<p class="Wp-Body-P"><span class="crumbs"><a class="hlink_1" href="page2.html" style="text-decoration:none;font-weight:bold;">Region</a></span></p>
</div>
<div style="float:left;width:auto;height:35px;margin-right:5px;overflow:hidden;font-weight:bold;">
<p class="Wp-Body-P"><span class="crumbs">&gt;</span></p>
</div>
<div style="float:left;width:auto;height:40px;margin-right:5px;overflow:hidden;font-style:italic;">
<?php echo
'<p class="Wp-Body-P"><span class="crumbs">'.$_GET['areaname'].'</span></p>';
?>
</div> 
</div>

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

<img src="http://localhost/Yemi/wpfc14f635_05_06.jpg" border="0" width="368" height="88" alt="" style="position:absolute;left:53px;top:250px;">
<div style="position:absolute;left:163px;top:208px;">
<p> <span class="Area"><?php echo $area;?></span></p>
</div>

<table id="table_1" cellspacing="0" cellpadding="0">
    <col style="width:207px;">
    <tr style="height:59px;">
        <td style="vertical-align:top; padding:1px 4px 1px 4px;">
		<!-- Instantiate the paramenter as a hyperlink:
		For now it returns accommodation within the region based on the category type -->
			<?php
			$area = str_replace(" ", urlencode(" "), $area);
			$area = str_replace("&amp;", urlencode("&"), $area);
            echo '<p class="Wp-Table-Body-P"><span class="Table-Body-C"><a href=accommodation.php?regionname='.$area.'>Accommodation</a></span></p>';?>
        </td>
    </tr>
    <tr style="height:53px;">
        <td style="vertical-align:top; padding:1px 4px 1px 4px;">
		<!-- Instantiate the paramenter as a hyperlink: -->
            <p class="Wp-Table-Body-P"><span class="Table-Body-C">Transportation</span></p>
        </td>
    </tr>
    <tr style="height:53px;">
        <td style="vertical-align:top; padding:1px 4px 1px 4px;">
		<!-- Instantiate the paramenter as a hyperlink: -->
            <p class="Wp-Table-Body-P"><span class="Table-Body-C">Attraction</span></p>
        </td>
    </tr>
    <tr style="height:53px;">
        <td style="vertical-align:top; padding:1px 4px 1px 4px;">
		<!-- Instantiate the paramenter as a hyperlink: -->
            <p class="Wp-Table-Body-P"><span class="Table-Body-C">Events</span></p>
        </td>
    </tr>
</table>

<table id="table_2" cellspacing="0" cellpadding="0">
    <col style="width:auto;">
    <col style="width:auto;">
    <col style="width:auto;">
    <col style="width:auto;">
    <col style="width:auto;">

<?php

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

/** Instantiate Loop for declaring array values*/

$citydisplay = array_chunk($citynames, $citiesperrow);

$latdisplay = array_chunk($citylat, $citiesperrow);
$arrlat = json_decode( json_encode($latdisplay) , 1);

$longdisplay = array_chunk($citylong, $citiesperrow);
$arrlong = json_decode( json_encode($longdisplay) , 1);

/** Instantiate pagination from zebra_pagination */
$records_per_page = 5;
	require 'Zebra_Pagination.php';
	$pagination = new Zebra_Pagination();
	$pagination->navigation_position(isset($_GET['navigation_position']) && in_array($_GET['navigation_position'], array('left', 'right')) ? $_GET['navigation_position'] : 'outside');
	$pagination->records(count($citydisplay));
	$pagination->records_per_page($records_per_page);
	$citydisplay = array_slice(
            $citydisplay,                                             
            (($pagination->get_page() - 1) * $records_per_page),    
            $records_per_page                                       
        );


/** Instantiate Loop for displaying array values*/
foreach ($citydisplay as $index => $display) {
	
// Declare if statement for each key to parse null values in array
	
	if (isset($display[0])) {
        echo '<td style="vertical-align:top; padding:1px 4px 1px 4px;">
            <p class="Wp-Table-Body-P"><span class="Table-Body-C-C1"><a href=dest_instance.php?regionname='.$area.'&cityname='.urlencode($display[0]).'&latitude='.$arrlat[$index][0][0].'&longitude='.$arrlong[$index][0][0].'>'.$display[0].'</a></span></p>
        </td>';
    } 
	else {
        echo null;
    }
	
	if (isset($display[1])) {
        echo '<td style="vertical-align:top; padding:1px 4px 1px 4px;">
            <p class="Wp-Table-Body-P"><span class="Table-Body-C-C1"><a href=dest_instance.php?regionname='.$area.'&cityname='.urlencode($display[1]).'&latitude='.$arrlat[$index][1][0].'&longitude='.$arrlong[$index][1][0].'>'.$display[1].'</a></span></p>
        </td>';
    } 
	else {
        echo null;
    }
	
	if (isset($display[2])) {
        echo '<td style="vertical-align:top; padding:1px 4px 1px 4px;">
            <p class="Wp-Table-Body-P"><span class="Table-Body-C-C1"><a href=dest_instance.php?regionname='.$area.'&cityname='.urlencode($display[2]).'&latitude='.$arrlat[$index][2][0].'&longitude='.$arrlong[$index][2][0].'>'.$display[2].'</a></span></p>
        </td>';
    } 
	else {
        echo null;
    }
	
	if (isset($display[3])) {
        echo '<td style="vertical-align:top; padding:1px 4px 1px 4px;">
            <p class="Wp-Table-Body-P"><span class="Table-Body-C-C1"><a href=dest_instance.php?regionname='.$area.'&cityname='.urlencode($display[3]).'&latitude='.$arrlat[$index][3][0].'&longitude='.$arrlong[$index][3][0].'>'.$display[3].'</a></span></p>
        </td>';
    } 
	else {
        echo null;
    }
	
	if (isset($display[4])) {
        echo '<td style="vertical-align:top; padding:1px 4px 1px 4px;">
            <p class="Wp-Table-Body-P"><span class="Table-Body-C-C1"><a href=dest_instance.php?regionname='.$area.'&cityname='.urlencode($display[4]).'&latitude='.$arrlat[$index][4][0].'&longitude='.$arrlong[$index][4][0].'>'.$display[4].'</a></span></p>
        </td>';
    } 
	else {
        echo null;
    }
	
	echo '<tr>';
	
}
	
//echo '<pre>'; print_r ($citydisplay); echo '</pre>';	
?>

</table>
</div>

<!-- Returns the paginated values -->
<?php 
$pagination->render();
?>

</body>
</html>