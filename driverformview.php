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
    <title>Driver Information Form</title>
    <link rel="stylesheet" href="form.css">
</head>
<body>
    <div class="container">
        
    <h2>Driver Information:</h2>
        
        <form>
            
        <?php

$driverId = $driver = null;
// Retrieve vehicle ID from URL parameter
    if (isset($_GET['id'])) {
                $driverId = $_GET['id'];


                // SQL query to retrieve vehicle data by ID
                $sql = "SELECT * FROM driver WHERE driver_id = ?";
                $stmt = mysqli_prepare($link, $sql);
                $stmt->bind_param("i", $driverId);
                $stmt->execute();
                $result = $stmt->get_result();

                // Display vehicle information in editable input fields
                if ($result->num_rows > 0) {
                    $driver = $result->fetch_assoc();
                }
                $stmt->close();

?>

            <label for="license_number">Driver’s License Number:</label>
            <input type="text" id="license_number" name="license_number" value="<?php echo htmlspecialchars($driver['driver_license_number']); ?>" readonly>
            
            
            <label for="full_name">Full Name:</label>
            <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($driver['driver_name']); ?>" readonly >
            
            
            <label for="date_of_birth">Date of Birth:</label>
            <input type="text" id="date_of_birth" name="date_of_birth" value="<?php echo htmlspecialchars($driver['driver_birthdate']); ?>" readonly/> 


            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($driver['driver_phone']); ?>" readonly>


            <label for="address">Address:</label>
            <textarea id="address" name="address" rows="4" cols="50" readonly ><?php echo htmlspecialchars($driver['driver_address']); ?></textarea>


            
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($driver['username']); ?>" readonly >


            
            <label for="employment_date">Employment Date:</label>
            <input type="text" id="employment_date" name="employment_date" value="<?php echo htmlspecialchars($driver['employment_date']); ?>" readonly >


            
            <label for="monthly_salary">Monthly Salary (Da):</label>
            <input type="text" id="monthly_salary" name="monthly_salary" value="<?php echo htmlspecialchars($driver['monthly_salary']); ?>" readonly>


            
            <label for="driving_history">Driving History:</label>
            <textarea id="driving_history" name="driving_history" rows="4" cols="50" readonly ><?php echo htmlspecialchars($driver['driver_history']); ?></textarea>


            

            <input type="button" value="Back" onclick="window.location.href='driversList.php'">
        </form>
    </div>
</body>
</html>
<?php } mysqli_close($link); ?>