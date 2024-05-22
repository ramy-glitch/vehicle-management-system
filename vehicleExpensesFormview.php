<?php

session_start();
if (!isset($_SESSION['adminid'])) {

    header("Location: loginpage.php");
    exit;
}

if (file_exists('dblink.php')) 
{
	require 'dblink.php';
}
else {
	die("File not found");
}
?>

<?php

$veId = $ve = null;
// Retrieve vehicle ID from URL parameter
            if (isset($_GET['id'])) {
                $veId = $_GET['id'];


                // SQL query to retrieve maintenance data by ID
                $sql = "SELECT * FROM vehicle_expense WHERE expense_id = ?";
                $stmt = mysqli_prepare($link, $sql);
                $stmt->bind_param("i", $veId);
                $stmt->execute();
                $result = $stmt->get_result();

                // Display maintenance information in editable input fields
                if ($result->num_rows > 0) {
                    $ve = $result->fetch_assoc(); 
                }
            }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Expenses Form</title>
    <link rel="stylesheet" href="form.css">
</head>
<body>
    <div class="container">
        <h2>Vehicle Expenses Form</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?id=".$veId;?>" method="post">
            
        <label for="vehicle_assignment">Vehicle Assignment:</label>
                    <?php
                    // SQL query to retrieve vehicle data
                    $sql = "SELECT vehicle_id, vehicle_license_plate, vehicle_type, vehicle_model FROM vehicle WHERE vehicle_id = ?";
                    $stmt = mysqli_prepare($link, $sql);
                    $stmt->bind_param("i", $ve['vehicle_id']);
                    $stmt->execute();
                    $result = $stmt->get_result();


                    // Check if any rows are returned
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            $vehicleType = htmlspecialchars($row["vehicle_type"]);
                            $vehicleModel = htmlspecialchars($row["vehicle_model"]);
                            $vehicle_pln = htmlspecialchars($row["vehicle_license_plate"]);


                            // Output the option with the appropriate value and selected attribute
                            echo '<input type="text" value="'  . $vehicleType . ' ' . $vehicleModel . ' ' . $vehicle_pln . '" readonly>';
                        }
                    }
                    ?>
            
            <!-- Type of Expense -->
            <label for="type_of_expense">Type of Expense:</label>
            <input type="text" id="type_of_expense" name="type_of_expense" value="<?php echo htmlspecialchars($ve['expense_type']); ?>" readonly>

            
            <!-- Date of Expense -->
            <label for="fee_date">Date:</label>
            <input type="text" id="fee_date" name="fee_date" value="<?php echo htmlspecialchars($ve['expense_date']); ?>" readonly>

            
            <!-- Amount -->
            <label for="amount">Amount:</label>
            <input type="text" id="amount" name="amount" value="<?php echo htmlspecialchars($ve['expense_cost']); ?>" readonly>

            <input type="button" value="Back" onclick="window.location.href='vehicleExpensesList.php'">
        </form>
    </div>
</body>
</html>


<?php mysqli_close($link); ?>