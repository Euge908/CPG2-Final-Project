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

            $duplicateQuery = "SELECT * FROM users  WHERE email = '$email'";
            $duplicateQuery = mysqli_query($usersConnection, $duplicateQuery);


            if ($duplicateQuery)
            {
                //error

                if (mysqli_num_rows($duplicateQuery) > 0) {
                    //duplicate user detected
                    echo "<script>alert('Account already used')</script>";
                }
                else{
                    //g to do
                    mysqli_query($usersConnection, $query);
                    header("Location: login.php");
                    die;
                }
            }else{
                echo "<script>alert('Something went wrong with the database')</script>";
            }




		}else
		{
            //invalid fields detected
            echo "<script>alert('Invalid fields detected')</script>";

		}
	}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Signup</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


</head>
<body>


	<div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-10 col-md-8 col-lg-6">


                    <!-- Form -->
                    <form class="" action="" method="post" action = "signup.php">
                        <h1>Sign Up Page</h1>

                        <!-- Input fields -->

                        <div class="form-group pb-2 mt-4 mb-2 ">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control email" id="name" placeholder="Enter Name" name="name">
                        </div>

                        <div class="form-group pb-2 mt-4 mb-2 ">
                            <label for="email">Email:</label>
                            <input type="text" class="form-control email" id="email" placeholder="Enter Email" name="email">
                        </div>
                        <div class="form-group pb-2 mt-4 mb-2 ">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control password" id="password" placeholder="Enter Password" name="password">
                        </div>



                        <a class="btn btn-primary" href = "login.php">Log In</a>
                        <button type="submit" class="btn btn-primary">Sign Up</button>

                        <!-- End input fields -->
                    </form>


                    <!-- Form end -->
                </div>
            </div>
	</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>