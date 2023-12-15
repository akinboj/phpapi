<?php

/** Create HTTP POST */
$state = 'Victoria';

$place = "";
if(isset($_GET['regionname'])){ $place = htmlspecialchars($_GET['regionname']); }

$location = "";
if(isset($_GET['cityname'])){ $location = htmlspecialchars($_GET['cityname']); }

$lat = "";
if(isset($_GET['latitude'])){ $lat = htmlspecialchars($_GET['latitude']); }

$lng = "";
if(isset($_GET['longitude'])){ $lng = htmlspecialchars($_GET['longitude']); }

//print $place. "<br /><br />";
//print $location;

/** API to get City description from Wikipedia **/
//$q=$_GET['message'];
 

$_GET['cityname'] = str_replace(" ", "%20", $_GET['cityname']);
$q= $_GET['cityname'] . '%20'  . $state;
//echo $q. "<br /><br />";
$url = "http://en.wikipedia.org/w/api.php?format=xml&action=opensearch&search=".$q."&limit=1&namespace=0";
//trim($url);
$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; he; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8");
    $page = curl_exec($ch);
	$page = simplexml_load_string(trim(html_entity_decode($page)), 'SimpleXMLElement');
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>DestinationInstance</title>
<meta name="Generator" content="Serif WebPlus X6">
<meta name="viewport" content="width=960">

<!-- CSS Style for homepage-->
<link rel="stylesheet" type="text/css"href="http://localhost/Yemi/css/dest_instance.css" />
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
<div style="float:left;width:auto;height:40px;margin-right:5px;overflow:hidden;font-weight:bold;">
<?php echo
'<p class="Wp-Body-P"><span class="crumbs"><a class="hlink_1" href="getcities.php?areaname='.$_GET['regionname'].'" style="text-decoration:none;">'.$_GET['regionname'].'</a></span></p>';
?>
</div> 
<div style="float:left;width:auto;height:35px;margin-right:5px;overflow:hidden;font-weight:bold;">
<p class="Wp-Body-P"><span class="crumbs">&gt;</span></p>
</div> 
<div style="float:left;width:auto;height:40px;overflow:hidden;font-style:italic;">
<?php echo
'<p class="Wp-Body-P"><span class="crumbs">'.urldecode($_GET['cityname']).'</span></p>';
?>
</div>
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
				zoomControl: true,
				zoomControlOptions: {
				style: google.maps.ZoomControlStyle.SMALL
				},
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
			
			var contentString = '<?php			
			foreach($page->Section as $it){
			$wikicity = $it->Item->Text;
			$wikidesc = $it->Item->Description;
		
			$wikidesc = htmlentities($wikidesc, ENT_QUOTES);
		
			if ($page = !empty($page->Section)) {
				echo '<b><b>'.$wikicity.'</b></b>'. "<br /><br />"; echo json_encode(stripslashes($wikidesc), 'UTF'-8);
			}
			else {
				print '<b><br/>Oops!<br/>Sorry there is no description for this location at the moment<br/>Please check again soon</b>';
			}
			}		
			?>';
			
			
			var infowindow = new google.maps.InfoWindow({
			content: contentString,
			maxWidth: 240
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


<!--<img src="http://localhost/Yemi/wp8f40eecc_05_06.jpg" border="0" width="311" height="193" alt="" style="position:absolute;left:31px;top:270px;"> -->
<table id="table_1" cellspacing="0" cellpadding="0" style=" border-collapse: collapse; position:absolute; left:920px; top:217px; width:208px; height:198px;">
    <col style="width:207px;">
    <tr style="height:33px;">
        <td style="vertical-align:top; padding:1px 4px 1px 4px;">
		<?php
			$place = str_replace(" ", urlencode(" "), $place);
			$place = str_replace("&amp;", urlencode("&"), $place);
			$location = str_replace(" ", urlencode(" "), $location);
			$location = str_replace("&amp;", urlencode("&"), $location);
             echo '<p class="Wp-Table-Body-P"><span class="Table-Body-C"><a href=accommodation.php?regionname='.$place.'&cityname='.$location.'&latitude='.$lat.'&longitude='.$lng.'>Accommodation</a></span></p>';?>
        </td>
    </tr>
    <tr style="height:33px;">
        <td style="vertical-align:top; padding:1px 4px 1px 4px;">
            <p class="Wp-Table-Body-P"><span class="Table-Body-C">Transportation</span></p>
        </td>
    </tr>
    <tr style="height:33px;">
        <td style="vertical-align:top; padding:1px 4px 1px 4px;">
            <p class="Wp-Table-Body-P"><span class="Table-Body-C">Dining</span></p>
        </td>
    </tr>
    <tr style="height:33px;">
        <td style="vertical-align:top; padding:1px 4px 1px 4px;">
            <p class="Wp-Table-Body-P"><span class="Table-Body-C">Attraction</span></p>
        </td>
    </tr>
    <tr style="height:33px;">
        <td style="vertical-align:top; padding:1px 4px 1px 4px;">
            <p class="Wp-Table-Body-P"><span class="Table-Body-C">Events</span></p>
        </td>
    </tr>
    <tr style="height:33px;">
        <td style="vertical-align:top; padding:1px 4px 1px 4px;">
            <p class="Wp-Table-Body-P"><span class="Table-Body-C">Services</span></p>
        </td>
    </tr>
</table>
<div style="position:absolute;left:376px;top:377px;width:264px;height:78px;overflow:hidden;">
<!-- <p class="Wp-Body-P"><span class="Body-C">Weather </span></p>
<p class="Wp-Body-P"><span class="Body-C-C0">##A brief description of the City Name goes here##</span></p> -->
</div>
<div style="position:absolute;left:376px;top:463px;width:264px;height:93px;overflow:hidden;">
<!-- <p class="Wp-Body-P"><span class="Body-C">Location</span></p>
<p class="Wp-Body-P"><span class="Body-C-C0">##City Name ## is xkm #south east## of Melbourne CBD </span></p>
<p class="Wp-Body-P"><span class="Body-C-C1">map</span></p> -->
</div>

<div style="position:absolute;left:120px;top:217px;width:250px;height:auto;overflow:hidden;">
<p class="Wp-Body-P"><span class="Body-C-C2"><?php $location = str_replace(urlencode(" "), " ", $location);
													echo $location; ?></span></p>
</div>

<div style="position:absolute;left:120px;top:270px;width:450px;height:auto;overflow:hidden;font-family:Calibri Light (Headings);font-size:15.0px;">
<p class="Wp-Body-P"><span class="description"><?php echo $wikidesc; ?></span></p>
</div>

<div id="nav_1_B2M" style="position:absolute;visibility:hidden;width:118px;height:53px;background: transparent url('http://localhost/Yemi/wpec7ef546_06.png') no-repeat scroll left top;">
<a href="regionaccomm.html" id="nav_1_B2M_L1" class="Button3" style="display:block;position:absolute;left:19px;top:10px;width:80px;height:33px;"><span>RegionAccomm</span></a>
</div>
<script type="text/javascript" src="wpscripts/jsMenu.js"></script>
<script type="text/javascript">
wpmenustack.setRollovers([['nav_1_B1',''],['nav_1_B2','nav_1_B2M',{"m_vertical":true}],['nav_1_B3',''],['nav_1_B4','']]);
wpmenustack.setMenus(['nav_1_B2M'],{"m_vOffset":2,"m_vAlignment":1});
</script>
</div>

</body>
</html>