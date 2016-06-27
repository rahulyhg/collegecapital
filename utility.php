<?php
$latitude = 0.0;
$longitude = 0.0;

function formatAddress($streetAddress, $suburb){
    if(empty($streetAddress) || empty($suburb)){
        return '';
    }
    $needle = array(',', '/');
    $address = trim($streetAddress);
        foreach($needle as $delimiter){
        $pos = stripos($address, $delimiter);      
        if($pos != FALSE){          
            $len = strlen($address);
            $address = trim(substr($address, $pos + 1));           
            break;
        }        
        } 
     $fullAddress = $address . ',' . $suburb;
     
     return $fullAddress;
}

 function getLongituteAndLatitute($address){
    global $latitude;
    global $longitude;
    // Get lat and long by address  
    $prepAddr = str_replace(' ','+',$address);
    $geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
    $output= json_decode($geocode);
    $latitude = $output->results[0]->geometry->location->lat;
    $longitude = $output->results[0]->geometry->location->lng;
 }
 
function getLatLongFromPostcodeOrSuburb($postcodeOrSuburb, $country, $gmapApiKey)
{
    /* remove spaces from postcode */
    $postcodeOrSuburb = urlencode(trim($postcodeOrSuburb));
 
    /* connect to the google geocode service */    
    $file = "https://maps.google.com/maps/api/geocode/xml?address=$postcodeOrSuburb,+AU&key=AIzaSyA5papzfh_eu6xDIvk4CLmyQ_0pDcKYJA8";
    //echo $file;
    $xml = simplexml_load_file($file) or die("url not loading");
	
    return ($xml);
}

function LatAndLngExistInAustralia($lat, $lng){
    // got values from AUS post office database
    if($lat > -9 || $lat < -43 || $lng < 96 || $lng > 159){
        return false;
    }
    return true;    
}