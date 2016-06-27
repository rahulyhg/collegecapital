<?php

function getLatLongFromPostcode($postcode, $country, $gmapApiKey)
{
    /* remove spaces from postcode */
    $postcode = urlencode(trim($postcode));
 
    /* connect to the google geocode service */    
    $file = "https://maps.google.com/maps/api/geocode/xml?address=$postcode,+AU&key=AIzaSyA5papzfh_eu6xDIvk4CLmyQ_0pDcKYJA8";
    //echo $file;
    $xml = simplexml_load_file($file) or die("url not loading");
	
    return ($xml);
}

$xml = getLatLongFromPostcode("2710", "AU", 'AIzaSyA5papzfh_eu6xDIvk4CLmyQ_0pDcKYJA8');
$latitude = (double)$xml->result->geometry->location->lat;
$longitude = (double)$xml->result->geometry->location->lng;

echo "<h1>LAT => $latitude, LONG => $longitude</h1>";

if( $latitude > -9 || $latitude < -43 || $longitude < 96 || $longitude > 159){
    echo "Invalid Data";
}

