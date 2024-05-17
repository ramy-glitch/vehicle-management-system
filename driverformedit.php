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
            }
?>

<?php
// Initialize variables to store form data and error messages

$license_number = $full_name = $date_of_birth = $phone_number = $address = $username = $password = $employment_date = $monthly_salary = $driving_history = $status = '';
$errorMessages = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    
    // Retrieve form data
    $license_number = $_POST["license_number"];
    $full_name = $_POST["full_name"];
    $date_of_birth = $_POST["date_of_birth"];
    $phone_number = $_POST["phone_number"];
    $address = $_POST["address"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $employment_date = $_POST["employment_date"];
    $monthly_salary = $_POST["monthly_salary"];
    $driving_history = $_POST["driving_history"];

    // Validate each input field
    if (empty($license_number)){ 
        $license_number = $driver['driver_license_number'];
    }else{
        if(!preg_match("/^[a-zA-Z0-9]{9}$/", $license_number)){$errorMessages["license_number"] = "Please enter a valid driver's license number.";}
    }

    if (empty($full_name)) { 
        $full_name = $driver['driver_name'];
    }else{
        if(!preg_match("/^[a-zA-Z]+(?:[ ]*[a-zA-Z]+)*$/", $full_name)){
            $errorMessages["full_name"] = "Please enter a valid full name.";}
    }

    
    $pattern = '/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/';       // Matches yyyy-mm-dd


    $month = $day = $year = 0; 
    

    
    if (empty($date_of_birth)) {
        $date_of_birth = $driver['driver_birthdate'];
    }else{
        if (!preg_match($pattern, $date_of_birth)) {
        $errorMessages["date_of_birth"] = "Please enter a valid date of birth.";
        }
        
        $date_parts = explode('-', $date_of_birth);
        $month = (int) $date_parts[1];
        $day = (int) $date_parts[2];
        $year = (int) $date_parts[0];
    
    
        if (!checkdate($month, $day, $year)) { 
            $errorMessages["date_of_birth"] = "Please enter a valid date of birth.";
        }

        date_default_timezone_set('Africa/Algiers');
        $currentDate = date('Y-m-d');
        $date_parts = explode('-', $currentDate);
        $currentyear = (int) $date_parts[0];
        $currentmonth = (int) $date_parts[1];
        $currentday = (int) $date_parts[2];

        if (($currentyear - $year) < 19) {
            $errorMessages["date_of_birth"] = "Driver must be at least 19 years old.";
        }
    }
    
    
    if (empty($phone_number)) {  // Matches 07xxxxxxxx or 05xxxxxxxx or 06xxxxxxxx or 02xxxxxxxx
        $phone_number = $driver['driver_phone'];
    }else{
        if (!preg_match("/^(02|07|05|06)\d{8}$/", $phone_number)) {
            $errorMessages["phone_number"] = "Please enter a valid phone number.";
        }
    }

    if (empty($address)) {
        $address = $driver['driver_address'];
    }

    if (empty($username)) {
        $username = $driver['username'];
    }

    if (empty($password)) {
        $password = $driver['pwd'];
    }elseif (strlen($password) < 8) {
        $errorMessages["password"] = "Password must be at least 8 characters long.";
    }else{
        $passwordh = password_hash($password, PASSWORD_DEFAULT);
    }
    



    // Further validation to ensure it's a valid date

    if (empty($employment_date)) {
        $employment_date = $driver['employment_date'];
    }else{
        
        if ( $employment_date == '0000-00-00' || !preg_match($pattern, $employment_date)) {                                 // Matches yyyy-mm-dd           
            $errorMessages["employment_date"] = "Please enter a valid employment date.";
        }

        $date_parts = explode('-', $employment_date);
        $month = (int) $date_parts[1];
        $day = (int) $date_parts[2];
        $year = (int) $date_parts[0];
    

        if (!checkdate($month, $day, $year)) {
            $errorMessages["employment_date"] = "Please enter a valid employment date.";
        }

        if ($currentyear < $year || ($currentyear == $year && $currentmonth < $month) || ($currentyear == $year && $currentmonth == $month && $currentday < $day)){
            $errorMessages["employment_date"] = "Employment date cannot be in the future.";
        }

        if (2010> $year){
            $errorMessages["employment_date"] = "Employment date cannot be before business creation(2010).";
        }
    }

    if (empty($monthly_salary) ){
        $monthly_salary = $driver['monthly_salary'];
    }else{
        if (!is_numeric($monthly_salary) || $monthly_salary < 0) {
            $errorMessages["monthly_salary"] = "Please enter a valid monthly salary.";
        }
    }

    if (empty($driving_history)) {
        $driving_history = $driver['driver_history'];
    }



    // Process form data if no validation errors
    if (empty($errorMessages)) {
        // Process the form data (e.g., save to database)

        


        

        // SQL query to update driver information
        $sql = "UPDATE driver SET driver_name = ?, driver_birthdate = ?, driver_phone = ?, driver_address = ?, username = ?, pwd = ?, employment_date = ?, monthly_salary = ?, driver_history = ?, driver_license_number = ? WHERE driver_id = ?";
        $stmt = mysqli_prepare($link, $sql);     

        // Use "s" for string types and "d" for double/float types
        // Use "s" for date types as well (assuming date values are passed as strings)
        mysqli_stmt_bind_param($stmt, "sssssssdssi", $full_name, $date_of_birth, $phone_number, $address, $username, $passwordh, $employment_date, $monthly_salary, $driving_history, $license_number, $driverId);
        
        // Execute the prepared statement
        mysqli_stmt_execute($stmt);
        




        // Redirect after successful submission
        header("Location: driversList.php");
        exit;
    }
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
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?id=".$driverId; ?>" method="post">
            
        <label for="license_number">Driver’s License Number:</label>
            <input type="text" id="license_number" name="license_number" value="<?php echo htmlspecialchars($license_number); ?>" placeholder="<?php echo htmlspecialchars($driver['driver_license_number']); ?>" >
            
            <?php if(isset($errorMessages["license_number"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["license_number"]; ?></p>
            <?php } ?>

            
            <label for="full_name">Full Name:</label>
            <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($full_name); ?>" placeholder="<?php echo htmlspecialchars($driver['driver_name']); ?>" >
            
            <?php if(isset($errorMessages["full_name"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["full_name"]; ?></p>
            <?php } ?>

            
            <label for="date_of_birth">Date of Birth:</label>
            <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo htmlspecialchars($date_of_birth); ?>" placeholder="<?php echo htmlspecialchars($driver['driver_birthdate']); ?>" /> >
            
            <?php if(isset($errorMessages["date_of_birth"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["date_of_birth"]; ?></p>
            <?php } ?>

            <label for="phone_number">Phone Number:</label>
            <input type="tel" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>" placeholder="<?php echo htmlspecialchars($driver['driver_phone']); ?>">
            
            <?php if(isset($errorMessages["phone_number"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["phone_number"]; ?></p>
            <?php } ?>

            <label for="address">Address:</label>
            <textarea id="address" name="address" rows="4" cols="50" placeholder="<?php echo htmlspecialchars($driver['driver_address']); ?>" ><?php echo htmlspecialchars($address); ?></textarea>
            
            <?php if(isset($errorMessages["address"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["address"]; ?></p>
            <?php } ?>

            
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username);?>" placeholder="<?php echo htmlspecialchars($driver['username']); ?>" >
            <?php if(isset($errorMessages["username"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["username"]; ?></p>
            <?php } ?>

            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($password); ?>" placeholder="<?php echo htmlspecialchars($driver['pwd']); ?>" >
            <?php if(isset($errorMessages["password"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["password"]; ?></p>
            <?php } ?>

            
            <label for="employment_date">Employment Date:</label>
            <input type="date" id="employment_date" name="employment_date" value="<?php echo htmlspecialchars($employment_date); ?>" placeholder="<?php echo htmlspecialchars($driver['employment_date']); ?>" >
            <?php if(isset($errorMessages["employment_date"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["employment_date"]; ?></p>
            <?php } ?>

            
            <label for="monthly_salary">Monthly Salary (Da):</label>
            <input type="number" id="monthly_salary" name="monthly_salary" value="<?php echo htmlspecialchars($monthly_salary); ?>" placeholder="<?php echo htmlspecialchars($driver['monthly_salary']); ?>">
            <?php if(isset($errorMessages["monthly_salary"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["monthly_salary"]; ?></p>
            <?php } ?>

            
            <label for="driving_history">Driving History:</label>
            <textarea id="driving_history" name="driving_history" rows="4" cols="50" placeholder="<?php echo htmlspecialchars($driver['driver_history']); ?>"><?php echo htmlspecialchars($driving_history); ?></textarea>
            <?php if(isset($errorMessages["driving_history"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["driving_history"]; ?></p>
            <?php } ?>

            

            <input type="submit" name="submit" value="Submit">
            <input type="button" value="Back" onclick="window.location.href='driversList.php'">
        </form>
    </div>
</body>
</html>
<?php mysqli_close($link); ?>
