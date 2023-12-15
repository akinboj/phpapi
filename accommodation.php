<?php

// Get name of region from reference files (***Note that two or more files reference accommodation.php***)

$place = "";
if(isset($_GET['regionname'])){ $place = htmlspecialchars($_GET['regionname']); }

// Get name of city from reference files (***Note that two or more files reference accommodation.php***)

$location = "";
if(isset($_GET['cityname'])){ $location = htmlspecialchars($_GET['cityname']); }

$lat = "";
if(isset($_GET['latitude'])){ $lat = htmlspecialchars($_GET['latitude']); }

$lng = "";
if(isset($_GET['longitude'])){ $lng = htmlspecialchars($_GET['longitude']); }

//print $place. "<br /><br />";
//sprint $location;

//$place = htmlspecialchars($_GET['cityname']);

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>RegionAccomm</title>
<meta name="Generator" content="Serif WebPlus X6">
<meta name="viewport" content="width=960">

<!-- CSS Style for homepage-->
<link rel="stylesheet" type="text/css"href="http://localhost/Yemi/css/accommodation.css" />
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
<?php 
if ($location == null) {
echo
'<p class="Wp-Body-P"><span class="crumbs"><a class="hlink_1" href="getcities.php?areaname='.$_GET['regionname'].'" style="text-decoration:none;">'.$_GET['regionname'].'</a> &gt; Accommodation Type</span></p>';
}
else {
echo
'<p class="Wp-Body-P"><span class="crumbs"><a class="hlink_1" href="getcities.php?areaname='.$_GET['regionname'].'" style="text-decoration:none;">'.$_GET['regionname'].'</a> &gt;
<a class="hlink_1" href="dest_instance.php?regionname='.$_GET['regionname'].'&cityname='.$_GET['cityname'].'&latitude='.$lat.'&longitude='.$lng.'" style="text-decoration:none;">'.$location.'</a> &gt; Accommodation Type</span></p>';

}
?>
</div>
</div>


<img src="http://localhost/Yemi/wpfc14f635_05_06.jpg" border="0" width="368" height="88" alt="" style="position:absolute;left:52px;top:239px;">
<div>
<p> <span class="Area">
<?php
 
if ($location == null) {
echo $place;}
else {
echo $location;}
?></span></p>
</div>


<table id="table_1" cellspacing="0" cellpadding="0" style=" border-collapse: collapse; position:absolute; left:920px; top:230px; width:208px; height:144px;">
    <col style="width:207px;">
    <tr style="height:36px;">
        <td style="vertical-align:top; padding:1px 4px 1px 4px;">
            <p class="Wp-Table-Body-P"><span class="Table-Body-C">Accommodation</span></p>
        </td>
    </tr>
    <tr style="height:36px;">
        <td style="vertical-align:top; padding:1px 4px 1px 4px;">
            <p class="Wp-Table-Body-P"><span class="Table-Body-C">Transportation</span></p>
        </td>
    </tr>
    <tr style="height:36px;">
        <td style="vertical-align:top; padding:1px 4px 1px 4px;">
            <p class="Wp-Table-Body-P"><span class="Table-Body-C">Attraction</span></p>
        </td>
    </tr>
    <tr style="height:36px;">
        <td style="vertical-align:top; padding:1px 4px 1px 4px;">
            <p class="Wp-Table-Body-P"><span class="Table-Body-C">Events</span></p>
        </td>
    </tr>
