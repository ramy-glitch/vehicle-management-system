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
    $status = "inactive";

    // Validate each input field
    if (empty($license_number) || !preg_match("/^[a-zA-Z0-9]{9}$/", $license_number)){ // Matches 9 characters of letters and numbers
        $errorMessages["license_number"] = "Please enter a valid driver's license number.";
    }

    if (empty($full_name) || !preg_match("/^[a-zA-Z]+(?:[ ]*[a-zA-Z]+)*$/", $full_name)) { // Matches full name with spaces
        $errorMessages["full_name"] = "Please enter a valid full name.";
    }

    
    $pattern = '/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/';       // Matches yyyy-mm-dd


    $month = $day = $year = 0; 
    

    
    if (isset($date_of_birth)) {
        
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
    
    }else{
        $errorMessages["date_of_birth"] = "Please enter a valid date of birth.";
    }
    
    if (empty($phone_number) || !preg_match("/^(02|07|05|06)\d{8}$/", $phone_number)) {  // Matches 07xxxxxxxx or 05xxxxxxxx or 06xxxxxxxx or 02xxxxxxxx
        $errorMessages["phone_number"] = "Please enter a valid phone number.";
    }

    if (empty($address)) {
        $errorMessages["address"] = "Please enter a valid address.";
    }


    if (empty($username)) {
        $errorMessages["username"] = "Please enter a valid username.";
    }

    $sql = "SELECT * FROM driver WHERE username = ?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    if ($row) {
        $errorMessages["username"] = "Username already exists.";
    }

    if (empty($password)) {
        $errorMessages["password"] = "Please enter a valid password.";
    }

    if (strlen($password) < 8) {
        $errorMessages["password"] = "Password must be at least 8 characters long.";
    }

    // Further validation to ensure it's a valid date
    if (isset($employment_date) ) {
        
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
    }else{
        $errorMessages["employment_date"] = "Please enter a valid employment date.";
    }

    if (empty($monthly_salary) || !is_numeric($monthly_salary) || $monthly_salary < 0){
        $errorMessages["monthly_salary"] = "Please enter a valid monthly salary.";
    }

    if (empty($driving_history)) {
        $errorMessages["driving_history"] = "Please enter a valid driving history.";
    }



    // Process form data if no validation errors
    if (empty($errorMessages)) {
        // Process the form data (e.g., save to database)

        $passwordh = password_hash($password, PASSWORD_DEFAULT); // Hash the password before saving to the database

        // SQL query to insert data into the database  
        

        $sql = "INSERT INTO driver (driver_name, driver_birthdate, driver_phone, driver_address, username, pwd, employment_date, monthly_salary, driver_history, driver_status, driver_license_number) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($link, $sql);     

        // Use "s" for string types and "d" for double/float types
        // Use "s" for date types as well (assuming date values are passed as strings)
        mysqli_stmt_bind_param($stmt, "sssssssdsss", $full_name, $date_of_birth, $phone_number, $address, $username, $passwordh, $employment_date, $monthly_salary, $driving_history, $status, $license_number);
        
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
        
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            
        <label for="license_number">Driver’s License Number:</label>
            <input type="text" id="license_number" name="license_number" value="<?php echo htmlspecialchars($license_number); ?>" placeholder="xxxxxxxxx" required>
            
            <?php if(isset($errorMessages["license_number"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["license_number"]; ?></p>
            <?php } ?>

            
            <label for="full_name">Full Name:</label>
            <input type="text" id="full_name" name="full_name" value="<?php echo htmlspecialchars($full_name); ?>" placeholder="your full name" required>
            
            <?php if(isset($errorMessages["full_name"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["full_name"]; ?></p>
            <?php } ?>

            
            <label for="date_of_birth">Date of Birth:</label>
            <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo htmlspecialchars($date_of_birth); ?>" required>
            
            <?php if(isset($errorMessages["date_of_birth"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["date_of_birth"]; ?></p>
            <?php } ?>

            <label for="phone_number">Phone Number:</label>
            <input type="tel" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>" placeholder="xxxxxxxxxx" required>
            
            <?php if(isset($errorMessages["phone_number"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["phone_number"]; ?></p>
            <?php } ?>

            <label for="address">Address:</label>
            <textarea id="address" name="address" rows="4" cols="50" required><?php echo htmlspecialchars($address); ?></textarea>
            
            <?php if(isset($errorMessages["address"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["address"]; ?></p>
            <?php } ?>

            
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
            <?php if(isset($errorMessages["username"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["username"]; ?></p>
            <?php } ?>

            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" value="<?php echo htmlspecialchars($password); ?>" required>
            <?php if(isset($errorMessages["password"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["password"]; ?></p>
            <?php } ?>

            
            <label for="employment_date">Employment Date:</label>
            <input type="date" id="employment_date" name="employment_date" value="<?php echo htmlspecialchars($employment_date); ?>" required>
            <?php if(isset($errorMessages["employment_date"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["employment_date"]; ?></p>
            <?php } ?>

            
            <label for="monthly_salary">Monthly Salary (Da):</label>
            <input type="number" id="monthly_salary" name="monthly_salary" value="<?php echo htmlspecialchars($monthly_salary); ?>" required>
            <?php if(isset($errorMessages["monthly_salary"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["monthly_salary"]; ?></p>
            <?php } ?>

            
            <label for="driving_history">Driving History:</label>
            <textarea id="driving_history" name="driving_history" rows="4" cols="50"><?php echo htmlspecialchars($driving_history); ?></textarea>
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
