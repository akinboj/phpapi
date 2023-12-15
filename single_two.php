<html lang="en">
<head>
<title>Simplest jQuery Slideshow</title>
 
<style>
body {font-family:Browallia New, Helvetica, sans-serif; font-size:18px;}
</style>
</head>
</html>

<?php

/** Create HTTP POST */



$productid = 9129394;


$seek = '<parameters>
<row><param>PRODUCT_ID</param><value>'.$productid.'</value></row>
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

/** Instantiate Loop */

	foreach ($result->product_distribution as $entry) {	
		$pna = htmlspecialchars_decode($entry->product_record->product_name, ENT_QUOTES);
		$pna = str_replace("'", "'", $pna);
	
		$str = htmlspecialchars_decode($entry->product_record->product_description, ENT_QUOTES);
		$str = str_replace("'", "'", $str);
	
		echo  $pna. "<br /><br />";
		echo  $str . "<br /><br />";
		
		foreach ($entry->product_multimedia->row as $index => $show) {
		
		// Instantiate images
		$image = $show->server_path;
		
		// Instantiate video
		$vid = $show->attribute_id_multimedia_file;
		
		$cat = $show->sequence_number;
		$cat = array();
		
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
		echo $show->alt_text. "<br/><br/>";
		}

		elseif ($show->attribute_id_size_orientation == 'LARGELAND') {
		echo '<img src='.$image.' />'. "<br /><br />";
		echo $show->alt_text. "<br/><br/>";
		}
		
		elseif ($show->attribute_id_size_orientation !== 'LANDSCAPE' || $show->attribute_id_size_orientation !== 'LARGELAND') {
		echo '<img src='.$image.' />'. "<br /><br />";
		echo $show->alt_text. "<br/><br/>";
		}
		
	}	
	
	echo 'Valid from:'.' '.$entry->product_record->validity_date_from. "<br/>";
	echo 'Valid till:'.' '.$entry->product_record->validity_date_to. "<br/>";
	echo 'Check in time is:'.' '.$entry->product_record->check_in_time. "<br/>";
	echo 'Check out time is:'.' '.$entry->product_record->check_out_time. "<br/><br/>";
	
	echo $entry->product_address->row->address_line_1. "<br/>";
	echo $entry->product_address->row->city_name. "<br/>";
	echo 'Latitude:'.' '.$entry->product_address->row->geocode_gda_latitude. "<br/>";
	echo 'Longitude:'.' '.$entry->product_address->row->geocode_gda_longitude. "<br/><br/>"; 
			
}			

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>DestinationInstance</title>
<meta name="Generator" content="Serif WebPlus X6">
<meta name="viewport" content="width=960">
<style type="text/css">

#map {
        height: 415.0px;
		width: 600.0px;
		top: 5.0px;
		left: 0px;
        margin: 0;
        padding: 0;
		<!--max-width: none;-->
     }

</style>

<body >
<!-- <p class="Wp-Body-P"><span class="Body-C">About ##City Name##</span></p>
<p class="Wp-Body-P"><span class="Body-C-C0">##A brief overview of the City Name goes here…##</span></p> -->
<p class="Wp-Body-P"><span class="Body-C-C0"><br></span></p>
</div>

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
            mapTypeIds.push("OSM");
 
			
			var map = new google.maps.Map(element, {
                center: new google.maps.LatLng(-38.317963000, 144.987976000),
                zoom: 16,
                mapTypeId: "OSM",
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
			
			var contentString = '<b>For who hath known the mind of the Lord?<br/> or who hath been his counsellor?<br/> Or who hath first given to him, and it shall be recompensed unto him again?<br/> For of him, and through him, and to him, are all things: to whom be glory for ever. Amen.</b>';
			
			var infowindow = new google.maps.InfoWindow({
			content: contentString,
			maxWidth: 400
			}); 
			
			
			google.maps.event.addListener(marker, 'click', function() {
			infowindow.open(map,marker);
			});
			
			map.mapTypes.set("OSM", new google.maps.ImageMapType({
                getTileUrl: function(coord, zoom) {
                    return "http://tile.openstreetmap.org/" + zoom + "/" + coord.x + "/" + coord.y + ".png";
                },
                tileSize: new google.maps.Size(256, 256),
                name: "OpenStreetMap",
                maxZoom: 18
            }));

</script>
</div>
</body>
</html>
