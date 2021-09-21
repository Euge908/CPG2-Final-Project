<?php

//Normally you would encrypt and hash stuff with databases for extra security, but idk if this would be possible given time
session_start();

	include("./include/connections.inc.php");
	include("./include/functions.inc.php");

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

			mysqli_query($usersConnection, $query);
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


	<div class="form-group">
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