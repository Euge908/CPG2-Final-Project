<?php
session_start();

include("./include/connections.inc.php");
include("./include/functions.inc.php");
$user_data = check_login($usersConnection);

// Fetch choices for units and categories from Database
$unitOptions = get_enum_values($inventoryConnection, "StockUsage", "Unit");
$categoryOptions = get_enum_values($inventoryConnection, "StockUsage", "Category");
$ctr = 0;  // for keeping count of # of rows in input table

// Retrieve the latest inventory, if any
$query = "select Item, Category, Unit, Quantity from stockusage 
          where Date = (select MAX(Date) from stockusage) group by Item;";

$result = mysqli_query($inventoryConnection, $query);

if (mysqli_num_rows($result) > 0) {
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    echo "No inventory data yet.";
    $rows = NULL;  // flag for further operation for no records to display
}
mysqli_free_result($result);  // free memory

?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Take Inventory</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    <style>
        td{
            padding: 20px;

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
                        <a class="nav-link dropdown-toggle px-4 active " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Inventory
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="viewInventory.php">View Inventory</a></li>
                            <li><a class="dropdown-item active" href="takeInventory.php">Take Inventory</a></li>
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


        <br>
        <div class="alert alert-info" role="alert">
            Hello, <?php echo $user_data['name']; ?>! It's time to take your daily inventory.
        </div>
        <h1 class = "pb-4 mt-4 mb-4 border-bottom">Take Inventory</h1>





        <form method='post'>
        <table class = "specialTable">
        <tr>
            <th>Item</th>
            <th>Category</th>
            <th>Measurement Units</th>
            <th>Quantity</th>
            <th> </th>
        </tr>
        <tbody id="tbodyOfInput">


        <!-- Display last inventory records, if any-->
        <?php
        if (!is_null($rows)) {
            // Get new inventory entry from user
            foreach ($rows as $row) {
                echo "<tr>
                        <td> <input type='text' name='input[".$ctr."][item]' value='". $row['Item'] ."' required/> </td>
                        <td> <select name='input[".$ctr."][category]' required>
                            <option value=". $row['Category'] ." selected>". $row['Category'] ."</option>";
                foreach ($categoryOptions as $option) {  // Category choices
                    if (strcmp($option, $row['Category']) !== 0) {
                        echo "<option value='$option'>$option</option>";
                    }
                }
                unset($option);

                echo "</select> </td>
                        <td> <select name='input[".$ctr."][unit]' required style='width: 100%'>
                        <option value=". $row['Unit'] ." selected>". $row['Unit'] ."</option>";
                foreach ($unitOptions as $option) {  // Unit of measurement choices
                    if (strcmp($option, $row['Unit']) !== 0) {
                        echo "<option value='$option'>$option</option>";
                    }
                }
                unset($option);

                echo "</select> </td>
                        <td> <input type='number' name='input[".$ctr."][quantity]' value=". $row['Quantity'] ." 
                                    step='0.01' min='0' max='99999.99' required/> </td>
                    </tr>";
                $ctr++;
            }
            unset($row);  // break reference with the last element as it is retained even after the loop
        } else {
            echo "<tr><td colspan='4'>Nothing in inventory yet. Insert New Item to start taking inventory! <br><br></td></tr>";
        }
        ?>

        </tbody>
        </table>
        <br> <input id='button' type='submit' name='addEntry' value='Add Entries'/>
        <button type='button' name='newItem' onclick='addRow();'>Insert New Item</button> <br>
    </form>

    <!-- JS function for adding and deleting row to an existing table
    Source: https://adnan-tech.com/php-add-dynamic-rows-in-table-tag/  -->
    <script type="text/javascript">
        let unitOptions = <?php echo json_encode($unitOptions);?>;
        let categoryOptions = <?php echo json_encode($categoryOptions);?>;
        let size = parseInt(<?php echo json_encode($ctr);?>);

        function addRow() {
            let html = "<tr>";
            html += "<td><input type='text' name='input["+size+"][item]' required/></td>";
            html += "<td><select name='input["+size+"][category]' required>" +
                        "<option value='' selected disabled hidden>Choose here</option>";
            for (const option of categoryOptions) {
                html += "<option value=" + option + ">" + option + "</option>";
            }
            html += "</td><td>";
            html += "<select name='input["+size+"][unit]' required style='width: 100%'>" +
                        "<option value='' selected disabled hidden>Choose here</option>";
            for (const option of unitOptions) {
                html += "<option value=" + option + ">" + option + "</option>";
            }
            html += "</td>";
            html += "<td><input type='number' name='input["+size+"][quantity]' " +
                                "step='0.01' min='0' max='99999.99' required/></td>";
            html += "<td><button type='button' onclick='deleteRow(this);'>Delete</button></td>"
            html += "</tr>";

            if (size === 0) {
                document.getElementById("tbodyOfInput").deleteRow(0);
            }

            const row = document.getElementById("tbodyOfInput").insertRow();
            row.innerHTML = html;
            size++;
        }

        function deleteRow(button) {
            button.parentElement.parentElement.remove(); // first parentElement will be td and second will be tr.
            size--;
            if (size === 0) {
                let html = "<tr><td colspan='4'>Nothing in inventory yet. " +
                    "Insert New Item to start taking inventory! <br><br></td></tr>"
                const row = document.getElementById("tbodyOfInput").insertRow();
                row.innerHTML = html;
            }
        }
    </script>

    <!-- Add new inventory record to database -->
    <?php
    if (isset($_POST['addEntry'])) {
        $query = "insert into stockusage values ";
        foreach ($_POST['input'] as $row) {
            $query .=
                sprintf("('%s', '%s', CURDATE(), '%s', '%s', '%f'), ",
                    parse_input($row['item']), parse_input($row['category']),
                    $user_data['name'], parse_input($row['unit']), parse_input($row['quantity'])
                );
        }
        $query = rtrim($query, ", ");  // Remove trailing ', ' from last foreach iteration

        $result = mysqli_query($inventoryConnection, $query);
        if ($result) {
            echo "Successfully recorded new inventory entry!";
            echo "<a href = 'viewInventory.php'>";  // Redirect to view inventory webpage
        } else {
            echo "An error occurred. Please verify inputs.";
        }
    }
    ?>

    </div>
</body>
</html>


<?php
mysqli_close($usersConnection);
mysqli_close($inventoryConnection);
?>