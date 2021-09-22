<?php 
session_start();

	include("./include/connections.inc.php");
	include("./include/functions.inc.php");

	$user_data = check_login($usersConnection);
//    echo $user_data['privelege'];

?>

<!DOCTYPE html>
<html>
<head>
	<title>Take Expenditure</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse " id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <!--current active tab-->
                    <a class="nav-link active px-4" aria-current="page" href="#">Generate Cogs</a>
                </li>


                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle px-4" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Take Inventory
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link px-4" href="#">Expenditures</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link px-4" href="#">Log Out</a>
                </li>
            </ul>
        </div>
    </div>
</nav>


<div class = "container">

    <div class="alert alert-info" role="alert">
        Hello, <?php echo $user_data['name']; ?>. How are you today?
    </div>


    <h1 class = "pb-4 mt-4 mb-4 border-bottom">Expenditure Entry</h1>


    <form method = "post">

        <!-- date input -->
        <div class="row mb-3">
            <label for="dateOfPurchase" class="col-sm-2 col-form-label">Date of Purchase</label>
            <div class="col-sm-10">
                <input input id="text" type="date" name="dateOfPurchase" requiredclass="form-control" id="dateOfPurchase">
            </div>
        </div>


        <div class="row mb-3">
            <label for="inputPassword3" class="col-sm-2 col-form-label">Product Name:</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="inputPassword3">
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="preference">Preference</label>
            <div class="col-sm-10">
                <select class="form-select" id="preference">
                    <option selected>Choose...</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
            </div>
        </div>


        <button type="submit" class="text-right btn btn-primary">Add entry</button>
        <button type="submit" class="text-right btn btn-danger">Delete</button>

    </form>


    <form method="post">

        <div class="form-group pb-2 mt-4 mb-2 ">

        <input id="text" class="form-control email" type="text" name="productName" required>
        </div>

        <div class="form-group pb-2 mt-4 mb-2 ">
        Description:
        <input id="text" class="form-control email" type="text" name="description" required>
        </div>

        <div class="form-group pb-2 mt-4 mb-2 ">
        Quantity:

        <input class="form-control email"  id="text" type="text" name="quantity" required>
        Units:
        </div>

        <div class="form-group pb-2 mt-4 mb-2 ">
        <select id="text" type="text" name="units" required>
            <option value='units'>Units</option>
            <option value="kilograms">Kilograms</option>
            <option value="boxes">Boxes</option>
            <option value="liters">Liters</option>
            <option value="gallons">Gallons</option>
        </select>
        </div>

        <div class="form-group pb-2 mt-4 mb-2 ">
        Category:

        <select id="text" type="text" name="category" required>
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

        <input id="button" type="submit" name="addEntry" value="Add Entry">
        <input id="button" type="submit" name="deleteEntry" value="Delete Entry">
    </form>

    <h1>Previous Expenditure Entries</h1>

    <form method = "post">
        Query text:
        <input id="button" type="text" name="queryText" placeholder="Entry field">

        Filter by:
        <select id="text" type="text" name="columnToBeArranged">
            <option value='Item'>Item</option>
            <option value="PurchaseDate">PurchaseDate</option>
            <option value="Description">Description</option>
            <option value="Quantity">Quantity</option>
            <option value="Unit">Unit</option>
            <option value="Category">Category</option>
        </select>

        <input id="button" type="submit" name="orderBy" value="Order By">
        <input id="button" type="submit" name="searchValue" value="Search Value">
    </form>

    <table>
        <tr>
            <td>Item</td>
            <td>Purchase Date</td>
            <td>Description</td>
            <td>Quantity</td>
            <td>Unit</td>
            <td>Category</td>
        </tr>


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
            if(!empty($dateOfPurchase) or !empty($productName) or !empty($description) or !empty ($quantity) or !empty($units) or !empty($category))
            {
                $modifyQuery = "insert into  expenditure (Item, PurchaseDate, Description, Quantity, Unit, Category) values ('$productName', '$dateOfPurchase', '$description', '$quantity', '$units','$category')";
            }else{
                echo "Error: One or more empty fields Detected. Input something valid, and try again. ";
            }

        }
        elseif (isset($_POST['deleteEntry'])) {

            //()
            if(!empty($dateOfPurchase) or !empty($productName) or !empty($description) or !empty ($quantity) or !empty($units) or !empty($category))
            {
                $modifyQuery = "delete from expenditure where Item ='$productName' AND PurchaseDate = '$dateOfPurchase' AND Description = '$description' AND Quantity ='$quantity' AND Unit = '$units' AND Category = '$category'";
            }else{
                echo "Error: One or more empty fields Detected. Input something valid, and try again. ";
            }
        }


        //add condition to check if modifyQuery was successful
        if(!mysqli_query($inventoryConnection, $modifyQuery))
        {
            die("Something went wrong with searching. Try again.");
        }


    }


    echo "<hr/>";




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
                echo "Empty Text Field. Enter Text to query.";
            }else{

                if (isset($_POST['searchValue'])) {
                    echo "Search Entry was clicked";
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
        die("Something Went Wrong with searching. Try Refreshing the page.");
    }
    ?>
    </table>
</body>
</html>