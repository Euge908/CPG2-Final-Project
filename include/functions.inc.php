<?php

function check_login($con)
{

	if(isset($_SESSION['user_id']))
	{

		$id = $_SESSION['user_id'];

		$query = "select * from users where user_id = $id limit 1";

		$result = mysqli_query($con, $query);

        if($result && mysqli_num_rows($result) > 0)
		{
			$user_data = mysqli_fetch_assoc($result);
			return $user_data;
		}
	}

	//redirect to login if someone were to say change the html file (some websites fail to do this)
	header("Location: login.php");
	die;

}

function random_num($length)
{

	$text = "";
	if($length < 5)
	{
		$length = 5;
	}

	$len = rand(4,$length);

	for ($i=0; $i < $len; $i++) { 
		# code...

		$text .= rand(0,9);
	}

	return $text;
}

function parse_input($string) {
    // Parse input string in an attempt to prevent Cross-site scripting
    return htmlspecialchars(stripslashes(trim($string)));
}

function get_enum_values($connection, $table, $field ) {
    // Gets enum values of a field from database
    // Source: https://codereview.stackexchange.com/a/24021
    $query = " SHOW COLUMNS FROM `$table` LIKE '$field' ";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);
    // extract the values enclosed in single quotes and separated by commas
    $regex = "/'(.*?)'/";
    preg_match_all( $regex , $row[1], $enum_array );
    $enum_fields = $enum_array[1];
    return( $enum_fields );
}