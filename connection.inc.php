<?php


//code to connect php to mysql database
//implemented as a separate file to avoid redundant code
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "Inventory"; //data base name. I created a different db for testing purposes.

$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

if(!$con)
{
	die("failed to connect!");
}

$apple = "apple";
?>