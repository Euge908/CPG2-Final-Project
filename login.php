<?php 

session_start();

	include("./include/connections.inc.php");
	include("./include/functions.inc.php");

	$error = "";

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
			$result = mysqli_query($usersConnection, $query);

			if($result)
			{
				if($result && mysqli_num_rows($result) > 0)
				{

					$user_data = mysqli_fetch_assoc($result); //user data to access stuff


					if($user_data['password'] === $password)
					{

						$_SESSION['user_id'] = $user_data['user_id']; //global variable name
						header("Location: index.php");
						die;
					}
				}
			}else{
                $error = "<div class=\"alert alert-warning\" role=\"alert\">
                  Something went wrong with the database!
                </div>";
        }

        }else
		{
            $error = "<div class=\"alert alert-warning\" role=\"alert\">
                  Invalid email or password!
                </div>";
		}
	}

?>


<!DOCTYPE html>
<html>
<head>
	<title>Login Page</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


    <div class = "container">


        <div class="container h-100">
            <div class="row h-100 justify-content-center align-items-center">
                <div class="col-10 col-md-8 col-lg-6">


                    <!-- Form -->
                    <form class="" action="" method="post">
                        <h1>Login Page</h1>

                        <?php
                        echo $error
                        ?>
                        <!-- Input fields -->
                        <div class="form-group pb-2 mt-4 mb-2 " required>
                            <label for="email">Email:</label>
                            <input type="text" class="form-control email" id="email" placeholder="Enter Email" name="email">
                        </div>
                        <div class="form-group pb-2 mt-4 mb-2 ">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control password" id="password" placeholder="Enter Password" name="password" required>
                        </div>



                        <button type="submit" class="btn btn-primary">Login</button>
                        <a class="btn btn-primary" href = "signup.php">Sign Up</a>
                        <!-- End input fields -->
                    </form>


                    <!-- Form end -->
                </div>
            </div>
        </div>

    </div>


</body>
</html>