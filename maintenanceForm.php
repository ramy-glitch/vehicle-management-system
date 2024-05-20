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
$vehicle_assignment = $date_of_maintenance = $maintenance_type = $maintenance_details = $workshop_name = $workshop_phone = $cost = $next_maintenance_date = $maintenance_status = '';
$errorMessages = [];

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    
    // Retrieve form data
    $vehicle_assignment = $_POST["vehicle_assignment"];
    $date_of_maintenance = $_POST["date_of_maintenance"];
    $maintenance_type = $_POST["maintenance_type"];
    $maintenance_details = $_POST["maintenance_details"];
    $workshop_name = $_POST["workshop_name"];
    $workshop_phone = $_POST["workshop_phone"];
    $cost = $_POST["cost"];
    $next_maintenance_date = $_POST["next_maintenance_date"];
    $maintenance_status = "scheduled"; // Default value for maintenance status is "scheduled

    // Validate input fields
    
    if ($vehicle_assignment === "none") {
        $errorMessages["vehicle_assignment"] = "Please select a vehicle assignment.";
    }

    if (empty($date_of_maintenance) || !preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $date_of_maintenance)) {   // Matches yyyy-mm-dd
        $errorMessages["date_of_maintenance"] = "Please enter the date of maintenance.";
    }

    if (empty($maintenance_type) || !preg_match("/^[a-zA-Z]+(?:[ ]*[a-zA-Z]+)*$/", $maintenance_type)){     
        $errorMessages["maintenance_type"] = "Please enter the type of maintenance.";
    }

    if (empty($maintenance_details)) {
        $errorMessages["maintenance_details"] = "Please enter the details of maintenance.";
    }

    if (empty($workshop_name) || !preg_match("/^[a-zA-Z]+(?:[ ]*[a-zA-Z]+)*$/", $workshop_name)){     // Matches full name with spaces
        $errorMessages["workshop_name"] = "Please enter the workshop name.";
    }

    if (empty($workshop_phone) || !preg_match("/^(02|07|05|06)\d{8}$/", $workshop_phone)){        // Matches 07xxxxxxxx or 05xxxxxxxx or 06xxxxxxxx or 02xxxxxxxx
        $errorMessages["workshop_phone"] = "Please enter the workshop phone number.";
    }

    if (empty($cost) || !is_numeric($cost) || $cost <= 0 ) {
        $errorMessages["cost"] = "Please enter a valid cost for maintenance.";
    }

    if (empty($next_maintenance_date) || !preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $next_maintenance_date)) {   // Matches yyyy-mm-dd
        $errorMessages["next_maintenance_date"] = "Please enter the next scheduled maintenance date.";
    }

    // Process form data if no validation errors
    if (empty($errorMessages)) {
        // Process the form data (e.g., save to database)

        // SQL query to insert maintenance data
        
        $sql = "INSERT INTO vehicle_maintenance (vehicle_id, maintenance_date, maintenance_type, maintenance_description, workshop_name, workshop_phone, cost, next_maintenance_date, maintenance_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($link, $sql);
        $stmt->bind_param("isssssdss", $vehicle_assignment, $date_of_maintenance, $maintenance_type, $maintenance_details, $workshop_name, $workshop_phone, $cost, $next_maintenance_date, $maintenance_status);
        $stmt->execute();
        $stmt->close();

        // Redirect after successful submission
        header("Location: maintenanceList.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Information Form</title>
    <link rel="stylesheet" href="form.css">
</head>
<body>
    <div class="container">
        <h2>Maintenance Information Form</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            
        <label for="vehicle_assignment">Vehicle Assignment:</label>
                <select id="vehicle_assignment" name="vehicle_assignment">
                    <option value="none" <?php if ($vehicle_assignment === 'none') echo "selected"; ?>>None</option>
                    <?php
                    // SQL query to retrieve vehicle data
                    $sql = "SELECT vehicle_id, vehicle_license_plate, vehicle_type, vehicle_model FROM vehicle WHERE vehicle_status = 'out_of_service'";
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
            
            <!-- Date of Maintenance -->
            <label for="date_of_maintenance">Date of Maintenance:</label>
            <input type="date" id="date_of_maintenance" name="date_of_maintenance" value="<?php echo htmlspecialchars($date_of_maintenance); ?>" required>
            <?php if(isset($errorMessages["date_of_maintenance"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["date_of_maintenance"]; ?></p>
            <?php } ?>
            
            <!-- Type of Maintenance -->
            <label for="maintenance_type">Type of Maintenance:</label>
            <input type="text" id="maintenance_type" name="maintenance_type" value="<?php echo htmlspecialchars($maintenance_type); ?>" required>
            <?php if(isset($errorMessages["maintenance_type"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["maintenance_type"]; ?></p>
            <?php } ?>
            
            <!-- Details of Maintenance -->
            <label for="maintenance_details">Details of Maintenance:</label>
            <textarea id="maintenance_details" name="maintenance_details" rows="4" required><?php echo htmlspecialchars($maintenance_details); ?></textarea>
            <?php if(isset($errorMessages["maintenance_details"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["maintenance_details"]; ?></p>
            <?php } ?>

            <!-- Workshop Name -->
            <label for="workshop_name">Workshop Name:</label>
            <input type="text" id="workshop_name" name="workshop_name" value="<?php echo htmlspecialchars($workshop_name); ?>" required>
            <?php if(isset($errorMessages["workshop_name"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["workshop_name"]; ?></p>
            <?php } ?>

            <!-- Workshop Phone -->
            <label for="workshop_phone">Workshop Phone:</label>
            <input type="tel" id="workshop_phone" name="workshop_phone" value="<?php echo htmlspecialchars($workshop_phone); ?>" required>
            <?php if(isset($errorMessages["workshop_phone"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["workshop_phone"]; ?></p>
            <?php } ?>

            <!-- Cost -->
            <label for="cost">Cost (Da):</label>
            <input type="number" id="cost" name="cost" value="<?php echo htmlspecialchars($cost); ?>" min="0" required>
            <?php if(isset($errorMessages["cost"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["cost"]; ?></p>
            <?php } ?>

            <!-- Next Maintenance Date -->
            <label for="next_maintenance_date">Next Scheduled Maintenance:</label>
            <input type="date" id="next_maintenance_date" name="next_maintenance_date" value="<?php echo htmlspecialchars($next_maintenance_date); ?>">
            <?php if(isset($errorMessages["next_maintenance_date"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["next_maintenance_date"]; ?></p>
            <?php } ?>

            <!-- Form Buttons -->
            <input type="submit" value="submit">
            <input type="button" value="Back" onclick="window.location.href='maintenanceList.php'">
        </form>
    </div>
</body>
</html>
<?php mysqli_close($link); ?>