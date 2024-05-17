<?php
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

<?php
// Initialize variables to store form data and error messages
$vehicle_assignment = $type_of_expense = $fee_date = $amount = '';
$errorMessages = [];

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $vehicle_assignment = $_POST["vehicle_assignment"];
    $type_of_expense = $_POST["type_of_expense"];
    $fee_date = $_POST["fee_date"];
    $amount = $_POST["amount"];

    // Validate input fields
    if ($vehicle_assignment === "none") {
        $vehicle_assignment = $ve['vehicle_id'];
    }

    if (empty($type_of_expense)) {
        $type_of_expense = $ve['expense_type'];
    }

    if (empty($fee_date)) {
        $fee_date = $ve['expense_date'];
    }elseif (!preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $fee_date)) {
        $errorMessages["fee_date"] = "Please enter a valid date.";
    }
    

    if (empty($amount)) {
        $amount = $ve['expense_cost'];
    }elseif(!is_numeric($amount) || $amount <= 0 ){
        $errorMessages["amount"] = "Please enter a valid amount.";
    }

    // Process form data if no validation errors
    if (empty($errorMessages)) {
        // Process the form data (e.g., save to database)
        
        $sql = "UPDATE vehicle_expense SET vehicle_id = $vehicle_assignment, expense_type = '$type_of_expense', expense_date = '$fee_date', expense_cost = $amount WHERE expense_id = $veId";
        $stmt = mysqli_query($link, $sql);
        
        // Redirect after successful submission
        header("Location: vehicleExpensesList.php");
        exit;
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
                <select id="vehicle_assignment" name="vehicle_assignment">
                    <option value="none" <?php if ($vehicle_assignment === 'none') echo "selected"; ?>>Actual</option>
                    <?php
                    // SQL query to retrieve vehicle data
                    $sql = "SELECT vehicle_id, vehicle_license_plate, vehicle_type, vehicle_model FROM vehicle";
                    $result = mysqli_query($link, $sql);

                    // Check if any rows are returned
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            $vehicleId = $row["vehicle_id"];
                            $vehicleType = htmlspecialchars($row["vehicle_type"]);
                            $vehicleModel = htmlspecialchars($row["vehicle_model"]);
                            $vehicle_pln = htmlspecialchars($row["vehicle_license_plate"]);

                            // Determine if this option should be selected
                            $selected = ($vehicle_assignment == $vehicleId) ? "selected" : "";

                            // Output the option with the appropriate value and selected attribute
                            echo '<option value="' . $vehicleId . '" ' . $selected . '>' . $vehicleType . ' ' . $vehicleModel . ' ' . $vehicle_pln . '</option>';
                        }
                    }
                    ?>
                </select>
            
            <!-- Type of Expense -->
            <label for="type_of_expense">Type of Expense:</label>
            <input type="text" id="type_of_expense" name="type_of_expense" value="<?php echo htmlspecialchars($type_of_expense); ?>" placeholder="<?php echo htmlspecialchars($ve['expense_type']); ?>">
            <?php if(isset($errorMessages["type_of_expense"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["type_of_expense"]; ?></p>
            <?php } ?>
            
            <!-- Date of Expense -->
            <label for="fee_date">Date:</label>
            <input type="date" id="fee_date" name="fee_date" value="<?php echo htmlspecialchars($fee_date); ?>" >
            <?php if(isset($errorMessages["fee_date"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["fee_date"]; ?></p>
            <?php } ?>
            
            <!-- Amount -->
            <label for="amount">Amount:</label>
            <input type="number" id="amount" name="amount" value="<?php echo htmlspecialchars($amount); ?>" min="0" placeholder="<?php echo htmlspecialchars($ve['expense_cost']); ?>">
            <?php if(isset($errorMessages["amount"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["amount"]; ?></p>
            <?php } ?>
            
            <!-- Form Buttons -->
            <input type="submit" value="Submit">
            <input type="button" value="Back" onclick="window.location.href='vehicleExpensesList.php'">
        </form>
    </div>
</body>
</html>