</table>
<div style="position:absolute;left:200px;top:350px;width:250px;height:40px;overflow:hidden;">
<p class="Wp-Body-P"><span class="Body-C">Accommodation Type</span></p>
</div>
<table id="table_3" cellspacing="0" cellpadding="0" style="">
    <col style="width:302px;">
    <col style="width:302px;">
    <tr style="height:33px;">
        <td style="vertical-align:top; padding:1px 4px 1px 4px;">
            <?php 
			// Parse ampersand and space from decoded value in $_GET
			$place = str_replace("&amp;", urlencode("&"), $place);
			$place = str_replace(" ", urlencode(" "), $place);
			$location = str_replace(" ", urlencode(" "), $location);
			
			// Declare if statements to differentiate url navigation between region parameters OR region and city parameters
			if ($location == null) {
			echo '<p class="Wp-Table-Body-P"><span class="Table-Body-C-C0"><a href=category.php?regionname='.$place.'&category_type=>All Accommodation Types</a></span></p>';
			}
			else {
			echo '<p class="Wp-Table-Body-P"><span class="Table-Body-C-C0"><a href=category.php?regionname='.$place.'&cityname='.$location.'&latitude='.$lat.'&longitude='.$lng.'&category_type=>All Accommodation Types</a></span></p>';
			}
			?>
        </td>
        <td style="vertical-align:top; padding:1px 4px 1px 4px;">
            <?php 
			if ($location == null) {
			echo '<p class="Wp-Table-Body-P"><span class="Table-Body-C-C0"><a href=category.php?regionname='.$place.'&category_type=HOLIDAY%20HOUSE>Holiday Houses</a></span></p>';
			}
			else {
			echo '<p class="Wp-Table-Body-P"><span class="Table-Body-C-C0"><a href=category.php?regionname='.$place.'&cityname='.$location.'&category_type=HOLIDAY%20HOUSE>Holiday Houses</a></span></p>';
			}
			?>
        </td>
    </tr>
    <tr style="height:33px;">
        <td style="vertical-align:top; padding:1px 4px 1px 4px;">
            <?php 
			if ($location == null) {
			echo '<p class="Wp-Table-Body-P"><span class="Table-Body-C-C0"><a href=category.php?regionname='.$place.'&category_type=APARTMENT>Apartments</a></span></p>';
			}
			else {
			echo '<p class="Wp-Table-Body-P"><span class="Table-Body-C-C0"><a href=category.php?regionname='.$place.'&cityname='.$location.'&category_type=APARTMENT>Apartments</a></span></p>';
			}
			?>
        </td>
        <td style="vertical-align:top; padding:1px 4px 1px 4px;">
            <?php 
			if ($location == null) {
			echo '<p class="Wp-Table-Body-P"><span class="Table-Body-C-C0"><a href=category.php?regionname='.$place.'&category_type=HOTEL>Hotels</a></span></p>';
			}
			else {
			echo '<p class="Wp-Table-Body-P"><span class="Table-Body-C-C0"><a href=category.php?regionname='.$place.'&cityname='.$location.'&category_type=HOTEL>Hotels</a></span></p>';
			}
			?>
        </td>
    </tr>
    <tr style="height:33px;">
        <td style="vertical-align:top; padding:1px 4px 1px 4px;">
            <?php 
			if ($location == null) {
			echo '<p class="Wp-Table-Body-P"><span class="Table-Body-C-C0"><a href=category.php?regionname='.$place.'&category_type=BACKPACKERS%20AND%20HOSTELS>Backpackers and Hostels</a></span></p>';
			}
			else {
			echo '<p class="Wp-Table-Body-P"><span class="Table-Body-C-C0"><a href=category.php?regionname='.$place.'&cityname='.$location.'&category_type=BACKPACKERS%20AND%20HOSTELS>Backpackers and Hostels</a></span></p>';
			}
			?>
        </td>
        <td style="vertical-align:top; padding:1px 4px 1px 4px;">
            <?php 
			if ($location == null) {
			echo '<p class="Wp-Table-Body-P"><span class="Table-Body-C-C0"><a href=category.php?regionname='.$place.'&category_type=MOTEL>Motels</a></span></p>';
			}
			else {
			echo '<p class="Wp-Table-Body-P"><span class="Table-Body-C-C0"><a href=category.php?regionname='.$place.'&cityname='.$location.'&category_type=MOTEL>Motels</a></span></p>';
			}
			?>
        </td>
    </tr>
    <tr style="height:33px;">
        <td style="vertical-align:top; padding:1px 4px 1px 4px;">
            <?php 
			if ($location == null) {
			echo '<p class="Wp-Table-Body-P"><span class="Table-Body-C-C0"><a href=category.php?regionname='.$place.'&category_type=BED%20AND%20BREAKFAST>Bed and Breakfasts</a></span></p>';
			}
			else {
			echo '<p class="Wp-Table-Body-P"><span class="Table-Body-C-C0"><a href=category.php?regionname='.$place.'&cityname='.$location.'&category_type=BED%20AND%20BREAKFAST>Bed and Breakfasts</a></span></p>';
			}
			?>
        </td>
        <td style="vertical-align:top; padding:1px 4px 1px 4px;">
            <?php 
			if ($location == null) {
			echo '<p class="Wp-Table-Body-P"><span class="Table-Body-C-C0"><a href=category.php?regionname='.$place.'&category_type=RESORT>Resorts</a></span></p>';
			}
			else {
			echo '<p class="Wp-Table-Body-P"><span class="Table-Body-C-C0"><a href=category.php?regionname='.$place.'&cityname='.$location.'&category_type=RESORT>Resorts</a></span></p>';
			}
			?>
        </td>
    </tr>
    <tr style="height:33px;">
        <td style="vertical-align:top; padding:1px 4px 1px 4px;">
            <?php 
			if ($location == null) {
			echo '<p class="Wp-Table-Body-P"><span class="Table-Body-C-C0"><a href=category.php?regionname='.$place.'&category_type=CABINS%20AND%20COTTAGES>Cabins and Cottages</a></span></p>';
			}
			else {
			echo '<p class="Wp-Table-Body-P"><span class="Table-Body-C-C0"><a href=category.php?regionname='.$place.'&cityname='.$location.'&category_type=CABINS%20AND%20COTTAGES>Cabins and Cottages</a></span></p>';
			}
			?>
        </td>
        <td style="vertical-align:top; padding:1px 4px 1px 4px;">
            <?php 
			if ($location == null) {
			echo '<p class="Wp-Table-Body-P"><span class="Table-Body-C-C0"><a href=category.php?regionname='.$place.'&category_type=RETREAT%20AND%20LODGE>Retreat and Lodge</a></span></p>';
			}
			else {
			echo '<p class="Wp-Table-Body-P"><span class="Table-Body-C-C0"><a href=category.php?regionname='.$place.'&cityname='.$location.'&category_type=RETREAT%20AND%20LODGE>Retreat and Lodge</a></span></p>';
			}
			?>
        </td>
    </tr>
    <tr style="height:33px;">
        <td style="vertical-align:top; padding:1px 4px 1px 4px;">
            <?php 
			if ($location == null) {
			echo '<p class="Wp-Table-Body-P"><span class="Table-Body-C-C0"><a href=category.php?regionname='.$place.'&category_type=CARAVAN%20AND%20CAMPING>Caravan and Camping</a></span></p>';
			}
			else {
			echo '<p class="Wp-Table-Body-P"><span class="Table-Body-C-C0"><a href=category.php?regionname='.$place.'&cityname='.$location.'&category_type=CARAVAN%20AND%20CAMPING>Caravan and Camping</a></span></p>';
			}
			?>
        </td>
        <td style="vertical-align:top; padding:1px 4px 1px 4px;">
            <?php 
			if ($location == null) {
			echo '<p class="Wp-Table-Body-P"><span class="Table-Body-C-C0"><a href=category.php?regionname='.$place.'&category_type=SELF%20CONTAINED>Self Contained</a></span></p>';
			}
			else {
			echo '<p class="Wp-Table-Body-P"><span class="Table-Body-C-C0"><a href=category.php?regionname='.$place.'&cityname='.$location.'&category_type=SELF%20CONTAINED>Self Contained</a></span></p>';
			}
			?>
        </td>
    </tr>
    <tr style="height:33px;">
        <td style="vertical-align:top; padding:1px 4px 1px 4px;">
            <?php 
			if ($location == null) {
			echo '<p class="Wp-Table-Body-P"><span class="Table-Body-C-C0"><a href=category.php?regionname='.$place.'&category_type=FARM%20STAYS>Farm Stays</a></span></p>';
			}
			else {
			echo '<p class="Wp-Table-Body-P"><span class="Table-Body-C-C0"><a href=category.php?regionname='.$place.'&cityname='.$location.'&category_type=FARM%20STAYS>Farm Stays</a></span></p>';
			}
			?>
        </td>
        <td style="vertical-align:top; padding:1px 4px 1px 4px;">
            <?php 
			if ($location == null) {
			echo '<p class="Wp-Table-Body-P"><span class="Table-Body-C-C0"><a href=category.php?regionname='.$place.'&category_type=WILDERNESS%20SAFARI%20RETREAT>Wilderness Safari Retreat</a></span></p>';
			}
			else {
			echo '<p class="Wp-Table-Body-P"><span class="Table-Body-C-C0"><a href=category.php?regionname='.$place.'&cityname='.$location.'&category_type=WILDERNESS%20SAFARI%20RETREAT>Wilderness Safari Retreat</a></span></p>';
			}
			?>
        </td>
    </tr>
</table>
<div id="nav_1_B2M" style="position:absolute;visibility:hidden;width:118px;height:53px;background: transparent url('http://localhost/Yemi/wpec7ef546_06.png') no-repeat scroll left top;">
<a href="regionaccomm.html" id="nav_1_B2M_L1" class="Button3" style="display:block;position:absolute;left:19px;top:10px;width:80px;height:33px;"><span>RegionAccomm</span></a>
</div>
<script type="text/javascript" src="wpscripts/jsMenu.js"></script>
<script type="text/javascript">
wpmenustack.setCurrent(['nav_1_B2M_L1']);
wpmenustack.setRollovers([['nav_1_B1',''],['nav_1_B2','nav_1_B2M',{"m_vertical":true}],['nav_1_B3',''],['nav_1_B4','']]);
wpmenustack.setMenus(['nav_1_B2M'],{"m_vOffset":2,"m_vAlignment":1});
</script>
</div>
</body>
</html>