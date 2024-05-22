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



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mission Information Form</title>
    <link rel="stylesheet" href="form.css">
</head>
<body>
    <div class="container">
        <h2>Mission Information:</h2>
        <form>

            <?php
                
$missionId = $mission = null;
// Retrieve vehicle ID from URL parameter
            if (isset($_GET['id'])) {
                $missionId = $_GET['id'];


                // SQL query to retrieve mission data by ID
                $sql = "SELECT * FROM mission WHERE mission_id = ?";
                $stmt = mysqli_prepare($link, $sql);
                $stmt->bind_param("i", $missionId);
                $stmt->execute();
                $result = $stmt->get_result();

                // Display vehicle information in editable input fields
                if ($result->num_rows > 0) {
                    $mission = $result->fetch_assoc();
                }
                $stmt->close();

            ?>

        
        <label for="vehicle_assignment">Vehicle Assignment:</label>
                    <?php
                    // SQL query to retrieve vehicle data
                    $sql = "SELECT vehicle_license_plate, vehicle_type, vehicle_model FROM vehicle WHERE vehicle_id = $mission[vehicle_id]";
                    
                    $result = mysqli_query($link, $sql);

                    // Check if any rows are returned
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            $vehicleType = htmlspecialchars($row["vehicle_type"]);
                            $vehicleModel = htmlspecialchars($row["vehicle_model"]);
                            $vehicle_pln = htmlspecialchars($row["vehicle_license_plate"]);

                            // Output the option with the appropriate value and selected attribute
                            echo '<input type="text" value="'. $vehicleType . ' ' . $vehicleModel . ' ' . $vehicle_pln . '">';
                        }
                    }
                    ?>



        <label for="driver_assignment">Driver Assignment:</label>
                    <?php
                    // SQL query to retrieve inactive driver data
                    $sql = "SELECT driver_name, driver_phone FROM driver WHERE driver_id = $mission[driver_id]";
                    $result = mysqli_query($link, $sql);

                    // Check if any rows are returned
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            $driverName = htmlspecialchars($row["driver_name"]);
                            $driverPhone = htmlspecialchars($row["driver_phone"]);

                            // Output the option with the appropriate value and selected attribute
                            echo '<input type="text" value="' . $driverName . ' - ' . $driverPhone . '">';
                        }
                    }
                    ?>
                


            <label for="start_datetime">Start Date and Time:</label>
            <input type="text" id="start_datetime" name="start_datetime" value="<?php echo htmlspecialchars($mission['start_date_time']); ?>" readonly>

            <label for="end_datetime">End Date and Time:</label>
            <input type="text" id="end_datetime" name="end_datetime" value="<?php echo htmlspecialchars($mission['end_date_time']); ?>" readonly >

            <label for="origin">Origin Location:</label>
            <input type="text" id="origin" name="origin" value="<?php echo htmlspecialchars($mission['start_location']); ?>" readonly>
            

            <label for="destination">Destination Location:</label>
            <input type="text" id="destination" name="destination" value="<?php echo htmlspecialchars($mission['end_location']); ?>" readonly>

            <label for="purpose">Purpose:</label>
            <textarea id="purpose" name="purpose" rows="4" cols="50" readonly ><?php echo htmlspecialchars($mission['purpose']); ?></textarea>


            <label for="status">Status:</label>
            <input type="text" id="status" name="status" value="<?php echo htmlspecialchars($mission['mission_status']); ?>" readonly>

            <label for="cost">Cost:</label>
            <input type="text" id="cost" name="cost" value="<?php echo htmlspecialchars($mission['cost']); ?>" readonly>


            <input type="button" value="Back" onclick="window.location.href='missionList.php'">
        </form>
    </div>
</body>
</html>

<?php } mysqli_close($link); ?>