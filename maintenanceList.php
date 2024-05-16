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
    <title>List of Maintenance</title>
    <link rel="stylesheet" href="style.css"/>
</head>
<body>

<!-- Navbar -->
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
        <li class="navbar-item"><a href="adminAccount.php" class="nav-link">Account</a></li>
    </ul>
</div>

<!-- Main Content Container -->
<div class="container">
    <h1>List of Maintenance</h1>

    <!-- Search and Filter -->
    <div class="search-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" name="search" class="search-input" placeholder="Search maintenance...">
            <button class="btn btn-primary" name="search_btn" >Search</button>
            <button class="btn btn-primary" name="reload_btn">Reload All</button>
        </form>
    </div>

    <!-- Insert New Maintenance Button -->
    <a href="maintenanceForm.php" class="btn btn-primary">Schedule New Maintenance</a>

    <!-- Maintenance List Table -->
    <table>
        <thead>
            <tr>
                <th>Vehicle Plate Number</th>
                <th>Status</th>
                <th>Workshop Name</th>
                <th>Workshop Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Assuming $link is your database connection
            $sql = "SELECT vehicle_license_plate, maintenance_status, workshop_name, workshop_phone
                    FROM vehicle_maintenance
                    INNER JOIN vehicle ON vehicle_maintenance.vehicle_id = vehicle.vehicle_id";

            // Apply search and filter logic
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $search = $_POST['search'];
                
                // Modify SQL query based on search and filter parameters
                if (!empty($search)) {
                    $sql .= " WHERE vehicle_license_plate LIKE '%$search%' OR workshop_name LIKE '%$search%' or workshop_phone LIKE '%$search%'";
                }

                if (isset($_POST['reload_btn'])){
                    $sql = "SELECT vehicle_license_plate, maintenance_status, workshop_name, workshop_phone
                    FROM vehicle_maintenance
                    INNER JOIN vehicle ON vehicle_maintenance.vehicle_id = vehicle.vehicle_id";
                } 

            }

            $result = mysqli_query($link, $sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row["vehicle_license_plate"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["maintenance_status"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["workshop_name"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["workshop_phone"]) . '</td>';
                    echo '<td>';
                    echo '<button class="btn btn-secondary">View</button>';
                    echo '<button class="btn btn-secondary">Edit</button>';
                    echo '<button class="btn btn-secondary">Delete</button>';
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="5">No maintenance records found.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
<?php mysqli_close($link); ?>
