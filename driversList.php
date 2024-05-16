<?php
if (file_exists('dblink.php')) {
    require 'dblink.php';
} else {
    die("File not found");
}

// Query to fetch driver information
$sql = "SELECT d.driver_id,
d.driver_name,
d.driver_phone,
d.driver_status,
v.vehicle_license_plate
FROM 
driver d
LEFT JOIN 
mission m ON d.driver_id = m.driver_id
LEFT JOIN 
vehicle v ON m.vehicle_id = v.vehicle_id
";

// Search functionality
$search = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["search_button"])) {
        $search = $_POST["search"];
        $sql .= " WHERE driver_name LIKE '%$search%' OR driver_phone LIKE '%$search%' OR driver_status LIKE '$search%' OR vehicle_license_plate LIKE '%$search%'";
    }
    if (isset($_POST["reload_button"])) {
        $search = '';
        $sql = "SELECT d.driver_id,
                d.driver_name,
                d.driver_phone,
                d.driver_status,
                v.vehicle_license_plate
                FROM 
                driver d
                LEFT JOIN 
                mission m ON d.driver_id = m.driver_id
                LEFT JOIN 
                vehicle v ON m.vehicle_id = v.vehicle_id
                ";
    }
}


$result = mysqli_query($link, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Drivers</title>
    <link rel="stylesheet" href="style.css"/>
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
        <li class="navbar-item"><a href="adminAccount.php" class="nav-link">Account</a></li>
    </ul>
</div>

<div class="container">
    <h1>List of Drivers</h1><br><br>


    <!-- Search and Filter -->
    <div class="search-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" name="search" placeholder="Search Driver.." value="<?php echo htmlspecialchars($search); ?>">
            <button class="btn btn-primary" name="search_button">Search</button>
            <button class="btn btn-primary" name="reload_button">Reload All Drivers</button>
        </form>
    </div><br><br>

    <!-- Insert New Driver Button -->
    <a href="driverForm.php" class="btn btn-primary">Add New Driver</a><br><br>

    <!-- Driver List Table -->
    <table>
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Phone Number</th>
                <th>Status</th>
                <th>License Plate Number</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Loop through the query result and display each row in the table
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['driver_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['driver_phone']) . "</td>";
                echo "<td>" . htmlspecialchars($row['driver_status']) . "</td>";
                echo "<td>" . htmlspecialchars($row['vehicle_license_plate']) . "</td>";
                echo "<td>";
                echo '<a class="btn btn-secondary" href="driverformview.php?id=' . $row["driver_id"] . '">View</a>';
                // Edit button opens driverformedit.php with specific driver ID for editing
                echo '<a class="btn btn-secondary" href="driverformedit.php?id=' . $row["driver_id"] . '">Edit</a>';
                // Delete button 
                echo '<a class="btn btn-secondary" href="driverformdelete.php?id=' . $row["driver_id"] . '">Delete</a>';
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php
// Close the database connection
mysqli_close($link);
?>
