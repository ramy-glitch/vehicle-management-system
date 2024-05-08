<?php
// Initialize variables to store form data and error messages
$driver_id = $vehicle_LP = $penalty_type = $penalty_date = $penalty_amount = '';
$errorMessages = [];

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST["submit"])) {
    // Retrieve form data
    $driver_id = $_POST["driver_id"];
    $vehicle_LP = $_POST["vehicle_LP"];
    $penalty_type = $_POST["penalty_type"];
    $penalty_date = $_POST["penalty_date"];
    $penalty_amount = $_POST["penalty_amount"];}

    // Validate input fields
    if (empty($driver_id)) {
        $errorMessages["driver_id"] = "Please enter the driver's license number.";
    }

    if (empty($vehicle_LP)) {
        $errorMessages["vehicle_LP"] = "Please enter the vehicle license plate number.";
    }

    if (empty($penalty_type)) {
        $errorMessages["penalty_type"] = "Please enter the penalty type.";
    }

    if (empty($penalty_date)) {
        $errorMessages["penalty_date"] = "Please enter the penalty date.";
    }

    if (empty($penalty_amount) || $penalty_amount < 0) {
        $errorMessages["penalty_amount"] = "Please enter a valid penalty amount.";
    }

    // Process form data if no validation errors
    if (empty($errorMessages)) {
        // Process the form data (e.g., save to database)
        // Redirect after successful submission
        header("Location: penaltiesExpensesList.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penalties and Fines Form</title>
    <link rel="stylesheet" href="form.css">
</head>
<body>
    <div class="container">
        <h2>Penalties and Fines Form</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            
            <!-- Driver's License Number -->
            <label for="driver_id">Driver's License Number:</label>
            <input type="number" id="driver_id" name="driver_id" value="<?php echo htmlspecialchars($driver_id); ?>" required>
            <?php if(isset($errorMessages["driver_id"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["driver_id"]; ?></p>
            <?php } ?>
            
            <!-- Vehicle License Plate Number -->
            <label for="vehicle_LP">Vehicle License Plate Number:</label>
            <input type="text" id="vehicle_LP" name="vehicle_LP" value="<?php echo htmlspecialchars($vehicle_LP); ?>" required>
            <?php if(isset($errorMessages["vehicle_LP"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["vehicle_LP"]; ?></p>
            <?php } ?>
            
            <!-- Penalty Type -->
            <label for="penalty_type">Penalty Type:</label>
            <input type="text" id="penalty_type" name="penalty_type" value="<?php echo htmlspecialchars($penalty_type); ?>" required>
            <?php if(isset($errorMessages["penalty_type"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["penalty_type"]; ?></p>
            <?php } ?>
            
            <!-- Penalty Date -->
            <label for="penalty_date">Penalty Date:</label>
            <input type="date" id="penalty_date" name="penalty_date" value="<?php echo htmlspecialchars($penalty_date); ?>" required>
            <?php if(isset($errorMessages["penalty_date"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["penalty_date"]; ?></p>
            <?php } ?>
            
            <!-- Penalty Amount -->
            <label for="penalty_amount">Penalty Amount:</label>
            <input type="number" id="penalty_amount" name="penalty_amount" value="<?php echo htmlspecialchars($penalty_amount); ?>" min="0" required>
            <?php if(isset($errorMessages["penalty_amount"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["penalty_amount"]; ?></p>
            <?php } ?>
            
            <!-- Form Buttons -->
            <input type="submit" value="submit">
            <input type="button" value="Back" onclick="window.location.href='penaltiesExpensesList.php'">
        </form>
    </div>
</body>
</html>
