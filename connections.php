<?php


//code to connect php to mysql INVENTORY database
//implemented as a separate file to avoid redundant code
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbInventory = "Inventory"; //database name. I created a different db for testing purposes.
$dbUsers = "Users"; //database name. I created a different db for testing purposes.

$inventoryConnection = mysqli_connect($dbhost,$dbuser,$dbpass,$dbInventory);
$usersConnection = mysqli_connect($dbhost,$dbuser,$dbpass,$dbUsers);

if(!$inventoryConnection)
{
    die("Failed to connect to inventory database!");
}

if(!$usersConnection)
{
    die("Failed to connect to users database!");
}

?>