<?php
session_start();

include("./include/connections.inc.php");
include("./include/functions.inc.php");
$user_data = check_login($usersConnection);

// Fetch choices for units and categories from Database
$unitOptions = get_enum_values($inventoryConnection, "StockUsage", "Unit");
$categoryOptions = get_enum_values($inventoryConnection, "StockUsage", "Category");

// Retrieve the latest inventory, if any
$query = "select * from stockusage where Date = (select MAX(Date) from stockusage) group by Item;";

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
</head>
<body>
<a href="logout.php">Logout</a>
<h1>View Inventory</h1>
Hello, <?php echo $user_data['name'];?>!


        <!-- Display last inventory records, if any-->
        <?php
        if (!is_null($rows)) {
            echo "Here are the latest inventory updated last " .$rows[0]['Date'] ."<br>";
            echo "<table>
                    <tr>
                        <th>Item</th>
                        <th>Category</th>
                        <th>Measurement Units</th>
                        <th>Quantity</th>
                        <th> </th>
                    </tr>
            ";
            foreach ($rows as $row) {
                // Date
                //Checker
                //Item Name
                //Category
                //Unit of measurement
                //Beginning Inventory = last inventory’s end inventory (retrieved from stock usage table (yesterday’s record))
                //Purchases = quantity purchased since last inventory (retrieved from purchase table)
                //Total = total quantity prior usage = beginning inventory + purchases
                //End Inventory = input quantity
                //Quantity used =usage = total - ending inventory
                echo "<tr>";
                echo "<td>" .$row['Item'] ."</td>";
                echo "<td>" .$row['Category'] ."</td>";
                echo "<td>" .$row['Unit'] ."</td>";
                echo "<td>" .$row['Quantity'] ."</td>";
                echo "</tr>";
            }
            unset($row);  // break reference with the last element as it is retained even after the loop
        } else {
            echo "Nothing in inventory yet. Please take inventory first to record the latest stock usage.";
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
            sprintf("('%s', '%s', '%s', '%s', '%s', '%f'), ",
                parse_input($row['item']), parse_input($row['category']), date('Y-m-d'),
                $user_data['name'], parse_input($row['unit']), parse_input($row['quantity'])
            );
    }
    $query = rtrim($query, ", ");  // Remove trailing ', ' from last foreach iteration

    $result = mysqli_query($inventoryConnection, $query);
    if ($result) {
        echo "Successfully recorded new inventory entry!";
        header("Location: viewInventory.php");  // Redirect to view inventory webpage
    } else {
        echo "An error occurred. Please verify inputs.";
    }
}
?>
</body>
</html>


<?php
mysqli_close($usersConnection);
mysqli_close($inventoryConnection);
?>
