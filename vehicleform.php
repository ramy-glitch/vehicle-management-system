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
$vehicle_type = $license_plate = $make_model = $color = $odometer_reading = $fuel_type = $insurance_info = $location = $current_status = '';
$errorMessages = [];

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    

    // Retrieve form data
    $vehicle_type = $_POST["vehicle_type"];
    $license_plate = $_POST["license_plate"];
    $make_model = $_POST["make_model"];
    $color = $_POST["color"];
    $odometer_reading = $_POST["odometer_reading"];
    $fuel_type = $_POST["fuel_type"];
    $insurance_info = $_POST["insurance_info"];
    $location = $_POST["location"];
    $current_status = "out_of_service"; // Default value for vehicle status is "out_of_service

    // Validate input fields
    if (empty($vehicle_type)) {
        $errorMessages["vehicle_type"] = "Please enter the type of vehicle.";
    }

    $pattern = '~^\d{5,6}-[1-9]\d{2}-([1-4][0-9]|5[0-8])$~';

    if (!preg_match($pattern, $license_plate)) {                                     // Matches 123456-123-58 or 12345-123-58
        $errorMessages["license_plate"] = "Please enter the license plate number.";
    }

    if (empty($make_model)) {
        $errorMessages["make_model"] = "Please enter the make and model of the vehicle.";
    }


    if (empty($color)) {
        $errorMessages["color"] = "Please enter the color of the vehicle.";
    }

    if (empty($odometer_reading) || !is_numeric($odometer_reading)) {
        $errorMessages["odometer_reading"] = "Please enter a valid odometer reading (in kilometers).";
    }

    if (empty($fuel_type)) {
        $errorMessages["fuel_type"] = "Please enter the fuel type of the vehicle.";
    }

    if (empty($insurance_info)) {
        $errorMessages["insurance_info"] = "Please enter insurance information for the vehicle.";
    }

    if (empty($location)) {
        $errorMessages["location"] = "Please enter the location of the vehicle.";
    }

    // Process form data if no validation errors
    if (empty($errorMessages)) {
        // Process the form data (e.g., save to database)
        
        // Prepare SQL statement with placeholders
        $sql = "INSERT INTO vehicle 
        (vehicle_type, vehicle_license_plate, vehicle_model, 
        vehicle_color, odometer_reading, fuel_type, inssurance_info, 
        vehicle_location, vehicle_status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Prepare the SQL query
        $stmt = mysqli_prepare($link, $sql);

        // Bind parameters with types
        $stmt->bind_param("ssssissss", 
        $vehicle_type, 
        $license_plate, 
        $make_model, 
        $color, 
        $odometer_reading, 
        $fuel_type, 
        $insurance_info, 
        $location, 
        $current_status
        );

        // Execute the prepared statement
        if (!$stmt->execute()) {
        echo "Error inserting vehicle record: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();




        // Redirect after successful submission
        header("Location: vehiclesList.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Information Form</title>
    <link rel="stylesheet" href="form.css">
</head>
<body>
    <div class="container">
        <h2>Vehicle Information</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            
            <!-- Type of Vehicle -->
            <label for="vehicle_type">Type of Vehicle:</label>
            <input type="text" id="vehicle_type" name="vehicle_type" value="<?php echo htmlspecialchars($vehicle_type); ?>" required>
            <?php if(isset($errorMessages["vehicle_type"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["vehicle_type"]; ?></p>
            <?php } ?>
            
            <!-- License Plate Number -->
            <label for="license_plate">License Plate Number:</label>
            <input type="text" id="license_plate" name="license_plate" value="<?php echo htmlspecialchars($license_plate); ?>" placeholder="xxxxxx-xxx-xx" required>
            <?php if(isset($errorMessages["license_plate"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["license_plate"]; ?></p>
            <?php } ?>
            
            <!-- Make and Model -->
            <label for="make_model">Make and Model:</label>
            <input type="text" id="make_model" name="make_model" value="<?php echo htmlspecialchars($make_model); ?>" required>
            <?php if(isset($errorMessages["make_model"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["make_model"]; ?></p>
            <?php } ?>
            
            
            <!-- Color -->
            <label for="color">Color:</label>
            <input type="text" id="color" name="color" value="<?php echo htmlspecialchars($color); ?>" required>
            <?php if(isset($errorMessages["color"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["color"]; ?></p>
            <?php } ?>
            
            <!-- Odometer Reading -->
            <label for="odometer_reading">Odometer Reading (Km):</label>
            <input type="number" id="odometer_reading" name="odometer_reading" value="<?php echo htmlspecialchars($odometer_reading); ?>" required>
            <?php if(isset($errorMessages["odometer_reading"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["odometer_reading"]; ?></p>
            <?php } ?>
            
            <!-- Fuel Type -->
            <label for="fuel_type">Fuel Type:</label>
            <input type="text" id="fuel_type" name="fuel_type" value="<?php echo htmlspecialchars($fuel_type); ?>" required>
            <?php if(isset($errorMessages["fuel_type"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["fuel_type"]; ?></p>
            <?php } ?>
            
            <!-- Insurance Information -->
            <label for="insurance_info">Insurance Information:</label>
            <textarea id="insurance_info" name="insurance_info" rows="4" cols="50" required><?php echo htmlspecialchars($insurance_info); ?></textarea>
            <?php if(isset($errorMessages["insurance_info"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["insurance_info"]; ?></p>
            <?php } ?>
            
            <!-- Location -->
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($location); ?>" required>
            <?php if(isset($errorMessages["location"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["location"]; ?></p>
            <?php } ?>
            
            <!-- Form Buttons -->
            <input type="submit" value="submit">
            <input type="button" value="Back" onclick="window.location.href='vehiclesList.php'">
        </form>
    </div>
</body>
</html>
<?php mysqli_close($link); ?>