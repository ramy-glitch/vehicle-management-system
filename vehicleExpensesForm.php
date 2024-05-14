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
// Initialize variables to store form data and error messages
$vehicle_LP = $type_of_expense = $fee_date = $amount = '';
$errorMessages = [];

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $vehicle_LP = $_POST["vehicle_LP"];
    $type_of_expense = $_POST["type_of_expense"];
    $fee_date = $_POST["fee_date"];
    $amount = $_POST["amount"];

    // Validate input fields
    if (empty($vehicle_LP) || !preg_match("~^\d{5,6}-[1-9]\d{2}-([1-4][0-9]|5[0-8])$~", $vehicle_LP)){   // Matches 123456-123-58 or 12345-123-58
        $errorMessages["vehicle_LP"] = "Please enter the license plate number.";
    }

    if (empty($type_of_expense)) {
        $errorMessages["type_of_expense"] = "Please enter the type of expense.";
    }

    if (empty($fee_date) || !preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $fee_date)) {
        $errorMessages["fee_date"] = "Please enter the date of the expense.";
    }

    if (empty($amount) || !is_numeric($amount) || $amount <= 0 ) {
        $errorMessages["amount"] = "Please enter a valid amount.";
    }

    // Process form data if no validation errors
    if (empty($errorMessages)) {
        // Process the form data (e.g., save to database)
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
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            
            <!-- License Plate Number -->
            <label for="vehicle_LP">License Plate Number:</label>
            <input type="text" id="vehicle_LP" name="vehicle_LP" value="<?php echo htmlspecialchars($vehicle_LP); ?>" placeholder="xxxxxx-xxx-xx" required>
            <?php if(isset($errorMessages["vehicle_LP"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["vehicle_LP"]; ?></p>
            <?php } ?>
            
            <!-- Type of Expense -->
            <label for="type_of_expense">Type of Expense:</label>
            <input type="text" id="type_of_expense" name="type_of_expense" value="<?php echo htmlspecialchars($type_of_expense); ?>" required>
            <?php if(isset($errorMessages["type_of_expense"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["type_of_expense"]; ?></p>
            <?php } ?>
            
            <!-- Date of Expense -->
            <label for="fee_date">Date:</label>
            <input type="date" id="fee_date" name="fee_date" value="<?php echo htmlspecialchars($fee_date); ?>" required>
            <?php if(isset($errorMessages["fee_date"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["fee_date"]; ?></p>
            <?php } ?>
            
            <!-- Amount -->
            <label for="amount">Amount:</label>
            <input type="number" id="amount" name="amount" value="<?php echo htmlspecialchars($amount); ?>" min="0" required>
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


