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
            }
?>

<?php
// Initialize variables to store form data and error messages
$vehicle_assignment = $driver_assignment = $start_datetime = $end_datetime = $origin = $destination = $purpose = $status = $cost = '';
$errorMessages = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST["submit"])) {
    // Retrieve form data
    $vehicle_assignment = $_POST["vehicle_assignment"];
    $driver_assignment = $_POST["driver_assignment"];
    $start_datetime = $_POST["start_datetime"];
    $end_datetime = $_POST["end_datetime"];
    $origin = $_POST["origin"];
    $destination = $_POST["destination"];
    $purpose = $_POST["purpose"];
    $status = $_POST["status"];
    $cost = $_POST["cost"];
    
}

    // Validate each input field
    if ($vehicle_assignment === "none") {
        $vehicle_assignment = $mission['vehicle_id'];
    }

    if ($driver_assignment === "none") {
        $driver_assignment = $mission['driver_id'];
    }


    if (empty($start_datetime) || $start_datetime == "0000-00-00 00:00:00") {  
        $start_datetime = $mission['start_date_time'];
    }elseif(!preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/', $start_datetime)){
        $errorMessages["start_datetime"] = "Please enter a valid start date and time.";
    }

    if (empty($end_datetime) || $end_datetime="0000-00-00 00:00:00") {       // Matches yyyy-mm-ddThh:mm
        $end_datetime = $mission['end_date_time'];
    }elseif(!preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/', $end_datetime)){
        $errorMessages["end_datetime"] = "Please enter a valid end date and time.";
    }

    if (empty($origin)){
        $origin = $mission['start_location'];
    }elseif(!preg_match("/^[a-zA-Z]+(?:[ ]*[a-zA-Z]+)*$/", $origin)){
        $errorMessages["origin"] = "Please enter a valid origin location.";
    }elseif($origin == $destination){
        $errorMessages["origin"] = "Origin and destination cannot be the same.";
    }

    if (empty($destination) || !preg_match("/^[a-zA-Z]+(?:[ ]*[a-zA-Z]+)*$/", $destination)){
        $destination = $mission['end_location'];
    }elseif( !preg_match("/^[a-zA-Z]+(?:[ ]*[a-zA-Z]+)*$/", $destination)){
        $errorMessages["destination"] = "Please enter a valid destination location.";
    }elseif($origin == $destination){
        $errorMessages["destination"] = "Origin and destination cannot be the same.";
    }

    if (empty($purpose)){
        $purpose = $mission['purpose'];
    }elseif(!preg_match("/^[a-zA-Z]+(?:[ ]*[a-zA-Z]+)*$/", $purpose)){
        $errorMessages["purpose"] = "Please enter a valid purpose.";
    }

    if (empty($cost) ) {
        $cost = $mission['cost'];
    }elseif($cost == 0|| !is_numeric($cost) || $cost < 0){
        $errorMessages["cost"] = "Please enter a valid psitive cost.";
    }

    if ($status == "none") {
        $status = $mission['mission_status'];
    }else{

    if(!in_array($status, ["scheduled", "in_progress", "completed", "cancelled"])){
        $errorMessages["status"] = "Please select a valid status.";
    }
    
    date_default_timezone_set('Africa/Algiers');
    /*if($status == "completed" && $end_datetime > date("Y-m-d\TH:i")){
        $errorMessages["status"] = "Mission cannot be completed before the end date and time.";
    }

    if($status == "cancelled" && $end_datetime < date("Y-m-d\TH:i")){
        $errorMessages["status"] = "Mission cannot be cancelled after the end date and time.";
    }

    if($status == "in_progress" && $start_datetime > date("Y-m-d\TH:i")){
        $errorMessages["status"] = "Mission cannot be in progress before the start date and time.";
    }

    if($status == "scheduled" && $start_datetime < date("Y-m-d\TH:i")){
        $errorMessages["status"] = "Mission cannot be scheduled after the start date and time.";
    }*/

    }

    // Process form data if no validation errors
    if (empty($errorMessages)) {
        // Process the form data (e.g., save to database)
        $sql = "UPDATE mission SET vehicle_id = ?, driver_id = ?, start_date_time = ?, end_date_time = ?, start_location = ?, end_location = ?, purpose = ?, mission_status = ?, cost = ? WHERE mission_id = ?";  // 'mission_id' is the primary key of your mission table

        $stmt = mysqli_prepare($link, $sql);

        // mission_id is the ID of the mission you want to update
        $stmt->bind_param("iissssssdi",$vehicle_assignment,$driver_assignment,$start_datetime,$end_datetime,$origin,$destination,$purpose,$status,$cost,$missionId);

        $stmt->execute();
        $stmt->close();


        if($status == "in_progress"){
            $sql = "UPDATE vehicle SET vehicle_status = 'in_service' WHERE vehicle_id = ?";
            $stmt = mysqli_prepare($link, $sql);
            $stmt->bind_param("i", $vehicle_assignment);
            $stmt->execute();
            $stmt->close();

            $sql = "UPDATE driver SET driver_status = 'active' WHERE driver_id = ?";
            $stmt = mysqli_prepare($link, $sql);
            $stmt->bind_param("i", $driver_assignment);
            $stmt->execute();
            $stmt->close();

            $sql = "UPDATE vehicle SET vehicle_location = ? where vehicle_id = ?";
            $stmt = mysqli_prepare($link, $sql);
            $stmt->bind_param("si", $origin, $vehicle_assignment);
            $stmt->execute();
            $stmt->close();
        }

        if($status == "completed" || $status == "cancelled"){
            $sql = "UPDATE vehicle SET vehicle_status = 'out_of_service' WHERE vehicle_id = ?";
            $stmt = mysqli_prepare($link, $sql);
            $stmt->bind_param("i", $vehicle_assignment);
            $stmt->execute();
            $stmt->close();

            $sql = "UPDATE driver SET driver_status = 'inactive' WHERE driver_id = ?";
            $stmt = mysqli_prepare($link, $sql);
            $stmt->bind_param("i", $driver_assignment);
            $stmt->execute();
            $stmt->close();
        }

        if($status == "completed"){
            $sql = "UPDATE vehicle SET vehicle_location = ? where vehicle_id = ?";
            $stmt = mysqli_prepare($link, $sql);
            $stmt->bind_param("si", $destination, $vehicle_assignment);
            $stmt->execute();
            $stmt->close();
        }


        // Redirect after successful submission
        header("Location: missionList.php");
        exit;
    }
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
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?id=".$missionId; ?>" method="post">

        
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


        <label for="driver_assignment">Driver Assignment:</label>
                <select id="driver_assignment" name="driver_assignment">
                    <option value="none" <?php if ($driver_assignment === 'none') echo "selected"; ?>>Actual</option>
                    <?php
                    // SQL query to retrieve inactive driver data
                    $sql = "SELECT driver_id, driver_name, driver_phone FROM driver WHERE driver_status = 'inactive'";
                    $result = mysqli_query($link, $sql);

                    // Check if any rows are returned
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            $driverId = $row["driver_id"];
                            $driverName = htmlspecialchars($row["driver_name"]);
                            $driverPhone = htmlspecialchars($row["driver_phone"]);

                            // Determine if this option should be selected
                            $selected = ($driver_assignment == $driverId) ? "selected" : "";

                            // Output the option with the appropriate value and selected attribute
                            echo '<option value="' . $driverId . '" ' . $selected . '>' . $driverName . ' - ' . $driverPhone . '</option>';
                        }
                    }
                    ?>
                </select>


            <label for="start_datetime">Start Date and Time:</label>
            <input type="datetime-local" id="start_datetime" name="start_datetime" value="<?php echo htmlspecialchars($start_datetime); ?>" >
            
            <?php if(isset($errorMessages["start_datetime"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["start_datetime"]; ?></p>
            <?php } ?>

            <label for="end_datetime">End Date and Time:</label>
            <input type="datetime-local" id="end_datetime" name="end_datetime" value="<?php echo htmlspecialchars($end_datetime); ?>" >
            
            <?php if(isset($errorMessages["end_datetime"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["end_datetime"]; ?></p>
            <?php } ?>

            <label for="origin">Origin Location:</label>
            <input type="text" id="origin" name="origin" value="<?php echo htmlspecialchars($origin); ?>" placeholder="<?php echo htmlspecialchars($mission['start_location']); ?>" >
            
            <?php if(isset($errorMessages["origin"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["origin"]; ?></p>
            <?php } ?>

            <label for="destination">Destination Location:</label>
            <input type="text" id="destination" name="destination" value="<?php echo htmlspecialchars($destination); ?>" placeholder="<?php echo htmlspecialchars($mission['end_location']); ?>">
            
            <?php if(isset($errorMessages["destination"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["destination"]; ?></p>
            <?php } ?>

            <label for="purpose">Purpose:</label>
            
            <textarea id="purpose" name="purpose" rows="4" cols="50" placeholder="<?php echo htmlspecialchars($mission['purpose']); ?>"><?php echo htmlspecialchars($purpose); ?></textarea>
            <?php if(isset($errorMessages["purpose"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["purpose"]; ?></p>
            <?php } ?>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="none" <?php if ($status == "none") echo "selected"; ?>>Actual</option>
                <option value="scheduled" <?php if($status == "scheduled") echo "selected"; ?>>Scheduled</option>
                <option value="in_progress" <?php if($status == "in_progress") echo "selected"; ?>>In Progress</option>
                <option value="completed" <?php if($status == "completed") echo "selected"; ?>>Completed</option>
                <option value="cancelled" <?php if($status == "cancelled") echo "selected"; ?>>Cancelled</option>
            </select>

            <?php if(isset($errorMessages["status"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["status"]; ?></p>
            <?php } ?>

            <label for="cost">Cost:</label>
            <input type="number" id="cost" name="cost" value="<?php echo htmlspecialchars($cost); ?>" min="0" placeholder="<?php echo htmlspecialchars($mission['cost']); ?>">
            <?php if(isset($errorMessages["cost"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["cost"]; ?></p>
            <?php } ?>

            <input type="submit" value="submit" name="submit">
            <input type="button" value="Back" onclick="window.location.href='missionList.php'">
        </form>
    </div>
</body>
</html>

<?php mysqli_close($link); ?>