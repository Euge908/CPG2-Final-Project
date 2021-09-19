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
        <input id="button" type="text" name="queryText" placeholder="Entry field">
        <input id="button" type="submit" name="filterBy" value="Filter By">
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
    $query = "select * from expenditure";
    $text = $_POST["queryText"];

    if(empty($text))
    {
        echo "Empty Text Field. Enter Text to query.";
    }else{
        if (isset($_POST['filterBy'])) {
            echo "Filter by ".$text;
            //nothing yet will add stuff here
        }
        elseif (isset($_POST['searchValue'])) {
            echo "Search Entry was clicked";
            $query = "select * from expenditure where Item = '$text'";
        }
    }


    $rows = mysqli_query($con, $query);

    if($query)
    {
        if(mysqli_num_rows($rows) > 0)

        {
            while($results = mysqli_fetch_array($rows))
            {
                echo "<tr><td>".$results['Item']."</td>";
                echo "<td>".$results['PurchaseDate']."</td>";
                echo "<td>".$results['Description']."</td>";
                echo "<td>".$results['Quantity']."</td>";
                echo "<td>".$results['Unit']."</td>";
                echo "<td>".$results['Category']."</td></tr>";
            }
        }
    }else{
        die("Error Establishing Connection to database");
    }
    ?>
    </table>
</body>
</html>