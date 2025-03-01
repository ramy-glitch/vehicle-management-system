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
    <title>List of Driver Reports</title>
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
    <h1>List of Driver Reports</h1><br><br>

    <!-- Search and Filter -->
    <div class="search-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" class="search-input" name="search" placeholder="Search reports...">
            <button type="submit" class="btn btn-primary" name="search_btn">Search</button>
            <button type="submit" class="btn btn-primary" name="reload_btn">Reload All</button>
        </form>
    </div><br><br><br><br>

    <!-- Driver Reports List Table -->
    <table>
        <thead>
            <tr>
                <th>Issue</th>
                <th>Driver Name</th>
                <th>Driver Phone</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php


            // Initial SQL query

            // Assuming $link is your database connection
            $sql = " SELECT d.driver_id, dr.report_id ,dr.report_issue, d.driver_license_number, d.driver_phone, d.driver_name,dr.report_date
            FROM driver_report dr
            INNER JOIN driver d ON dr.driver_id = d.driver_id";
                    
            // Implement the search feature and reload button
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $search = $_POST['search'];
                $sql .= " WHERE dr.report_issue LIKE '%$search%'
                        OR d.driver_license_number LIKE '%$search%'
                        OR d.driver_phone LIKE '%$search%'
                        OR d.driver_name LIKE '%$search%'";
            
            if (isset($_POST['reload_btn'])) {
                $sql = " SELECT d.driver_id ,dr.report_id,dr.report_issue, d.driver_license_number, d.driver_phone, d.driver_name ,dr.report_date
                        FROM driver_report dr
                        INNER JOIN driver d ON dr.driver_id = d.driver_id";
                }
            }
            
            $result = mysqli_query($link, $sql);
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row["report_issue"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["driver_name"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["driver_phone"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["report_date"]) . '</td>';
                    echo '<td>
                            <a class="btn btn-secondary" href="viewdriverreport.php?id=' . $row['report_id'] . '">View</a>&nbsp;&nbsp;
                        </td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="6">No driver reports found.</td></tr>';
            }
            ?>
            
        </tbody>
    </table>
</div>

</body>
</html>

<?php mysqli_close($link); ?>

