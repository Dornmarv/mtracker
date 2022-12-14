<?php 

// get distance in km
$lat1 = $_POST['lat1'];
$long1 = $_POST['long1'];

$lat2 = $_POST['lat2'];
$long2 = $_POST['long2'];

$url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$lat1.",".$long1."&destinations=".$lat2.",".$long2."&mode=driving&language=en&key=AIzaSyBC2MpVD8almM2P8nUmRusM2TkeJKyJgUk";       
        

$geocode=file_get_contents($url);
$response = json_decode($geocode, true);

$distance25 = $response['rows'][0]['elements'][0]['distance']['text'];
$distance2  = preg_replace("/[^0-9.]/", "", $distance25);

response(200,"edwin how are you",$distance2);


function response($status,$status_message,$data)
{
    header("HTTP/1.1 ".$status);
    
    $response['status']=$status;
    $response['status_message']=$status_message;
    $response['data']=$data;
    
    $json_response = json_encode($response);
    echo $json_response;
}

?>