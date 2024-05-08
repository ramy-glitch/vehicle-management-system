<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mission Information Form</title>
    <link rel="stylesheet" href="form.css"/>
</head>
<body>
    <div class="container">
        <h2>Mission Information:</h2>
        <form action="/submit_mission_info" method="post">

            <label for="assigned_vehicle">Licence Plate Number:</label>
            <input type="text" id="assigned_vehicle" name="assigned_vehicle" required>

            <label for="driver_name">Driver name:</label>
            <input type="text" id="driver_name" name="driver_name" required>

            <label for="driver_phone">Driver phone:</label>
            <input type="text" id="driver_phone" name="driver_phone" required>

            <label for="start_datetime">Start Date and Time:</label>
            <input type="datetime-local" id="start_datetime" name="start_datetime" required>

            <label for="end_datetime">End Date and Time:</label>
            <input type="datetime-local" id="end_datetime" name="end_datetime" required>

            <label for="origin">Origin location:</label>
            <input type="text" id="origin" name="origin" required>

            <label for="destination">Destination location:</label>
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

            <label for="cost">Cost:</label>
            <input type="number" id="cost" name="cost" min="0" required>

            <input type="submit" value="Submit">
            <input type="button" value="Back" onclick="window.location.href='missionList.php'">
        </form>
    </div>
</body>
</html>
