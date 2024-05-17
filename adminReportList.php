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
    <title>List of Admin Reports</title>
    <link rel="stylesheet" href="style.css">
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
    <h1>List of Admin Reports</h1>

    <!-- Search and Filter -->
    <div class="search-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" name="search" class="search-input" placeholder="Search reports...">
            <button type="submit" class="btn btn-primary" name="search_btn">Search</button>
            <button type="submit" class="btn btn-primary" name="reload_btn">Reload All</button>
        </form>
    </div>

    <!-- Write a new report Button -->
    <a href="adminReportsForm.php" class="btn btn-primary" style="width: fit-content;">Write a Report</a>

    <!-- Admin Reports List Table -->
    <table>
        <thead>
            <tr>
                <th>Issue</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Assuming $link is your database connection
            $sql = "SELECT report_id, report_issue, report_date FROM admin_report";

            // Implement the search feature and reload button
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $search = $_POST['search'];
                $sql .= " WHERE report_issue LIKE '%$search%'";

                if (isset($_POST['reload_btn'])) {
                    $sql = "SELECT report_id, report_issue, report_date FROM admin_report";
                }
            }

            $result = mysqli_query($link, $sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row["report_issue"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["report_date"]) . '</td>';
                    echo '<td>';
                    // View button 
                    echo '<a class="btn btn-secondary" href="adminReportsFormview.php?id=' . $row['report_id'] . '">View</a>&nbsp;&nbsp;';
                    // Edit button 
                    echo '<a class="btn btn-secondary" href="adminReportsFormedit.php?id=' . $row['report_id'] . '">Edit</a>&nbsp;&nbsp;';
                    // Delete button 
                    echo '<a class="btn btn-secondary" href="adminReportsFormdelete.php?id=' . $row['report_id'] . '">Delete</a>&nbsp;&nbsp;';
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="3">No admin reports found.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php mysqli_close($link); ?>
