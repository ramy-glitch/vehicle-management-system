<?php
if (file_exists('dblink.php')) {
    require 'dblink.php';
} else {
    die("File not found");
}

$sql = "SELECT v.vehicle_license_plate, v.vehicle_model, ve.expense_type, ve.expense_date, ve.expense_cost
        FROM vehicle_expense ve
        INNER JOIN vehicle v ON ve.vehicle_id = v.vehicle_id";

// Implement the search feature and reload button
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search = $_POST['search'];
    $sql .= " WHERE v.vehicle_license_plate LIKE '%$search%'
            OR v.vehicle_model LIKE '%$search%'
            OR ve.expense_type LIKE '%$search%'
            OR ve.expense_date LIKE '%$search%'
            OR ve.expense_cost LIKE '$search%'";

    if (isset($_POST['reload_btn'])) {
        $sql = "SELECT v.vehicle_license_plate, v.vehicle_model, ve.expense_type, ve.expense_date, ve.expense_cost,ve.expense_id
                FROM vehicle_expense ve
                INNER JOIN vehicle v ON ve.vehicle_id = v.vehicle_id";
    }
}

$result = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Vehicle Expenses</title>
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
    <h1>List of Vehicle Expenses</h1>

    <!-- Search and Filter -->
    <div class="search-container">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" class="search-input" placeholder="Search expenses..." name="search">
            <button type="submit" class="btn btn-primary" name="search_btn">Search</button>
            <button type="submit" class="btn btn-primary" name="reload_btn">Reload All</button>
        </form>
    </div>

    <a href="vehicleExpensesForm.php" class="btn btn-primary">Add New Expense</a>

    <!-- Vehicle Expenses List Table -->
    <table>
        <thead>
            <tr>
                <th>Vehicle license plate number</th>
                <th>Vehicle model</th>
                <th>Type of expense</th>
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
                    echo '<td>' . htmlspecialchars($row["vehicle_model"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["expense_type"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["expense_date"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["expense_cost"]) . '</td>';
                    echo '<td>
                    <a class="btn btn-secondary" href="vehicleExpensesFormview.php?id=' . $row["expense_id"] . '">View</a>&nbsp;&nbsp;
                    <a class="btn btn-secondary" href="vehicleExpensesFormedit.php?id=' . $row["expense_id"] . '">Edit</a>&nbsp;&nbsp;
                    <a class="btn btn-secondary" href="vehicleExpensesFormdelete.php?id=' . $row["expense_id"] . '">Delete</a>&nbsp;&nbsp;
                        </td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="6">No vehicle expenses found.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php mysqli_close($link); ?>