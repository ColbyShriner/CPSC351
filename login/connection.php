<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "authentication";

if(!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname))
{
	die("failed to connect!");
}
