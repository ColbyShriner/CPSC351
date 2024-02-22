<?php

// $dbhost = "localhost";
// $dbuser = "root";
// $dbpass = "";
// $dbname = "authentication";

// if(!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname))
// {
// 	die("failed to connect!");
// }

$link1 = mysqli_connect("localhost", "root", "", "database351");
 
// Check for connection
if($link1 == true) {
    echo "database1 Connected Successfully";
}
else {
    die("ERROR: Could not connect " . mysqli_connect_error());
}
 
echo "<br>";
 
// Connection of first database
// Database name => database1
$con = mysqli_connect("localhost", "root", "", "authentication");
 
// Check for connection
if($con == true) {
    echo "database2 Connected Successfully";
}
else {
    die("ERROR: Could not connect " . mysqli_connect_error());
}
 

 
?>