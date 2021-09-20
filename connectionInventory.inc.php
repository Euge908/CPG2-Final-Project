<?php


//code to connect php to mysql INVENTORY database
//implemented as a separate file to avoid redundant code
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "Inventory"; //database name. I created a different db for testing purposes.

$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

if(!$con)
{
    die("Failed to connect to database!");
}

?>