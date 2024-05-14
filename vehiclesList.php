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
    <title>List of Vehicles</title>
    <link  rel="stylesheet" href="style.css"/>
</head>
<body>

<div class="navbar">
    <div class="navbar-brand"><a href="adminHomePage.php">Admin Dashboard</a></div>
    <ul class="navbar-menu">
        <li class="navbar-item"><a href="adminHomePage.php" class="nav-link">Dashboard</a></li>
        <li class="navbar-item"><a href="vehiclesList.php" class="nav-link">Vehicles</a></li>
        <li class="navbar-item"><a href="driversList.php" class="nav-link">Drivers</a></li>
        <li class="navbar-item"><a href="maintenanceList.php" class="nav-link">Maintenances</a></li>
        <li class="navbar-item"><a href="missionList.php" class="nav-link">Missions</a></li>
        <li class="navbar-item"><a href="#" class="nav-link">Notifications</a></li>
        
        <li class="navbar-item"><a href="#" class="nav-link">Reports</a>
        <ul class="dropdown">
            <li><a href="driverReportList.php">Driver Reports</a></li>
            <li><a href="adminReportList.php">Admin Reports</a></li>
        </ul>
        </li>
        
        <li class="navbar-item"><a href="#" class="nav-link">Expenses Up-to-date</a>
            <ul class="dropdown">
                <li><a href="driverExpensesList.php">Driver Expenses</a></li>
                <li><a href="maintenanceExpensesList.php">Maintenance Expenses</a></li>
                <li><a href="missionExpensesList.php">Missions Expenses</a></li>
                <li><a href="vehicleExpensesList.php">Vehicle Expenses</a></li>
                <li><a href="penaltiesExpensestList.php">Penalties and Fines</a></li>
            </ul>
        </li>
        <li class="navbar-item"><a href="statisticPage.php" class="nav-link">Statistics</a></li>
        <li class="navbar-item"><a href="#" class="nav-link">Account</a></li>
    </ul>
</div>

<div class="container">
    <h1>List of Vehicles</h1><br><br>

    <!-- Search and Filter -->
    <div class="search-container">
        <label>Search Vehicle :</label>
        <select class="filter-select">
            <option value="all">All</option>
            <option value="assigned">Assigned</option>
            <option value="unassigned">Unassigned</option>
        </select>
        <button class="btn btn-primary">Search</button>
    </div><br><br>

    <!-- Insert New Vehicle Button -->
    <a href="vehicleForm.php" class="btn btn-primary">Add New Vehicle</a><br><br>
<?php
    // SQL query to retrieve vehicle data
$sql = "SELECT vehicle_id, vehicle_license_plate, vehicle_type, vehicle_status, vehicle_location FROM vehicle";
$result = mysqli_query($link, $sql);

// Check if any rows are returned
if ($result->num_rows > 0) {
    echo '<!-- Vehicle List Table -->';
    echo '<table>';
    echo '<thead>';
    echo '<tr>';
    echo '<th>License Plate Number</th>';
    echo '<th>Type</th>';
    echo '<th>Status</th>';
    echo '<th>Location</th>';
    echo '<th>Actions</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row["vehicle_license_plate"]) . '</td>';
        echo '<td>' . htmlspecialchars($row["vehicle_type"]) . '</td>';
        echo '<td>' . htmlspecialchars($row["vehicle_status"]) . '</td>';
        echo '<td>' . htmlspecialchars($row["vehicle_location"]) . '</td>';
        echo '<td class="action-buttons">';
        // View button opens vehicleformview.php with specific vehicle ID
        echo '<a class="btn btn-secondary" href="vehicleformview.php?id=' . $row["vehicle_id"] . '">View</a>';
        // Edit button opens vehicleformedit.php with specific vehicle ID for editing
        echo '<a class="btn btn-secondary" href="vehicleformedit.php?id=' . $row["vehicle_id"] . '">Edit</a>';
        // Delete button triggers JavaScript confirmation and performs deletion via vehicleformdelete.php
        echo '<button class="btn btn-secondary" onclick="deleteVehicle(' . $row["vehicle_id"] . ')">Delete</button>';
        echo '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
} else {
    echo "No vehicles found.";
}

// Close database connection
mysqli_close($link);
?>
</div>

</body>

<script>
    // JavaScript function to confirm and delete vehicle
    function deleteVehicle(vehicleId) {
        if (confirm("Are you sure you want to delete this vehicle?")) {
            // Redirect to deletevehicle.php with vehicle ID as parameter
            window.location.href = 'vehicleformdelete.php?id=' + vehicleId;
        }   
    }
</script>

</html>

