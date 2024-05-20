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
// Initialize variables to store form data and error messages
$driver_concerned = $penalty_type = $penalty_date = $penalty_amount = '';
$errorMessages = [];

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    
    // Retrieve form data
    $driver_concerned = $_POST["driver_concerned"];
    $penalty_type = $_POST["penalty_type"];
    $penalty_date = $_POST["penalty_date"];
    $penalty_amount = $_POST["penalty_amount"];

    // Validate input fields

    if ($driver_concerned === "none") {
        $errorMessages["driver_concerned"] = "Please select a driver assignment.";
    }

    if (empty($penalty_type) || !preg_match("/^[a-zA-Z]+(?:[ ]*[a-zA-Z]+)*$/", $penalty_type)){
        $errorMessages["penalty_type"] = "Please enter the penalty type.";
    }

    if (empty($penalty_date) || !preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $penalty_date)) {
        $errorMessages["penalty_date"] = "Please enter the penalty date.";
    }

    if (empty($penalty_amount)|| !is_numeric($penalty_amount) || $penalty_amount < 0 ) {
        $errorMessages["penalty_amount"] = "Please enter a valid penalty amount.";
    }

    // Process form data if no validation errors
    if (empty($errorMessages)) {
        // Process the form data (e.g., save to database)

        // Prepare an INSERT statement
        $sql = "INSERT INTO penality_expense (driver_id, penality_type, penality_date, penality_cost)
                VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($link, $sql);
        $stmt->bind_param("issd", $driver_concerned, $penalty_type, $penalty_date, $penalty_amount);
        $stmt->execute();
        $stmt->close();

        // Redirect after successful submission
        header("Location: penaltiesExpensestList.php");
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
            
        
        <label for="driver_concerned">Driver Assignment:</label>
                <select id="driver_concerned" name="driver_concerned">
                    <option value="none" <?php if ($driver_concerned === 'none') echo "selected"; ?>>None</option>
                    <?php
                    // SQL query to retrieve inactive driver data
                    $sql = "SELECT driver_id, driver_name, driver_phone FROM driver ";
                    $result = mysqli_query($link, $sql);

                    // Check if any rows are returned
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            $driverId = $row["driver_id"];
                            $driverName = htmlspecialchars($row["driver_name"]);
                            $driverPhone = htmlspecialchars($row["driver_phone"]);

                            // Determine if this option should be selected
                            $selected = ($driver_concerned == $driverId) ? "selected" : "";

                            // Output the option with the appropriate value and selected attribute
                            echo '<option value="' . $driverId . '" ' . $selected . '>' . $driverName . ' - ' . $driverPhone . '</option>';
                        }
                    }
                    ?>
                </select>
            

            
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
            <input type="button" value="Back" onclick="window.location.href='penaltiesExpensestList.php'">
        </form>
    </div>
</body>
</html>
<?php mysqli_close($link); ?>