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
    $maintenance_status = $_POST["status"];

    // Validate input fields
    
    if ($vehicle_assignment === "none") {
        $vehicle_assignment = $maintenance['vehicle_id'];
    }

    if (empty($date_of_maintenance) || $date_of_maintenance == "0000-00-00") {   // Matches yyyy-mm-dd
        $date_of_maintenance = $maintenance['maintenance_date'];
    }elseif(!preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $date_of_maintenance)){
        $errorMessages["date_of_maintenance"] = "Please enter a valid date.";
    }

    if (empty($maintenance_type)){     
        $maintenance_type = $maintenance['maintenance_type'];
    }elseif(!preg_match("/^[a-zA-Z]+(?:[ ]*[a-zA-Z]+)*$/", $maintenance_type)){
        $errorMessages["maintenance_type"] = "Please enter a valid type of maintenance.";
    }

    if (empty($maintenance_details)) {
        $maintenance_details = $maintenance['maintenance_description'];
    }

    if (empty($workshop_name)){     // Matches full name with spaces
        $workshop_name = $maintenance['workshop_name'];
    }elseif(!preg_match("/^[a-zA-Z]+(?:[ ]*[a-zA-Z]+)*$/", $workshop_name)){
        $errorMessages["workshop_name"] = "Please enter a valid workshop name.";}

    if (empty($workshop_phone)  ){     
        $workshop_phone = $maintenance['workshop_phone'];   
        
    }elseif(!preg_match("/^(02|07|05|06)\d{8}$/", $workshop_phone)){$errorMessages["workshop_phone"] = "Please enter a valid workshop phone number.";}

    if (empty($cost)) {
        $cost = $maintenance['cost'];
    }elseif( !is_numeric($cost) || $cost <= 0 ){
        $errorMessages["cost"] = "Please enter a valid cost for maintenance.";}

    if ($maintenance_status === "none") {
        $maintenance_status = $maintenance['maintenance_status'];
    }elseif(!in_array($maintenance_status, ["scheduled", "pending", "completed", "cancelled"])){
        $errorMessages["status"] = "Please select a valid status.";
    }
    

    if (empty($next_maintenance_date) || $next_maintenance_date == "0000-00-00") {   
        $next_maintenance_date = $maintenance['next_maintenance_date'];
    }elseif(!preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $next_maintenance_date)){
        $errorMessages["next_maintenance_date"] = "Please enter a valid date.";}

    // Process form data if no validation errors
    if (empty($errorMessages)) {

        // SQL query to update maintenance record
        
       // $sql = "UPDATE vehicle_maintenance SET vehicle_id = ? , maintenance_date = ? , maintenance_type = ? , maintenance_description = ? , workshop_name = ? , workshop_phone = ? , cost = ? , next_maintenance_date = ? , maintenance_status = ? WHERE maintenance_id = ?";  // Assuming 'maintenance_id' is the primary key of your vehicle_maintenance table
        $sql = "UPDATE vehicle_maintenance SET vehicle_id = '$vehicle_assignment', maintenance_date = '$date_of_maintenance', maintenance_type = '$maintenance_type', maintenance_description = '$maintenance_details', workshop_name = '$workshop_name', workshop_phone = '$workshop_phone', cost = '$cost', next_maintenance_date = '$next_maintenance_date', maintenance_status = '$maintenance_status' WHERE maintenance_id = '$maintenanceId'";  // Assuming 'maintenance_id' is the primary key of your vehicle_maintenance table
        $up = mysqli_query($link, $sql);

        //$stmt = mysqli_prepare($link, $sql);

        //  $maintenance_id is the ID of the maintenance record you want to update
        //$stmt->bind_param("isssssdssi",$vehicle_assignment,$date_of_maintenance,$maintenance_type,$maintenance_details,$workshop_name,$workshop_phone,$cost,$next_maintenance_date,$maintenance_status,$maintenance_Id); 

        //$stmt->execute();
        //$stmt->close();

        if ($maintenance_status == "completed" || $maintenance_status == "cancelled") {
            // SQL query to update vehicle status
            $sql = "UPDATE vehicle SET vehicle_status = 'out_of_service' WHERE vehicle_id = ?";
            $stmt = mysqli_prepare($link, $sql);
            $stmt->bind_param("i", $vehicle_assignment);
            $stmt->execute();
            $stmt->close();
        }
        
        if( $maintenance_status == "pending"){
            // SQL query to update vehicle status
            $sql = "UPDATE vehicle SET vehicle_status = 'under_maintenance' WHERE vehicle_id = ?";
            $stmt = mysqli_prepare($link, $sql);
            $stmt->bind_param("i", $vehicle_assignment);
            $stmt->execute();
            $stmt->close();
        }

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
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?id=".$maintenanceId; ?>" method="post">
            
        <label for="vehicle_assignment">Vehicle Assignment:</label>
                <select id="vehicle_assignment" name="vehicle_assignment">
                    <option value="none" <?php if ($vehicle_assignment === 'none') echo "selected"; ?>>Actual</option>
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
            <input type="date" id="date_of_maintenance" name="date_of_maintenance" value="<?php echo htmlspecialchars($date_of_maintenance); ?>" >
            <?php if(isset($errorMessages["date_of_maintenance"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["date_of_maintenance"]; ?></p>
            <?php } ?>
            
            <!-- Type of Maintenance -->
            <label for="maintenance_type">Type of Maintenance:</label>
            <input type="text" id="maintenance_type" name="maintenance_type" value="<?php echo htmlspecialchars($maintenance_type); ?>" placeholder="<?php echo htmlspecialchars($maintenance['maintenance_type']); ?>">
            <?php if(isset($errorMessages["maintenance_type"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["maintenance_type"]; ?></p>
            <?php } ?>
            
            <!-- Details of Maintenance -->
            <label for="maintenance_details">Details of Maintenance:</label>
            <textarea id="maintenance_details" name="maintenance_details" rows="4" placeholder="<?php echo htmlspecialchars($maintenance['maintenance_description']); ?>" ><?php echo htmlspecialchars($maintenance_details); ?></textarea>
            <?php if(isset($errorMessages["maintenance_details"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["maintenance_details"]; ?></p>
            <?php } ?>

            <!-- Workshop Name -->
            <label for="workshop_name">Workshop Name:</label>
            <input type="text" id="workshop_name" name="workshop_name" value="<?php echo htmlspecialchars($workshop_name); ?>" placeholder="<?php echo htmlspecialchars($maintenance['workshop_name']); ?>">
            <?php if(isset($errorMessages["workshop_name"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["workshop_name"]; ?></p>
            <?php } ?>

            <!-- Workshop Phone -->
            <label for="workshop_phone">Workshop Phone:</label>
            <input type="tel" id="workshop_phone" name="workshop_phone" value="<?php echo htmlspecialchars($workshop_phone); ?>" placeholder="<?php echo htmlspecialchars($maintenance['workshop_phone']); ?>" >
            <?php if(isset($errorMessages["workshop_phone"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["workshop_phone"]; ?></p>
            <?php } ?>

            <!-- Cost -->
            <label for="cost">Cost (Da):</label>
            <input type="number" id="cost" name="cost" value="<?php echo htmlspecialchars($cost); ?>" min="0" placeholder="<?php echo htmlspecialchars($maintenance['cost']); ?>" >
            <?php if(isset($errorMessages["cost"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["cost"]; ?></p>
            <?php } ?>

            <!-- Status -->
            <label for="status">Status:</label>
            <select id="status" name="status" >
            <option value="none" <?php if ($maintenance_status === 'none') echo "selected"; ?>>Actual</option>    
            <option value="scheduled" <?php if($maintenance_status == "scheduled") echo "selected"; ?>>Scheduled</option>
            <option value="pending" <?php if($maintenance_status == "pending") echo "selected"; ?>>Pending</option>
            <option value="completed" <?php if($maintenance_status == "completed") echo "selected"; ?>>Completed</option>
            <option value="cancelled" <?php if($maintenance_status == "cancelled") echo "selected"; ?>>Cancelled</option>
            </select>
            <?php if(isset($errorMessages["status"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["status"]; ?></p>
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