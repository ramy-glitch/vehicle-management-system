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
    <title>Mission Information</title>
    <link rel="stylesheet" href="form.css"/>
</head>
<body>
    <div class="container">
        <h2>Mission Information:</h2>
        <form>
            <label for="mission_id">Mission ID:</label>
            <input type="text" id="mission_id" name="mission_id" required>

            <label for="assigned_vehicle">Assigned Vehicle:</label>
            <input type="text" id="assigned_vehicle" name="assigned_vehicle" required>

            <label for="assigned_driver">Assigned Driver:</label>
            <input type="text" id="assigned_driver" name="assigned_driver" required>

            <label for="start_datetime">Start Date and Time:</label>
            <input type="datetime-local" id="start_datetime" name="start_datetime" required>

            <label for="end_datetime">End Date and Time:</label>
            <input type="datetime-local" id="end_datetime" name="end_datetime" required>

            <label for="origin">Origin:</label>
            <input type="text" id="origin" name="origin" required>

            <label for="destination">Destination:</label>
            <input type="text" id="destination" name="destination" required>

            <label for="purpose">Purpose:</label>
            <textarea id="purpose" name="purpose" rows="4" cols="50" required></textarea>

            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="scheduled">Scheduled</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>

            <input type="button" value="Back" onclick="window.location.href='dmissionsList.php'">
        </form>
    </div>
</body>
</html>
