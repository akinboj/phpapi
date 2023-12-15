<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR?xhtml1/DTD/transitional.dtd">

<html>
<head>
</head>

<body>

<?php

require_once 'header.php';

/** Instantiate Loop */


foreach ($result->area as $entry) {
	echo $entry->attributes()->area_name . "<br /><br />";
}

foreach ($result->area->city as $entry) {
	
	$pna = htmlspecialchars_decode($entry->attributes()->suburb_city_postal_code, ENT_QUOTES);
	$pna = str_replace("'", "''", $pna);
	
	$str = htmlspecialchars_decode($entry->attributes()->attribute_id_status, ENT_QUOTES);
	$str = str_replace("'", "''", $str);
	
	echo  $pna. "<br />";
    echo  $str . "<br />";
	$city = (string)$entry;
	echo '<a href=alternative_city.php?cityname='.urlencode($city).'>'.$city.'</a><br>';
	
	
}

?>


<h3> Please choose your accommodation preferences: </h3>
<a href="alternative_now.php?accommregion=<?php echo $area ?>">Accommodation</a><br>

</body>

</html>
