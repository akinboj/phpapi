<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
  <title>SlidesJS Standard Code Example</title>
  <meta name="description" content="SlidesJS is a simple slideshow plugin for jQuery. Packed with a useful set of features to help novice and advanced developers alike create elegant and user-friendly slideshows.">
  <meta name="author" content="Nathan Searles">

  <!-- SlidesJS Required (if responsive): Sets the page width to the device width. -->
  <meta name="viewport" content="width=device-width">
  <!-- End SlidesJS Required -->

  <!-- CSS for slidesjs.com example -->
  <link rel="stylesheet" href="http://localhost/Yemi/font-awesome.min.css">
  <!-- End CSS for slidesjs.com example -->

  <!-- SlidesJS Optional: If you'd like to use this design -->
  <style>
    body {
      -webkit-font-smoothing: antialiased;
      font: normal 18px/1.5 "Browallia New", Helvetica, sans-serif;
      color: #232525;
      padding-top:70px;
    }

    #slides {
      display: none
    }

    #slides .slidesjs-navigation {
      margin-top:3px;
    }

    #slides .slidesjs-previous {
      margin-right: 5px;
      float: left;
	  text-decoration: none;
    }

    #slides .slidesjs-next {
      margin-right: 5px;
      float: left;
	  text-decoration: none;
    }

    .slidesjs-pagination {
      margin: 6px 0 0;
      float: right;
      list-style: none;
    }

    .slidesjs-pagination li {
      float: left;
      margin: 0 1px;
    }

    .slidesjs-pagination li a {
      display: block;
      width: 13px;
      height: 0;
      padding-top: 13px;
      background-image: url(http://localhost/Yemi/pagination.png);
      background-position: 0 0;
      float: left;
      overflow: hidden;
    }

    .slidesjs-pagination li a.active,
    .slidesjs-pagination li a:hover.active {
      background-position: 0 -13px
    }

    .slidesjs-pagination li a:hover {
      background-position: 0 -26px
    }

    #slides a:link,
    #slides a:visited {
      color: #333
    }

    #slides a:hover,
    #slides a:active {
      color: #9e2020
    }

    .navbar {
      overflow: hidden
    }
  </style>
  <!-- End SlidesJS Optional-->

  <!-- SlidesJS Required: These styles are required if you'd like a responsive slideshow -->
  <style>
    #slides {
      display: none
    }

    .container {
      margin: 0 auto
    }

    /* For tablets & smart phones */
    @media (max-width: 767px) {
      body {
        padding-left: 20px;
        padding-right: 20px;
      }
      .container {
        width: auto
      }
    }

    /* For smartphones */
    @media (max-width: 480px) {
      .container {
        width: auto
      }
    }

    /* For smaller displays like laptops */
    @media (min-width: 768px) and (max-width: 979px) {
      .container {
        width: 724px
      }
    }

    /* For larger displays */
    @media (min-width: 800px) {
      .container {
        width: 800px
      }
    }
  </style>
  <!-- SlidesJS Required: -->
</head>
      
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


/** Instantiate Loop */

	foreach ($result->product_distribution as $entry) {	
		$pna = htmlspecialchars_decode($entry->product_record->product_name, ENT_QUOTES);
		$pna = str_replace("'", "'", $pna);
	
		$str = htmlspecialchars_decode($entry->product_record->product_description, ENT_QUOTES);
		$str = str_replace("'", "'", $str);
	
		$lat = $entry->product_address->row->geocode_gda_latitude;
		$lng = $entry->product_address->row->geocode_gda_longitude;
		
		/****** Echoing block **************/
		
		echo  '<b>'.$pna.'</b>'. "<br /><br />";
		echo  $str. "<br /><br />";
	}
?>

<body>

  <!-- SlidesJS Required: Start Slides -->
  <!-- The container is used to define the width of the slideshow -->
  <div class="container">
   <div id="slides">	
	
	<?php 
		
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
			$height = '500';
			echo '<object width="' . $width . '" height="' . $height . '"><param name="movie" value="http://www.youtube.com/v/' . $id . '&amp;hl=en_US&amp;fs=1?rel=0"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/' . $id . '&amp;hl=en_US&amp;fs=1?rel=0" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="' . $width . '" height="' . $height . '"></embed></object>';
			//echo $show->alt_text. "<br/><br/>";
			}

			elseif ($show->attribute_id_size_orientation == 'LARGELAND') {
				echo '<img src='.$image.' />';
				//echo '<i>'.$show->alt_text.'</i>'. "<br/><br/>";
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
</body>
</html>	
	
<?php
	
	echo "<br/><br/>";
	// Change date format to YY-MM-DD
	foreach ($result->product_distribution as $entry) {
	$fromDate = $entry->product_record->validity_date_from;
	$newfromDate = date("d-m-Y", strtotime($fromDate));
	
	$toDate = $entry->product_record->validity_date_to;
	$newtoDate = date("d-m-Y", strtotime($toDate));
	
	echo '<b>Valid from:</b>'.' '.$newfromDate. "<br/>";
	echo '<b>Valid till:</b>'.' '.$newtoDate. "<br/><br/>";
	
	// Implode time string using ':' separator
	$timein = str_split($entry->product_record->check_in_time, 2);
	$newtimein = implode(':', $timein);
	
	$timeout = str_split($entry->product_record->check_out_time, 2);
	$newtimeout = implode(':', $timeout);
	
	echo '<b>Check in time is:</b>'.' '.$newtimein.'<i>hrs</i>'. "<br/>";
	echo '<b>Check out time is:</b>'.' '.$newtimeout.'<i>hrs</i>'. "<br/><br/>";
	
	/************* Block to contain relevant information as needed *************/
	
	echo $entry->product_address->row->address_line_1. "<br/>";
	echo $entry->product_address->row->city_name. "<br/>";
	echo $entry->product_service->row->service_description. "<br/><br/>";
	
}			

?>


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
                center: new google.maps.LatLng(<?php echo $lat; echo','; echo $lng;?>),
                zoom: 17,
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
                maxZoom: 20
            }));

</script>
</body>
