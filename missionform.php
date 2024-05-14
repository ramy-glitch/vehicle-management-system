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
$assigned_vehicle = $driver_name = $driver_phone = $start_datetime = $end_datetime = $origin = $destination = $purpose = $status = $cost = '';
$errorMessages = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST["submit"])) {
    // Retrieve form data
    $assigned_vehicle = $_POST["assigned_vehicle"];
    $driver_name = $_POST["driver_name"];
    $driver_phone = $_POST["driver_phone"];
    $start_datetime = $_POST["start_datetime"];
    $end_datetime = $_POST["end_datetime"];
    $origin = $_POST["origin"];
    $destination = $_POST["destination"];
    $purpose = $_POST["purpose"];
    $status = $_POST["status"];
    $cost = $_POST["cost"];}

    // Validate each input field
    if (empty($assigned_vehicle) || !preg_match("~^\d{5,6}-[1-9]\d{2}-([1-4][0-9]|5[0-8])$~", $assigned_vehicle)){     // Matches 123456-123-58 or 12345-123-58
        $errorMessages["assigned_vehicle"] = "Please enter a valid license plate number.";
    }

    if (empty($driver_name) || !preg_match("/^[a-zA-Z]+(?:[ ]*[a-zA-Z]+)*$/", $driver_name)){    // Matches full name with spaces
        $errorMessages["driver_name"] = "Please enter a valid driver name.";
    }

    if (empty($driver_phone) || !preg_match("/^(02|07|05|06)\d{8}$/", $driver_phone)){          // Matches 07xxxxxxxx or 05xxxxxxxx or 06xxxxxxxx or 02xxxxxxxx
        $errorMessages["driver_phone"] = "Please enter a valid driver phone number.";
    }


    if (empty($start_datetime) || !preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/', $start_datetime)) {  // Matches yyyy-mm-ddThh:mm
        $errorMessages["start_datetime"] = "Please enter a valid start date and time.";
    }

    if (empty($end_datetime) || !preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/', $end_datetime)) {       // Matches yyyy-mm-ddThh:mm
        $errorMessages["end_datetime"] = "Please enter a valid end date and time.";
    }

    if (empty($origin) || !preg_match("/^[a-zA-Z]+(?:[ ]*[a-zA-Z]+)*$/", $origin)){
        $errorMessages["origin"] = "Please enter a valid origin location.";
    }

    if (empty($destination) || !preg_match("/^[a-zA-Z]+(?:[ ]*[a-zA-Z]+)*$/", $destination)){
        $errorMessages["destination"] = "Please enter a valid destination location.";
    }

    if (empty($purpose) || !preg_match("/^[a-zA-Z]+(?:[ ]*[a-zA-Z]+)*$/", $purpose)){
        $errorMessages["purpose"] = "Please enter a valid purpose.";
    }

    if (empty($cost) || !is_numeric($cost) || $cost < 0) {
        $errorMessages["cost"] = "Please enter a valid non-negative cost.";
    }

    // Process form data if no validation errors
    if (empty($errorMessages)) {
        // Process the form data (e.g., save to database)
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
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

            <label for="assigned_vehicle">License Plate Number:</label>
            <input type="text" id="assigned_vehicle" name="assigned_vehicle" value="<?php echo htmlspecialchars($assigned_vehicle); ?>" placeholder="xxxxxx-xxx-xx" required>
            <?php if(isset($errorMessages["assigned_vehicle"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["assigned_vehicle"]; ?></p>
            <?php } ?>

            <label for="driver_name">Driver full Name:</label>
            <input type="text" id="driver_name" name="driver_name" value="<?php echo htmlspecialchars($driver_name); ?>" required>
            <?php if(isset($errorMessages["driver_name"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["driver_name"]; ?></p>
            <?php } ?>

            <label for="driver_phone">Driver Phone:</label>
            <input type="text" id="driver_phone" name="driver_phone" value="<?php echo htmlspecialchars($driver_phone); ?>" required>
            <?php if(isset($errorMessages["driver_phone"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["driver_phone"]; ?></p>
            <?php } ?>

            <label for="start_datetime">Start Date and Time:</label>
            <input type="datetime-local" id="start_datetime" name="start_datetime" value="<?php echo htmlspecialchars($start_datetime); ?>" required>
            <?php if(isset($errorMessages["start_datetime"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["start_datetime"]; ?></p>
            <?php } ?>

            <label for="end_datetime">End Date and Time:</label>
            <input type="datetime-local" id="end_datetime" name="end_datetime" value="<?php echo htmlspecialchars($end_datetime); ?>" required>
            <?php if(isset($errorMessages["end_datetime"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["end_datetime"]; ?></p>
            <?php } ?>

            <label for="origin">Origin Location:</label>
            <input type="text" id="origin" name="origin" value="<?php echo htmlspecialchars($origin); ?>" required>
            <?php if(isset($errorMessages["origin"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["origin"]; ?></p>
            <?php } ?>

            <label for="destination">Destination Location:</label>
            <input type="text" id="destination" name="destination" value="<?php echo htmlspecialchars($destination); ?>" required>
            <?php if(isset($errorMessages["destination"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["destination"]; ?></p>
            <?php } ?>

            <label for="purpose">Purpose:</label>
            <textarea id="purpose" name="purpose" rows="4" cols="50" required><?php echo htmlspecialchars($purpose); ?></textarea>
            <?php if(isset($errorMessages["purpose"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["purpose"]; ?></p>
            <?php } ?>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="scheduled" <?php if($status == "scheduled") echo "selected"; ?>>Scheduled</option>
                <option value="in_progress" <?php if($status == "in_progress") echo "selected"; ?>>In Progress</option>
                <option value="completed" <?php if($status == "completed") echo "selected"; ?>>Completed</option>
                <option value="cancelled" <?php if($status == "cancelled") echo "selected"; ?>>Cancelled</option>
            </select>

            <label for="cost">Cost:</label>
            <input type="number" id="cost" name="cost" value="<?php echo htmlspecialchars($cost); ?>" min="0" required>
            <?php if(isset($errorMessages["cost"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["cost"]; ?></p>
            <?php } ?>

            <input type="submit" value="submit" name="submit">
            <input type="button" value="Back" onclick="window.location.href='missionList.php'">
        </form>
    </div>
</body>
</html>
