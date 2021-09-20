<?php 

session_start();

	include("connection.inc.php");
	include("functions.inc.php");


	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
		$email = $_POST['email'];
		$password = $_POST['password'];

		//if all fields inputted were valid
		if(!empty($email) && !empty($password) && filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			//read from database
			$query = "select * from users where email = '$email' limit 1";
			$result = mysqli_query($con, $query);

			if($result)
			{
				if($result && mysqli_num_rows($result) > 0)
				{

					$user_data = mysqli_fetch_assoc($result); //user data to access stuff
                    echo $user_data["date"];


					if($user_data['password'] === $password)
					{

						$_SESSION['user_id'] = $user_data['user_id']; //global variable name
						header("Location: index.php");
						die;
					}
				}
			}
			
			echo "Invalid email or password!";
		}else
		{
			echo "Invalid email or password!";
		}
	}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
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
            <div style="font-size: 20px;margin: 10px;color: white;">Log In</div>
            Email:
            <input id="text" type="text" name="email"><br><br>
            Password:
            <input id="text" type="password" name="password"><br><br>

            <input id="button" type="submit" value="Sign In"><br><br>
        </form>
    </div>
</body>
</html>