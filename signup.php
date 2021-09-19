<?php

//Normally you would encrypt and hash stuff with databases for extra security, but idk if this would be possible given time
session_start();

	include("connection.php");
	include("functions.php");


	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
		$email = $_POST['email'];
		$password = $_POST['password'];
		$name = $_POST['name'];
        $privelege = "employee";

		if(!empty($email) && !empty($password) && filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			//save to database
			$user_id = random_num(20);
			$query = "insert into  users (name, user_id, email, password, privelege) values ('$name','$user_id','$email','$password', '$privelege')";

			mysqli_query($con, $query);
			header("Location: login.php");
			die;
		}else
		{
		    echo "Invalid Fields Detected";
		}
	}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Signup</title>
</head>
<body>

	<style type="text/css">
	
	#text{

		height: 25px;
		border-radius: 5px;
		padding: 4px;
		border: solid thin #aaa;
		width: 100%;
	}

	#button{

		padding: 10px;
		width: 100px;
		color: white;
		background-color: lightblue;
		border: none;
	}

	#box{

		background-color: grey;
		margin: auto;
		width: 300px;
		padding: 20px;
	}

	</style>

	<div id="box">
        <!--		I'll style later using bootstrap.-->
        <!--        NOTE TO SELF: Don't touch the name tags-->
		<form method="post">
			<div style="font-size: 20px;margin: 10px;color: white;">Signup</div>
            Name:
			<input id="text" type="text" name="name"><br><br>
            Email:
            <input id="text" type="text" name="email"><br><br>
            Password:
            <input id="text" type="password" name="password"><br><br>

			<input id="button" type="submit" value="Signup"><br><br>

			<a href="login.php">Click to Login</a><br><br>
		</form>
	</div>
</body>
</html>