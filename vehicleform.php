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
    <form action="" method="post">

        <label for="vehicle_type">Type of Vehicle:</label>
        <input type="text" id="vehicle_type" name="vehicle_type" required>

        <label for="license_plate">License Plate Number:</label>
        <input type="text" id="license_plate" name="license_plate" required>

        <label for="make_model">Make and Model:</label>
        <input type="text" id="make_model" name="make_model" required>

        <label for="year_manufacture">Year of Manufacture:</label>
        <input type="number" id="year_manufacture" name="year_manufacture" min="1900" max="2100" required>

        <label for="color">Color:</label>
        <input type="text" id="color" name="color" required>

        <label for="odometer_reading">Odometer Reading (Km):</label>
        <input type="number" id="odometer_reading" name="odometer_reading" required>

        <label for="fuel_type">Fuel Type:</label>
        <input type="text" id="fuel_type" name="fuel_type" required>

        <label for="insurance_info">Insurance Information:</label>
        <textarea id="insurance_info" name="insurance_info" rows="4" cols="50" required></textarea>

        <label for="location">Location:</label>
        <input type="text" id="location" name="location" required>
        
        <label for="current_status">Current Status:</label>
        <select id="current_status" name="current_status" required>
            <option value="in_service">In Service</option>
            <option value="under_maintenance">Under Maintenance</option>
            <option value="out_of_service">Out of Service</option>
        </select>


        <input type="submit" value="Submit">
        <input type="button" value="Back" onclick="window.location.href='vehiclesList.php'">
    </form>
    </div>
</body>
</html>
