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

$vehicleId = $vehicle = null;
// Retrieve vehicle ID from URL parameter
            if (isset($_GET['id'])) {
                $vehicleId = $_GET['id'];


                // SQL query to retrieve vehicle data by ID
                $sql = "SELECT * FROM vehicle WHERE vehicle_id = ?";
                $stmt = mysqli_prepare($link, $sql);
                $stmt->bind_param("i", $vehicleId);
                $stmt->execute();
                $result = $stmt->get_result();

                // Display vehicle information in editable input fields
                if ($result->num_rows > 0) {
                    $vehicle = $result->fetch_assoc();
                }
            }
?>

<?php

// Initialize variables to store form data and error messages

$vehicle_type = $license_plate = $make_model = $color = $odometer_reading = $fuel_type = $insurance_info = $location = '';
$errorMessages = [];


// Process form submission

if ($_SERVER["REQUEST_METHOD"] == "POST" ) {



// Process form submission

    

    // Retrieve form data
    $vehicle_type = $_POST["vehicle_type"];
    $license_plate = $_POST["license_plate"];
    $make_model = $_POST["make_model"];
    $color = $_POST["color"];
    $odometer_reading = $_POST["odometer_reading"];
    $fuel_type = $_POST["fuel_type"];
    $insurance_info = $_POST["insurance_info"];
    $location = $_POST["location"];
    


    // Validate input fields
    if (empty($vehicle_type)) {
        $vehicle_type = $vehicle['vehicle_type'];
    }

    $pattern = '~^\d{5,6}-[1-9]\d{2}-([1-4][0-9]|5[0-8])$~';



    if (empty($license_plate)) {                               
        $license_plate = $vehicle['vehicle_license_plate'];
    }else {if (!preg_match($pattern, $license_plate)) {                                     // Matches 123456-123-58 or 12345-123-58
        $errorMessages["license_plate"] = "Please enter the license plate number."; 
    }}

    if (empty($make_model)) {
        $make_model = $vehicle['vehicle_model']; 
    }


    if (empty($color)) {
        $color = $vehicle['vehicle_color']; 
    }else{
        if (!preg_match("/^[a-zA-Z]+$/", $color)) {
        $errorMessages["color"] = "Please enter a valid color.";    
    }}

    if (empty($odometer_reading)) {
        $odometer_reading = $vehicle['odometer_reading'];}
    else{   if (!is_numeric($odometer_reading)) {
        $errorMessages["odometer_reading"] = "Please enter a valid odometer reading (in kilometers).";    
    }}


    if (empty($fuel_type)) {
        $fuel_type = $vehicle['fuel_type']; 
    }else{
        if (!preg_match("/^[a-zA-Z]+$/", $fuel_type)) {
        $errorMessages["fuel_type"] = "Please enter a valid fuel type.";    
    }}
        

    if (empty($insurance_info)) {
        $insurance_info = $vehicle['inssurance_info']; 
    }

    if (empty($location)) {
        $location = $vehicle['vehicle_location'];   
    }



    // Process form data if no validation errors
    if (empty($errorMessages)) {
        // Process the form data (e.g., save to database)
        
        // SQL query to update vehicle data
        
        $sql = "UPDATE vehicle SET vehicle_type = ?, vehicle_license_plate = ?, vehicle_model = ?, vehicle_color = ?, odometer_reading = ?, fuel_type = ?, inssurance_info = ?, vehicle_location = ? WHERE vehicle_id = ?";
        $stmt = mysqli_prepare($link, $sql); 
        $stmt->bind_param("ssssisssi", $vehicle_type, $license_plate, $make_model, $color, $odometer_reading, $fuel_type, $insurance_info, $location, $vehicleId);
        $stmt->execute();



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
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?id=".$vehicleId; ?>" method="post">
            
            <!-- Type of Vehicle -->
            <label for="vehicle_type">Type of Vehicle:</label>
            <input type="text" id="vehicle_type" name="vehicle_type" value="<?php echo htmlspecialchars($vehicle_type);?>" placeholder="<?php echo htmlspecialchars($vehicle['vehicle_type']); ?>" >
            <?php if(isset($errorMessages["vehicle_type"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["vehicle_type"]; ?></p>
            <?php } ?>
            
            <!-- License Plate Number -->
            <label for="license_plate">License Plate Number:</label>
            <input type="text" id="license_plate" name="license_plate" value="<?php echo htmlspecialchars($license_plate); ?>" placeholder="<?php echo $vehicle['vehicle_license_plate']; ?>" >
            <?php if(isset($errorMessages["license_plate"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["license_plate"]; ?></p>
            <?php } ?>
            
            <!-- Make and Model -->
            <label for="make_model">Make and Model:</label>
            <input type="text" id="make_model" name="make_model" value="<?php echo htmlspecialchars($make_model); ?>" placeholder="<?php echo $vehicle['vehicle_model']; ?>">
            <?php if(isset($errorMessages["make_model"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["make_model"]; ?></p>
            <?php } ?>
            
            <!-- Color -->
            <label for="color">Color:</label>
            <input type="text" id="color" name="color" value="<?php echo htmlspecialchars($color); ?>" placeholder="<?php echo $vehicle['vehicle_color']; ?>" >
            <?php if(isset($errorMessages["color"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["color"]; ?></p>
            <?php } ?>
            
            <!-- Odometer Reading -->
            <label for="odometer_reading">Odometer Reading (Km):</label>
            <input type="number" id="odometer_reading" name="odometer_reading" value="<?php echo htmlspecialchars($odometer_reading); ?>" placeholder="<?php echo $vehicle['odometer_reading']; ?>" >
            <?php if(isset($errorMessages["odometer_reading"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["odometer_reading"]; ?></p>
            <?php } ?>
            
            <!-- Fuel Type -->
            <label for="fuel_type">Fuel Type:</label>
            <input type="text" id="fuel_type" name="fuel_type" value="<?php echo htmlspecialchars($fuel_type); ?>" placeholder="<?php echo $vehicle['fuel_type']; ?>" >
            <?php if(isset($errorMessages["fuel_type"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["fuel_type"]; ?></p>
            <?php } ?>
            
            <!-- Insurance Information -->
            <label for="insurance_info">Insurance Information:</label>
            <textarea id="insurance_info" name="insurance_info" rows="4" cols="50" placeholder="<?php echo $vehicle['inssurance_info']; ?>" ><?php echo htmlspecialchars($insurance_info); ?></textarea>
            <?php if(isset($errorMessages["insurance_info"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["insurance_info"]; ?></p>
            <?php } ?>
            
            <!-- Location -->
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($location); ?>" placeholder="<?php echo $vehicle['vehicle_location']; ?>" >
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