<?php
session_start();

include("./include/connections.inc.php");
include("./include/functions.inc.php");
$user_data = check_login($usersConnection);

// Fetch choices for units and categories from Database
$unitOptions = get_enum_values($inventoryConnection, "StockUsage", "Unit");
$categoryOptions = get_enum_values($inventoryConnection, "StockUsage", "Category");

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>View Inventory</title>
</head>
<body>
    <a href="logout.php">Logout</a>
    <h1>View Inventory</h1>
    Hello, <?php echo $user_data['name'];?>! <br><br>

    <form method = "post">
        Search Item:
        <input type="text" name="searchItem" placeholder="Enter Item">

        Filter by:
        <select type="text" name="columnToBeArranged">
            <option value='Item'>Item</option>
            <option value="Category">Category</option>
            <option value="Unit">Unit</option>
            <option value="BegInvent">Beginning Inventory</option>
            <option value="Quantity">End Inventory</option>
        </select>

        <input type="submit" name="orderBy" value="Order By">
        <input type="submit" name="search" value="Search Value"><br><br>
    </form>

    <table>
        <tr>
            <th>Item Name</th>
            <th>Category</th>
            <th>Measurement Units</th>
            <th>Beginning Inventory</th>
            <th>Purchases</th>
            <th>Total</th>
            <th>End Inventory</th>
            <th>Usage</th>
            <th> </th>
        </tr>

    <!-- Cost of Goods (COGs) generation based on latest inventory and process search and filter buttons-->
    <?php
    $text = "";

    // Retrieve the latest inventory, if any, along with the quantity purchased and beginning inventory
    $query = "SELECT A.*, IFNULL(B.Quantity, 0.00) as Purchases,
           CASE WHEN C.Date < (SELECT MAX(Date) from stockusage) THEN C.Quantity ELSE 0.00 END as BegInvent
           FROM stockusage A
           LEFT JOIN expenditure B ON A.Item = B.Item AND A.Date = Date(B.PurchaseDate)
           LEFT JOIN stockusage C ON A.Item = C.Item
           WHERE A.Date = (select MAX(Date) from stockusage) GROUP BY Item";


    if (isset($_POST['search']) or isset($_POST['orderBy'])) {
        if (isset($_POST['search'])) {
            $text = parse_input($_POST["searchItem"]); //string is search bar

            if(empty($text)) {
                echo "Empty Text Field. Enter an item name to search.<br>";
            } else {
                echo "Search Entry was clicked. <br>";
                $query .= " HAVING Item = '$text'";
            }
        } else if (isset($_POST['orderBy'])) {
            $orderBy = parse_input($_POST["columnToBeArranged"]); //string in drop down
            $query .= " ORDER BY $orderBy ASC";
        }
    }

    $result = mysqli_query($inventoryConnection, $query);
    if ($result) {

        if (mysqli_num_rows($result) > 0) {
            // Fetch all rows from query
            $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

            echo "<br>Here are the latest inventory updated last " .$rows[0]['Date'] .".<br><br>";
            foreach ($rows as $row) {
                $total = $row['BegInvent']+$row['Purchases'];  // Total quantity prior usage
                echo "<tr>";
                echo "<td>" .$row['Item'] ."</td>";
                echo "<td>" .$row['Category'] ."</td>";
                echo "<td>" .$row['Unit'] ."</td>";
                echo "<td style='text-align:right'>" .$row['BegInvent'] ."</td>";  // last inventory’s end inventory
                echo sprintf("<td style='text-align:right'>%.2f</td>", $row['Purchases']); // Quantity purchased since last inventory
                echo sprintf("<td style='text-align:right'>%.2f</td>", $total);
                echo "<td style='text-align:right'>" .$row['Quantity'] ."</td>";  // End Inventory (current quantity)
                if ($total > $row['Quantity']) {
                    // Quantity used = total - ending inventory
                    echo sprintf("<td style='text-align:right'>%.2f</td>", $total - $row['Quantity']);
                } else {
                    echo "<td style='text-align:right'>0.00</td>";
                }
                echo "</tr>";
            }
            unset($row);  // break reference with the last element as it is retained even after the loop

        } else {
            echo "Nothing in inventory yet. Please take inventory first to record the latest stock usage. <br><br>";
            $rows = NULL;  // flag for further operation for no records to display
        }

        mysqli_free_result($result);  // free memory

    } else {
        die("Something Went Wrong with searching. Try Refreshing the page.");
    }
    ?>

    </table>

</body>
</html>


<?php
mysqli_close($usersConnection);
mysqli_close($inventoryConnection);
?>
