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
    <title>List of Missions</title>
    <link rel="stylesheet" href="style.css">
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
                <li><a href="maintenanceExpensesList.php">Maintenance Expenses</a></li>
                <li><a href="missionExpensesList.php">Missions Expenses</a></li>
                <li><a href="vehicleExpensesList.php">Vehicle Expenses</a></li>
                <li><a href="penaltiesExpensestList.php">Penalties and Fines</a></li>
            </ul>
        </li>
        <li class="navbar-item"><a href="statisticPage.php" class="nav-link">Statistics</a></li>
        <li class="navbar-item"><a href="adminAccount.php" class="nav-link">Account</a></li>
    </ul>
</div>

<div class="container">
    <h1>List of Missions</h1><br><br>

    <!-- Search and Filter -->
    <div class="search-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" name="search" placeholder="Search Mission..">
            <button class="btn btn-primary" name="search_button">Search</button> 
            <button class="btn btn-primary" name="reload_button">Reload All Missions</button>
        </form>
    </div><br><br>

    <!-- Insert New Mission Button -->
    <a href="missionForm.php" class="btn btn-primary">Add New Mission</a><br><br>

    <?php
    // SQL query to retrieve mission data
    $sql = "SELECT m.mission_id, d.driver_name, d.driver_phone, v.vehicle_license_plate, m.end_date_time, m.end_location, m.mission_status
            FROM mission m
            INNER JOIN driver d ON m.driver_id = d.driver_id
            INNER JOIN vehicle v ON m.vehicle_id = v.vehicle_id";

    // Implement the search feature
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $search = $_POST['search'];
        $sql .= " WHERE d.driver_name LIKE '%$search%' OR d.driver_phone LIKE '%$search%' OR v.vehicle_license_plate LIKE '%$search%' OR m.end_location LIKE '%$search%' OR m.mission_status LIKE '%$search%'";
    } else {
        $search = "";
    }

    if (isset($_POST['reload_button'])) {
        $sql = "SELECT m.mission_id, d.driver_name, d.driver_phone, v.vehicle_license_plate, m.end_date_time, m.end_location, m.mission_status
                FROM mission m
                INNER JOIN driver d ON m.driver_id = d.driver_id
                INNER JOIN vehicle v ON m.vehicle_id = v.vehicle_id";
    }

    $result = mysqli_query($link, $sql);

    if ($result->num_rows > 0) {
        echo '<table>';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Driver Name</th>';
        echo '<th>Driver Phone</th>';
        echo '<th>Vehicle Plate</th>';
        echo '<th>End Date Time</th>';
        echo '<th>Destination</th>';
        echo '<th>Status</th>';
        echo '<th>Actions</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row["driver_name"]) . '</td>';
            echo '<td>' . htmlspecialchars($row["driver_phone"]) . '</td>';
            echo '<td>' . htmlspecialchars($row["vehicle_license_plate"]) . '</td>';
            echo '<td>' . htmlspecialchars($row["end_date_time"]) . '</td>';
            echo '<td>' . htmlspecialchars($row["end_location"]) . '</td>';
            echo '<td>' . htmlspecialchars($row["mission_status"]) . '</td>';
            echo '<td>';
        // View button opens missionformview.php with specific mission ID
        echo '<a class="btn btn-secondary" href="missionformview.php?id=' . $row["mission_id"] . '">View</a>&nbsp;&nbsp;';
        // Edit button opens missionformedit.php with specific vehicle ID for editing
        echo '<a class="btn btn-secondary" href="missionformedit.php?id=' . $row["mission_id"] . '">Edit</a>&nbsp;&nbsp;';
        // Delete button 
        echo '<a class="btn btn-secondary" href="missionformdelete.php?id=' . $row["mission_id"] . '">Delete</a>&nbsp;&nbsp;';
            echo '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo "No missions found.";
    }
    ?>
</div>


</body>
</html>
<?php mysqli_close($link); ?>
