<?php
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
    <title>Maintenance Information Form</title>
    <link rel="stylesheet" href="form.css">
</head>
<body>
    <div class="container">
        <h2>Maintenance Information Form</h2>
        <form>
        <?php

            $maintenanceId = $maintenance = null;
            // Retrieve vehicle ID from URL parameter
    if (isset($_GET['id'])) {
                $maintenanceId = $_GET['id'];


                // SQL query to retrieve maintenance data by ID
                $sql = "SELECT * FROM vehicle_maintenance WHERE maintenance_id = ?";
                $stmt = mysqli_prepare($link, $sql);
                $stmt->bind_param("i", $maintenanceId);
                $stmt->execute();
                $result = $stmt->get_result();

                // Display maintenance information in editable input fields
                if ($result->num_rows > 0) {
                    $maintenance = $result->fetch_assoc(); 
                }
                $stmt->close();

        ?>

        <label for="vehicle_assignment">Vehicle Assignment:</label>
                    <?php
                    // SQL query to retrieve vehicle data
                    $sql = "SELECT vehicle_id, vehicle_license_plate, vehicle_type, vehicle_model FROM vehicle WHERE vehicle_status = 'out_of_service'";
                    $result = mysqli_query($link, $sql);

                    // Check if any rows are returned
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            $vehicleType = htmlspecialchars($row["vehicle_type"]);
                            $vehicleModel = htmlspecialchars($row["vehicle_model"]);
                            $vehicle_pln = htmlspecialchars($row["vehicle_license_plate"]);


                            // Output the option with the appropriate value and selected attribute
                            echo '<input type="text" value="'  . $vehicleType . ' ' . $vehicleModel . ' ' . $vehicle_pln . '">';
                        }
                    }
                    ?>
            
            <!-- Date of Maintenance -->
            <label for="date_of_maintenance">Date of Maintenance:</label>
            <input type="text" id="date_of_maintenance" name="date_of_maintenance" value="<?php echo htmlspecialchars($maintenance['maintenance_date']); ?>" >
            
            <!-- Type of Maintenance -->
            <label for="maintenance_type">Type of Maintenance:</label>
            <input type="text" id="maintenance_type" name="maintenance_type" value="<?php echo htmlspecialchars($maintenance['maintenance_type']); ?>">

            
            <!-- Details of Maintenance -->
            <label for="maintenance_details">Details of Maintenance:</label>
            <textarea id="maintenance_details" name="maintenance_details" rows="4" ><?php echo htmlspecialchars($maintenance['maintenance_description']); ?></textarea>

            <!-- Workshop Name -->
            <label for="workshop_name">Workshop Name:</label>
            <input type="text" id="workshop_name" name="workshop_name" value="<?php echo htmlspecialchars($maintenance['workshop_name']); ?>">


            <!-- Workshop Phone -->
            <label for="workshop_phone">Workshop Phone:</label>
            <input type="tel" id="workshop_phone" name="workshop_phone" value="<?php echo htmlspecialchars($maintenance['workshop_phone']); ?>" >

            <!-- Cost -->
            <label for="cost">Cost (Da):</label>
            <input type="number" id="cost" name="cost" value="<?php echo htmlspecialchars($maintenance['cost']); ?>" >

            <!-- Status -->
            <label for="status">Status:</label>
            <input type="text" id="status" name="status" value="<?php echo htmlspecialchars($maintenance['maintenance_status']); ?>">

            <!-- Next Maintenance Date -->
            <label for="next_maintenance_date">Next Scheduled Maintenance:</label>
            <input type="text" id="next_maintenance_date" name="next_maintenance_date" value="<?php echo htmlspecialchars($maintenance['next_maintenance_date']); ?>">



            <input type="button" value="Back" onclick="window.location.href='maintenanceList.php'">
        </form>
    </div>
</body>
</html>
<?php } mysqli_close($link); ?>