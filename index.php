<?php
session_start();

	include("./include/connections.inc.php");
	include("./include/functions.inc.php");

	$user_data = check_login($usersConnection);


?>

<!DOCTYPE html>
<html>
<head>
	<title>Take Expenditure</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>

        .hide{
            display:none
        }


    </style>

</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Restaurant Inventory System</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse " id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">


                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle px-4" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Inventory
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="viewInventory.php">View Inventory</a></li>
                        <li><a class="dropdown-item" href="takeInventory.php">Take Inventory</a></li>
<!--                        <li><hr class="dropdown-divider"></li>-->
                        <li><a class="dropdown-item" href="editInventory.php">Edit Category/ Items [DEAD LINK]</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link px-4 active" href="index.php">Expenditures</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link px-4" href="logout.php">Log Out</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<div class = "container">



    <br>
    <div class="alert alert-info" role="alert">
        Hello, <?php echo $user_data['name']; ?>. How are you today?
    </div>




    <h1 class = "pb-4 mt-4 mb-4 border-bottom">Expenditure Entry</h1>

    <form method = "post">

        <!-- date input -->
        <div class="row mb-3">
            <label for="dateOfPurchase" class="col-sm-2 col-form-label">Date of Purchase</label>
            <div class="col-sm-10">
                <input type="datetime-local" name="dateOfPurchase" requiredclass="form-control" id="dateOfPurchase" required>
            </div>
        </div>

        <!--Product Name-->
        <div class="row mb-3">
            <label for="productName" class="col-sm-2 col-form-label">Product Name:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="productName" name="productName" required>
            </div>
        </div>

        <!--Description-->
        <div class="row mb-3">
            <label for="description" class="col-sm-2 col-form-label">Description: </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="description" name="description" required>
            </div>
        </div>

        <!--Quantity-->
        <div class="row mb-3">
            <label for="quantity" class="col-sm-2 col-form-label">Quantity: </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="quantity" name="quantity" required>
            </div>
        </div>


        <!--Units-->
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="units">Units</label>
            <div class="col-sm-10">

                <select class="form-select" id="units" type="text" name="units" required>
                    <option value='units'>Units</option>
                    <option value="kilograms">Kilograms</option>
                    <option value="boxes">Boxes</option>
                    <option value="liters">Liters</option>
                    <option value="gallons">Gallons</option>
                </select>
            </div>
        </div>


        <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="category">Category</label>
            <div class="col-sm-10">
                <select class="form-select" id="category" name = "category" required>
                    <option value='Meat/Seafood'>Meat/Seafood</option>
                    <option value="Vegetables">Vegetables</option>
                    <option value="Grocery/Condiments">Grocery/Condiments</option>
                    <option value="Dairy">Dairy</option>
                    <option value="Grain">Grain</option>
                    <option value="Fruit">Fruit</option>
                    <option value="Cutlery/Utensils">Cutlery/Utensils</option>
                    <option value="Major Equipment">Major Equipment</option>
                    <option value="Minor Equipment">Minor Equipment</option>
                </select>
            </div>
        </div>


    <!--TODO: Change BUTTON colors-->
        <button type="submit" name="addEntry" value="Add Entry" class="text-right btn btn-success"> Add Entry</button>
        <button type="submit" name="deleteEntry" value="Delete Entry" class="text-right btn btn-danger">Delete Entry</button>
    </form>


    <h1 class = "pb-4 mt-4 mb-4 border-bottom">Previous Expenditure Entries</h1>
    <form method = "post">

        <div class = "form-row align-items-center">
            <div class = "col-auto">
                <label class="form-label" for="queryText">
                    Query text:
                </label>
                <input class="form-control" mb-2" id="queryText" type="text" name="queryText" placeholder="Entry field">
            </div>


            <div class = "col-auto">

                <label class="form-label" for="columnToBeArranged">
                Filter by:
                </label>

                <select class="form-select mb-2" id="columnToBeArranged" type="text" name="columnToBeArranged">
                    <option value='Item'>Item</option>
                    <option value="PurchaseDate">PurchaseDate</option>
                    <option value="Description">Description</option>
                    <option value="Quantity">Quantity</option>
                    <option value="Unit">Unit</option>
                    <option value="Category">Category</option>
                </select>
            </div>

            <div class = "col-auto">
                <button class="btn btn-primary mb-2" id="orderButton" type="submit" name="orderBy">Order By</button>
                <button class="btn btn-primary mb-2" id="searchButton" type="submit" name="searchValue">Search</button>
            </div>
        </div>
    </form>



    <table class="table table-hover">

        <thead class = "table-dark ">
        <tr>
            <td scope="col">Item</td>
            <td scope="col">Purchase Date</td>
            <td scope="col">Description</td>
            <td scope="col">Quantity</td>
            <td scope="col">Unit</td>
            <td scope="col">Category</td>
        </tr>
        </thead>

