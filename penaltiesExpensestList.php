<?php
if (file_exists('dblink.php')) {
    require 'dblink.php';
} else {
    die("File not found");
}

$sql = "SELECT p.vehicle_license_plate, pe.penality_type, d.driver_license_number, pe.penality_date, pe.penality_cost
        FROM penality_expense pe
        INNER JOIN driver d ON pe.driver_id = d.driver_id
        LEFT JOIN vehicle v ON d.vehicle_id = v.vehicle_id";

// Implement the search feature and reload button
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search = $_POST['search'];
    $sql .= " WHERE p.vehicle_license_plate LIKE '%$search%'
            OR pe.penality_type LIKE '%$search%'
            OR d.driver_license_number LIKE '%$search%'
            OR pe.penality_date LIKE '%$search%'
            OR pe.penality_cost LIKE '%$search%'";

    if (isset($_POST['reload_btn'])) {
        $sql = "SELECT p.vehicle_license_plate, pe.penality_type, d.driver_license_number, pe.penality_date, pe.penality_cost
                FROM penality_expense pe
                INNER JOIN driver d ON pe.driver_id = d.driver_id
                LEFT JOIN vehicle v ON d.vehicle_id = v.vehicle_id";
    }
}

$result = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Penalties and Fines Expenses</title>
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
                <li><a href="driverExpensesList.php">Driver Expenses</a></li>
                <li><a href="maintenanceExpensesList.php">Maintenance Expenses</a></li>
                <li><a href="missionExpensesList.php">Missions Expenses</a></li>
                <li><a href="vehicleExpensesList.php">Vehicle Expenses</a></li>
                <li><a href="penaltiesExpensesList.php">Penalties and Fines</a></li>
            </ul>
        </li>
        <li class="navbar-item"><a href="statisticPage.php" class="nav-link">Statistics</a></li>
        <li class="navbar-item"><a href="#" class="nav-link">Account</a></li>
    </ul>
</div>

<div class="container">
    <h1>List of Penalties and Fines Expenses</h1>

    <!-- Search and Filter -->
    <div class="search-container">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" class="search-input" placeholder="Search expenses..." name="search">
            <button type="submit" class="btn btn-primary" name="search_btn">Search</button>
            <button type="submit" class="btn btn-primary" name="reload_btn">Reload All</button>
        </form>
    </div>

    <a href="penaltiesExpensesForm.php" class="btn btn-primary">Add New Expense</a>

    <!-- Penalties and Fines Expenses List Table -->
    <table>
        <thead>
            <tr>
                <th>License Plate number</th>
                <th>Type</th>
                <th>Driver Licence number</th>
                <th>Date</th>
                <th>Amount</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row["vehicle_license_plate"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["penality_type"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["driver_license_number"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["penality_date"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["penality_cost"]) . '</td>';
                    echo '<td>
                            <button class="btn btn-secondary">View</button>
                            <button class="btn btn-secondary">Edit</button>
                            <button class="btn btn-secondary">Delete</button>
                        </td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="6">No penalties and fines expenses found.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
<?php mysqli_close($link); ?>