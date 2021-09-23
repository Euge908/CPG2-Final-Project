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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
                    <a class="nav-link dropdown-toggle px-4 active " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Inventory
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item  active " href="viewInventory.php">View Inventory</a></li>
                        <li><a class="dropdown-item" href="takeInventory.php">Take Inventory</a></li>
                        <!--                        <li><hr class="dropdown-divider"></li>-->
                        <li><a class="dropdown-item" href="editInventory.php">Edit Category/ Items [DEAD LINK]</a></li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link px-4" href="index.php">Expenditures</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link px-4" href="logout.php">Log Out</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <div class = "container">

        <br><br>
        <div class="alert alert-info" role="alert">
            Hello, <?php echo $user_data['name']; ?>. How are you today?
        </div>


        <h1 class = "pb-4 mt-4 mb-4 border-bottom">View Inventory</h1>



        <form method = "post">

            <div class = "form-row align-items-center">
                <div class = "col-auto">
                    <label class="form-label" for="searchItem">
                        Query text:
                    </label>
                    <input class="form-control" id="searchItem" type="text" name="searchItem" placeholder="Entry field">
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
                    <button class="btn btn-primary mb-2" id="searchButton" type="submit" name="search">Search Value</button>
                </div>
            </div>
        </form>


        <br>

        <table class="table table-hover text-center">
            <tr class = "table-dark ">
                <th scope="col">Item Name</th>
                <th scope="col">Category</th>
                <th scope="col">Measurement Units</th>
                <th scope="col">Beginning Inventory</th>
                <th scope="col">Purchases</th>
                <th scope="col">Total</th>
                <th scope="col">End Inventory</th>
                <th scope="col">Usage</th>
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


        if (isset($_POST['searchItem']) or isset($_POST['orderBy'])) {
            if (isset($_POST['searchItem'])) {
                $text = parse_input($_POST["searchItem"]); //string is search bar

                if(empty($text)) {
                    echo "<script> alert('Empty Text Field. Enter an item name to search.') </script>";
                } else {
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

                echo "<div class=\"alert alert-secondary\" role=\"alert\">
                Here are the latest inventory updated last ". $rows[0]['Date'].
                "</div>";



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
                echo "<script>alert('Nothing in inventory yet. Please take inventory first to record the latest stock usage')</script>";
                $rows = NULL;  // flag for further operation for no records to display
            }

            mysqli_free_result($result);  // free memory

            if(isset($_POST['searchItem']) or isset($_POST['orderBy']))
            echo "<div class=\"alert alert-success\" role=\"alert\">
                Query Results Displayed! 
            </div>";
        } else {
            die("Something Went Wrong with searching. Try Refreshing the page.");
        }



        ?>

        </table>
    </div>

</body>
</html>


<?php
mysqli_close($usersConnection);
mysqli_close($inventoryConnection);
?>
