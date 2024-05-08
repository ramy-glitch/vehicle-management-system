<?php

    $tab = array(
        "license_number" => $_POST["license_number"],
        "full_name" => $_POST["full_name"],
        "date_of_birth" => $_POST["date_of_birth"],
        "phone_number" => $_POST["phone_number"],
        "address" => $_POST["address"],
        "username" => $_POST["username"],
        "password" => $_POST["password"],
        "employment_date" => $_POST["employment_date"],
        "monthly_salary" => $_POST["monthly_salary"],
        "driving_history" => $_POST["driving_history"],
        "vehicle_assignment" => $_POST["vehicle_assignment"],
        "status" => $_POST["status"]
    );

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Information Form</title>
    <link rel="stylesheet" href="form.css"/>
</head>
<body>

    <div class="container">
        
        <h2>Driver Information: </h2>
        <form action="" method="post">

            <label for="license_number">Driver’s License Number:</label>
            <input type="text" id="license_number" name="license_number" required>

            <label for="full_name">Full Name:</label>
            <input type="text" id="full_name" name="full_name" required>

            <label for="date_of_birth">Date of Birth:</label>
            <input type="date" id="date_of_birth" name="date_of_birth" required>

            <label for="phone_number">Phone Number:</label>
            <input type="tel" id="phone_number" name="phone_number" required>
            
            <label for="address">Address:</label>
            <textarea id="address" name="address" rows="4" cols="50" required></textarea>
            
            <h3>Account Information:</h3>

            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <h3>Employment Information:</h3>

            <label for="employment_date">Employment Date:</label>
            <input type="date" id="employment_date" name="employment_date" required>

            <label for="monthly_salary">Monthly Salary(Da):</label>
            <input type="number" id="monthly_salary" name="monthly_salary" required>

            <label for="driving_history">Driving History:</label>
            <textarea id="driving_history" name="driving_history" rows="4" cols="50"></textarea>


            <label for="vehicle_assignment">Vehicle Assignment:</label>
            <input type="text" id="vehicle_assignment" name="vehicle_assignment">

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="on_leave">On Leave</option>
            </select>

            <input type="submit" value="Submit">
            <input type="button" value="Back" onclick="window.location.href='driversList.php'">
        </form>
    </div>
</body>
</html>

