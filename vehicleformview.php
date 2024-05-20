<?php

session_start();
if (!isset($_SESSION['adminid'])) {

    header("Location: loginpage.php");
    exit;
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
        <form>
            <!-- Display Vehicle Information -->
            <?php
            // Include database connection file

            if (file_exists('dblink.php')) 
            {
                require 'dblink.php';
            }
            else {
                die("File not found");
            }

            // Retrieve vehicle ID from URL parameter
            if (isset($_GET['id'])) {
                $vehicleId = $_GET['id'];

                // SQL query to retrieve vehicle data by ID
                $sql = "SELECT * FROM vehicle WHERE vehicle_id = ?";
                $stmt = mysqli_prepare($link, $sql);
                $stmt->bind_param("i", $vehicleId);
                $stmt->execute();
                $result = $stmt->get_result();

                // Display vehicle information
                if ($result->num_rows > 0) {
                    $vehicle = $result->fetch_assoc();
                    ?>
                    <label for="vehicle_type">Type of Vehicle:</label>
                    <input type="text" id="vehicle_type" name="vehicle_type" value="<?php echo htmlspecialchars($vehicle['vehicle_type']); ?>" readonly>
                    <br>
                    <label for="license_plate">License Plate Number:</label>
                    <input type="text" id="license_plate" name="license_plate" value="<?php echo htmlspecialchars($vehicle['vehicle_license_plate']); ?>" readonly>
                    <br>
                    <label for="make_model">Make and Model:</label>
                    <input type="text" id="make_model" name="make_model" value="<?php echo htmlspecialchars($vehicle['vehicle_model']); ?>" readonly>
                    <br>

                    <label for="color">Color:</label>
                    <input type="text" id="color" name="color" value="<?php echo htmlspecialchars($vehicle['vehicle_color']); ?>" readonly>
                    <br>
                    <label for="odometer_reading">Odometer Reading (Km):</label>
                    <input type="number" id="odometer_reading" name="odometer_reading" value="<?php echo htmlspecialchars($vehicle['odometer_reading']); ?>" readonly>
                    <br>
                    <label for="fuel_type">Fuel Type:</label>
                    <input type="text" id="fuel_type" name="fuel_type" value="<?php echo htmlspecialchars($vehicle['fuel_type']); ?>" readonly>
                    <br>
                    <label for="insurance_info">Insurance Information:</label>
                    <textarea id="insurance_info" name="insurance_info" rows="4" readonly><?php echo htmlspecialchars($vehicle['inssurance_info']); ?></textarea>
                    <br>
                    <label for="location">Location:</label>
                    <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($vehicle['vehicle_location']); ?>" readonly>
                    <br>
                    <label for="current_status">Current Status:</label>
                    <input type="text" id="current_status" name="current_status" value="<?php echo htmlspecialchars($vehicle['vehicle_status']); ?>" readonly>
                    <br>

                    <?php
                } else {
                    echo "Vehicle not found.";
                }
            } else {
                echo "Invalid request.";
            }

            // Close database connection
            mysqli_close($link);
            ?>

            <!-- Back Button -->
            <input type="button" value="Back" onclick="window.location.href='vehiclesList.php'">
        </form>
    </div>


</body>
</html>
