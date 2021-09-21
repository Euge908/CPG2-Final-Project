<?php
// TODO: remove comment on session, include, n user_data after we have user db
//session_start();

include("connections.php");
include("functions.php");
//$user_data = check_login($con);

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
</head>
<body>
    <h1>Take Inventory</h1>
    <table>
        <tr>
            <th>Item</th>
            <th>Category</th>
            <th>Measurement Units</th>
            <th>Quantity</th>
        </tr>

        <!-- Display last inventory records, if any-->
        <?php
        if (!is_null($rows)) {
            $ctr = 0;
            // Get new inventory entry from user
            echo "<form action=". htmlspecialchars($_SERVER['PHP_SELF']) ." method='POST'>";
            foreach ($rows as $row) {
                echo "<tr>
                        <td> <input type='text' name='input[".$ctr."][item]' value='". $row['Item'] ."' readonly /> </td>".
//                        <td> <select name='input[][category]'>
//                            <option value=". $row['Category'] ." selected>". $row['Category'] ." </option>
//                        </select> </td>
                        "<td> <input type='text' name='input[".$ctr."][category]' value=". $row['Category'] ." readonly /> </td>
                        <td> <input type='text' name='input[".$ctr."][unit]' value=". $row['Unit'] ." readonly /> </td>
                        <td> <input type='number' name='input[".$ctr."][quantity]' value=". $row['Quantity'] ." required 
                                    step='0.01' min='0' max='99999.99'/> </td>
                    </tr>";
                $ctr++;
            }
            unset($row);  // break reference with the last element as it is retained even after the loop
            echo "<tr> <td> <input type='submit'/> </td> </tr>";
            echo "</form>";
        } else {
            // TODO: add something (blank table with add button for new row or sth) for no part ]inventory recs
        }
        ?>

    </table>
    <!-- Add new inventory record to database -->
<!--    TODO: need to fix bug here; not saving to sql database. outputs error occured instead.->
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $query = "insert into stockusage values ";
        foreach ($_POST['input'] as $row) {
            $query .= "(" .$row['item'] .", " .$row['category'] .", CURDATE(), 'John Kayne', " //.$_SESSION['user_id'] .", "
                      .$row['unit'] .", " . $row['quantity'] ."), ";
        }
        $query = rtrim($query, ", ");  // Remove trailing ', ' from foreach loop

        $result = mysqli_query($con, $query);
        if ($result) {
            echo "Successfully recorded new inventory entry!";
        } else {
            echo "An error occurred. Please verify inputs.";
        }
    }
    ?>
</body>
</html>

<?php
mysqli_close($con);
?>