<?php


require_once("SocketServer.class.php"); // Include the File
$server = new SocketServer("157.230.229.73",11000); // Create a Server binding to the given ip address and listen to port 31337 for connections
$server->max_clients = 10; // Allow no more than 10 people to connect at a time
$server->hook("CONNECT","handle_connect"); // Run handle_connect every time someone connects
$server->hook("INPUT","handle_input"); // Run handle_input whenever text is sent to the server
$server->infinite_loop(); // Run Server Code Until Process is terminated.


function handle_connect(&$server,&$client,$input)
{
    SocketServer::socket_write_smart($client->socket,"String? ","");
}
function handle_input(&$server,&$client,$input)
{
//1.Create connection
$connection = mysqli_connect('localhost','easydisp_main','Trucking@_123');

if (!$connection) {
   die("Database connection failed: ". msysqli_errno($connection));
}
//2. Select a Database
$db_select = mysqli_select_db($connection,'easydisp_easydispatch');
if (!$db_select) {
   die("Database selection failed: ". msysqli_errno($db_select));
}

//    $myFile = "/var/www/html/mtracker/new.txt";
//$fh = fopen($myFile, 'a') or die("can't open file");
//fwrite($fh, $input."<br>"."\r\n");

//$data = file_get_contents("/var/www/html/mtracker/new.txt");

$data = (explode(",",$input));



$str = preg_replace("/[^a-zA-Z0-9]/", "", $data[5]);

$st = (str_split($str,2));

$latitude = intval($st[0]) + (intval($st[1])/60) + (intval($st[2])/3600);

$lstr = preg_replace("/[^a-zA-Z0-9]/", "", $data[7]);

$lst = (str_split($lstr,3));

$s = (str_split($lstr,3)); 

$second = (str_split($s[1],2)); 

$dataList = (str_split($lstr,4));

$third = substr($dataList[1], 1, -1);

$longitude = intval($lst[0]) + (intval($second[0])/60) + (intval($third)/3600);

$sql = "INSERT INTO new_gps_log( manufacturer, serial_number, v1, c_time, S, latitude, D, longitude, G, speed, direction, t_date, vehicle_status )
                  VALUES ( '$data[0]', '$data[1]', '$data[2]', '$data[3]', '$data[4]', '$latitude', '$data[6]', '$longitude', '$data[8]', '$data[9]', '$data[10]', '$data[11]', '$data[12]'  )";
                    
                    if ($connection->query($sql) === TRUE) {


    // You probably want to sanitize your inputs here
    $trim = trim($input); // Trim the input, Remove Line Endings and Extra Whitespace.

    if(strtolower($trim) == "quit") // User Wants to quit the server
    {
        SocketServer::socket_write_smart($client->socket,"Oh... Goodbye..."); // Give the user a sad goodbye message, meany!
        $server->disconnect($client->server_clients_index); // Disconnect this client.
        return; // Ends the function
    }

    $output = strrev($trim); // Reverse the String

    SocketServer::socket_write_smart($client->socket,$output); // Send the Client back the String
    SocketServer::socket_write_smart($client->socket,"String? ",""); // Request Another String

}
}