</div>




    <?php




    if (isset($_POST['addEntry']) or isset($_POST['deleteEntry'])) {
        $dateOfPurchase = trim($_POST["dateOfPurchase"]);
        $productName = trim($_POST['productName']);
        $description = trim($_POST['description']);
        $quantity = trim($_POST['quantity']);
        $units = trim($_POST['units']);
        $category = trim($_POST['category']);
        $modifyQuery = "";


        if (isset($_POST['addEntry'])) {
            echo !$dateOfPurchase;

            if(!empty($productName) or !empty($description) or !empty ($quantity) or !empty($units) or !empty($category))
            {
                $modifyQuery = "insert into  expenditure (Item, PurchaseDate, Description, Quantity, Unit, Category) values ('$productName', '$dateOfPurchase', '$description', '$quantity', '$units','$category')";
            }else{
                echo "<script>alert(\"Empty  Fields Detected. Try again\")</script>";
            }


        }
        elseif (isset($_POST['deleteEntry'])) {

            //()
            if(!empty($dateOfPurchase) or !empty($productName) or !empty($description) or !empty ($quantity) or !empty($units) or !empty($category))
            {

                    $modifyQuery = "delete from expenditure where Item ='$productName' AND PurchaseDate = '$dateOfPurchase' AND Description = '$description' AND Quantity ='$quantity' AND Unit = '$units' AND Category = '$category'";
            }else{
                echo "<script>alert(\"Empty  Fields Detected. Try again\")</script>";
            }
        }


        //add condition to check if modifyQuery was successful
        if(!mysqli_query($inventoryConnection, $modifyQuery))
        {
            die();
        }else{
            echo "<script>alert(\"Success!\")</script>";
        }


    }
    echo "<br>";
    echo "<br>";



    //code for displaying previous tables here
    //if condition is blank, it means display everything
    $text = "";
    $query = "select * from expenditure";

    if(isset($_POST['searchValue']) or isset($_POST['orderBy']))
    {
        if (isset($_POST['searchValue'])) {
            $text = trim($_POST["queryText"]); //string is search bar

            if(empty($text))
            {
                echo "<script>alert(\"Empty  Fields Detected. Try again\")</script>";
            }else{

                if (isset($_POST['searchValue'])) {
                    $query = "select * from expenditure where Item = '$text'";
                }
            }
        } else if (isset($_POST['orderBy'])) {
            $orderBy = trim($_POST["columnToBeArranged"]); //string in drop down
            $query = $query. " order by $orderBy ASC";
        }
    }

    $results = mysqli_query($inventoryConnection, $query);
    $currentTable = $query;

    if($results)
    {
        if(mysqli_num_rows($results) > 0)

        {
            while($rows= mysqli_fetch_array($results))
            {
                echo "<tr><td>".$rows['Item']."</td>";
                echo "<td>".$rows['PurchaseDate']."</td>";
                echo "<td>".$rows['Description']."</td>";
                echo "<td>".$rows['Quantity']."</td>";
                echo "<td>".$rows['Unit']."</td>";
                echo "<td>".$rows['Category']."</td></tr>";
            }
        }
    }else{

    }

    ?>
    </table>



</body>
</html>