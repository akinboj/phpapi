<?php

/** Create HTTP POST */


$id = "";
if(isset($_GET['product_id'])){ $id = htmlspecialchars($_GET['product_id']); }

//$productid = 9155083;


$seek = '<parameters>
<row><param>PRODUCT_ID</param><value>'.$id.'</value></row>
</parameters>';

$postdata = http_build_query(
	array(
	 'DistributorKey' => '201201100935',
	 'CommandName' => 'GetProduct',
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
//echo '<pre>'; print_r ($result); echo '</pre>'."<br/><br/>";	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Holiday Planning - List of Accommodation</title>
<meta name="Generator" content="Serif WebPlus X6">
<meta name="viewport" content="width=960">

<!-- CSS Style for homepage-->
<link rel="stylesheet" type="text/css"href="http://localhost/Yemi/css/single_product.css" />

<!-- CSS for slidesjs.com example (It displays the navigation buttons)-->
<link rel="stylesheet" href="http://localhost/Yemi/font-awesome.min.css">

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
  /** Instantiate Loop */

	foreach ($result->product_distribution as $entry) {	
		$pna = htmlspecialchars_decode($entry->product_record->product_name, ENT_QUOTES);
		$pna = str_replace("'", "'", $pna);
		$pna = str_replace("@", "at", $pna);
	
		$str = htmlspecialchars_decode($entry->product_record->product_description, ENT_QUOTES);
		$str = str_replace("'", "'", $str);
	
		$lat = $entry->product_address->row->geocode_gda_latitude;
		$lng = $entry->product_address->row->geocode_gda_longitude;
		
		// Divs for display begins here
		
		//echo  '<b>'.$pna.'</b>'. "<br /><br />";
		echo '<div style="position:absolute;left:25px;top:238px;width:192px;height:50px;overflow:hidden;font-weight:bold;">
			<p class="Wp-Body-P"><span class="Body-C">'.$pna.'</span></p>
			</div>';
		//echo  $str. "<br /><br /><br /><br />";
		echo  '<div style="position:absolute;left:25px;top:326px;width:510px;height:200px;overflow:hidden;">
				<p class="Wp-Body-P"><span class="desc">'.$str.'</span></p>
				</div>';
	
	
	}
?>	
  
  
  <!-- SlidesJS Required: Start Slides -->
  <!-- The container is used to define the width of the slideshow -->
<div class="container" style="position:absolute;left:620px;top:250px;">
   <div id="slides">	
	
	<?php 
	
	$seqnumarray = array ();
	$k = 0;
		
	foreach ($result->product_distribution as $entry) {	
		foreach ($entry->product_multimedia->row as $index => $show) {
		
			// Instantiate images
			$image = $show->server_path;
			
			// Instantiate video
			$vid = $show->attribute_id_multimedia_file;
			
			// Declare if statement to return media either as video or images
			if ($vid == '.YTV') {
		
			// Embed youtube video on the webpage
			preg_match(
			'/[\\?\\&]v=([^\\?\\&]+)/',
			$image,
			$matches
			);
			$id = $matches[1];
			
			$width = '700';
			$height = '460';
			echo '<object width="' . $width . '" height="' . $height . '"><param name="movie" value="http://www.youtube.com/v/' . $id . '&amp;hl=en_US&amp;fs=1?rel=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/' . $id . '&amp;hl=en_US&amp;fs=1?rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="' . $width . '" height="' . $height . '"></embed></object>';
			//echo $show->alt_text. "<br/><br/>";
			}

			elseif ($show->attribute_id_size_orientation == 'LARGELAND') {
				echo '<img src='.$image.' />';
				$seqnumarray[$k] = $show->sequence_number;
				$k++;
				//echo '<i>'.$show->alt_text.'</i>'. "<br/><br/>";
			}
					
		}
		
		// Loop 2
		// this loop will print remaining LANDSCAPE pictures after printing the LARGELAND or 
		// print only LANDSCAPES for the product if there are no LARGELANDS for the product 
		
		$s = 0;
		if (count($seqnumarray) != 0) {
			$countlarge = count($seqnumarray);
			
			foreach ($entry->product_multimedia->row as $index => $show) {
				
				// Instantiate images
				$image = $show->server_path;
				
				if ($show->attribute_id_size_orientation == 'LANDSCAPE') {
					$seqno = (int) $show->sequence_number;
															
					$search = array_search ($seqno, $seqnumarray);				
										
					if ($search === "") {
						echo $search;
						echo '<img src='.$image.' />';
					}
				}
			}
		} elseif (count($seqnumarray) == 0) {
			foreach ($entry->product_multimedia->row as $index => $show) {
				
				// Instantiate images
				$image = $show->server_path;
				
				if ($show->attribute_id_size_orientation == 'LANDSCAPE') {
					echo '<img src="'.$image.'" width="95%" height="99%" />';
				}
			}
		}
				
	}
	?>	
		
	<a href="#" class="slidesjs-previous slidesjs-navigation"><i class="icon-chevron-left icon-large"></i></a>
	<a href="#" class="slidesjs-next slidesjs-navigation"><i class="icon-chevron-right icon-large"></i></a>
    </div> 
</div>
  <!-- End SlidesJS Required: Start Slides -->

  <!-- SlidesJS Required: Link to jQuery -->
  <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
  <!-- End SlidesJS Required -->

  <!-- SlidesJS Required: Link to jquery.slides.js -->
  <script src="http://localhost/Yemi/jquery.slides.js"></script>
  <!-- End SlidesJS Required -->

  <!-- SlidesJS Required: Initialize SlidesJS with a jQuery doc ready -->
  <script>
    $(function() {
      $('#slides').slidesjs({
        start: 1,
		width: 800,
		height: 600,
        navigation: false
      });
    });
  </script>
  <!-- End SlidesJS Required -->
	
	
<?php
	
	// Change date format to YY-MM-DD
	foreach ($result->product_distribution as $entry) {
	$fromDate = $entry->product_record->validity_date_from;
	$newfromDate = date("d-m-Y", strtotime($fromDate));
	
	$toDate = $entry->product_record->validity_date_to;
	$newtoDate = date("d-m-Y", strtotime($toDate));
	
	//echo '<b>Valid from:</b>'.' '.$newfromDate. "<br/>";
	//echo '<b>Valid till:</b>'.' '.$newtoDate. "<br/><br/>";
	
	// Implode time string using ':' separator
	$timein = str_split($entry->product_record->check_in_time, 2);
	$newtimein = implode(':', $timein);
	
	$timeout = str_split($entry->product_record->check_out_time, 2);
	$newtimeout = implode(':', $timeout);
	
	//echo '<b>Check in time is:</b>'.' '.$newtimein.'<i>hrs</i>'. "<br/>";
	echo	'<div style="position:absolute;left:620px;top:750px;width:178px;height:50px;overflow:hidden;">
			<p class="Wp-Body-P"><span class="Body-C-C3">Check-in: '.$newtimein.'hrs</span></p>
			</div>';
	//echo '<b>Check out time is:</b>'.' '.$newtimeout.'<i>hrs</i>'. "<br/><br/>";
	echo	'<div style="position:absolute;left:620px;top:780px;width:178px;height:50px;overflow:hidden;">
			<p class="Wp-Body-P"><span class="Body-C-C3">Check-out: '.$newtimeout.'hrs</span></p>
			</div>';
	
	/************* Block to contain relevant information as needed *************/
	
	//echo $entry->product_address->row->address_line_1. "<br/>";
	//echo $entry->product_address->row->city_name. "<br/>";
	//echo $entry->product_service->row->service_description. "<br/><br/>";
	echo	'<div style="position:absolute;left:25px;top:284px;width:380px;height:50px;overflow:hidden;font-style:italic;">
			<p class="Wp-Body-P"><span class="Body-C">'.$entry->product_address->row->address_line_1.' '.$entry->product_address->row->city_name.', '.$entry->product_address->row->state_name.', '.$entry->product_address->row->address_postal_code.'</span></p>
			</div>';
	
	echo 	'<div style="position:absolute;left:620px;top:850px;width:562px;height:70px; border-top: 1px solid #000000;overflow:hidden;">
			<p class="Wp-Body-P"><span class="Body-C-C0"><b>General weather information:</b> '.$entry->product_record->temp_summer_high.'</span></p>
			</div>';
			
	echo	'<div style="position:absolute;left:620px;top:930px;width:562px;height:auto; border-top: 1px solid #000000;overflow:hidden;">
			<p class="Wp-Body-P"><span class="Body-C-C0"><b>Facilities:</b> '.$entry->product_service->row->service_description.'</span></p>
			</div>';
	
}			

?>

<!--	This block contains the section for displaying the Map..
		In this scenario OpenStreetMap is not pushed -->

<style type="text/css">

#map {
        height: 415.0px;
		width: 550.0px;
		top: 450.0px;
		left: 30px;
        margin: 0;
        padding: 0;
		<!--max-width: none;-->
     }

</style>

<div id="map"></div>
		
		<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
        <!--<script src="http://www.openlayers.org/api/OpenLayers.js"></script>-->
		<script type="text/javascript">
		
			var element = document.getElementById("map");
 
            /*
            Build list of map types.
            You can also use var mapTypeIds = ["roadmap", "satellite", "hybrid", "terrain", "OSM"]
            */
            var mapTypeIds = [];
            for(var type in google.maps.MapTypeId) {
                mapTypeIds.push(google.maps.MapTypeId[type]);
            }
            
 
			
			var map = new google.maps.Map(element, {
                center: new google.maps.LatLng(<?php echo $lat; echo','; echo $lng;?>),
                zoom: 19,
				zoomControl: true,
				zoomControlOptions: {
				style: google.maps.ZoomControlStyle.SMALL
				},
                mapTypeId: "roadmap",
                mapTypeControlOptions: {
                    mapTypeIds: mapTypeIds
                }
			});
 
			
			<!--document.write (contentString); -->
			
			var marker = new google.maps.Marker({
			position: map.center,
			map: map,
			draggable:false,
			icon: 'https://maps.gstatic.com/mapfiles/ms2/micons/man.png',
			animation: google.maps.Animation.DROP
			});
			
			interval = setInterval(function() { toggleBounce() }, 1500);
			
			
			function toggleBounce() {

			if (marker.getAnimation() != null) {
			marker.setAnimation(null);
			} else {
			marker.setAnimation(google.maps.Animation.BOUNCE);
			}
			}
			
			var contentString = '<b><?php echo $pna; ?></b>';
			
			var infowindow = new google.maps.InfoWindow({
			content: contentString,
			maxWidth: 400
			}); 
			
			
			google.maps.event.addListener(marker, 'click', function() {
			infowindow.open(map,marker);
			});
</script>

<div style="position:absolute;left:1050px;top:755px;width:137px;height:53px; background-color:#530054; border: 1px solid #ffffff;overflow:hidden;padding:4px 0px 0px;">
<p class="Body-P"><span class="Body-C-C4">Check Availability</span></p>
</div>

</body>
</html>