<?php 
$string = "0629.4789";
$str = preg_replace("/[^a-zA-Z0-9]/", "", $string);

$st = (str_split($str,3));

$s = (str_split($str,3)); 

$second = (str_split($s[1],2)); 

$dataList = (str_split($str,4));

$third = substr($dataList[1], 1, -1);

echo $st[0];
echo "<br>";
echo $second[0];
echo "<br>";
echo $third;

