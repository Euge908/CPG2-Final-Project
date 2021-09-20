<?php 
session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);


    if (isset($_POST['addEntry'])) {
        echo "Add Entry was clicked";
    }
    elseif (isset($_POST['deleteEntry'])) {
        echo "Delete Entry was clicked";
    }
?>

<!DOCTYPE html>
<html>
<head>
	<title>My website</title>
</head>
<body>

	<a href="logout.php">Logout</a>
	<h1>This is the index page</h1>

	<br>
	Hello, <?php echo $user_data['name']; ?>



    <form method="post">
        <h1>Expenditure Entry</h1>
        Date of Purchase:
        <input id="text" type="text" name="dateOfPurchase"><br><br>
        Product Name:
        <input id="text" type="text" name="productName"><br><br>
        Description:
        <input id="text" type="text" name="description"><br><br>
        Quantity:
        <input id="text" type="text" name="quantity"><br><br>
        Units:

        <select id="text" type="text" name="units">
            <option value='units'>Units</option>
            <option value="kilograms">Kilograms</option>
            <option value="boxes">Boxes</option>
            <option value="liters">Liters</option>
            <option value="gallons">Gallons</option>
        </select>

        <br><br>
        Category:

        <select id="text" type="text" name="category">
            <option value='Meat/Seafood'>Meat/Seafood</option>
            <option value="Vegetables">Vegetables</option>
            <option value="Grocery/Condiments">Grocery/Condiments</option>
            <option value="Dairy">Dairy</option>
            <option value="Grain">Grain</option>
            <option value="Fruit">Fruit</option>
            <option value="Cutlery/Utensils">Cutlery/Utensils</option>
            <option value="Major Equipment">Major Equipment</option>
            <option value="Minor Equipment">Minor Equipment</option>
        </select><br><br>


        <input id="button" type="submit" name="addEntry" value="Add Entry"><br><br>
        <input id="button" type="submit" name="deleteEntry" value="Delete Entry"><br><br>
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
        <input id="button" type="submit" name="searchValue" value="Search Value"><br><br>
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




    <?php
    //code for displaying previous tables here
    //if condition is blank, it means display everything
    $text = "";


    $query = "select * from expenditure";
    $results = mysqli_query($con, $query);


    if (isset($_POST['searchValue'])) {
        $text = trim($_POST["queryText"]); //string is search bar

        if(empty($text))
        {
            echo "Empty Text Field. Enter Text to query.";
        }else{

            if (isset($_POST['searchValue'])) {
                echo "Search Entry was clicked";
                $query = "select * from expenditure where Item = '$text'";
                $results = mysqli_query($con, $query);

            }
        }
    }

    $orderBy = trim($_POST["columnToBeArranged"]); //string in drop down
    if (isset($_POST['orderBy'])) {
        $orderBy = $query. " order by $orderBy ASC";
        $results = mysqli_query($con, $orderBy);
    }

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