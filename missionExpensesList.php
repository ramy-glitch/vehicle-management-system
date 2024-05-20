<?php

session_start();
if (!isset($_SESSION['adminid'])) {

    header("Location: loginpage.php");
    exit;
}

if (file_exists('dblink.php')) {
    require 'dblink.php';
} else {
    die("File not found");
}

$sql = "SELECT m.mission_id, m.end_location, m.start_date_time, m.end_date_time, m.cost
        FROM mission m";

// Implement the search feature and reload button
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search = $_POST['search'];
    $sql .= " WHERE m.end_location LIKE '%$search%'
            OR CONCAT(m.start_date_time, ' to ', m.end_date_time) LIKE '%$search%'";

    if (isset($_POST['reload_btn'])) {
        $sql = "SELECT m.mission_id, m.end_location, m.start_date_time, m.end_date_time, m.cost
        FROM mission m";
    }
}

$result = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Mission Expenses</title>
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
    <h1>List of Mission Expenses</h1>

    <!-- Search and Filter -->
    <div class="search-container">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="text" class="search-input" placeholder="Search expenses..." name="search">
            <button type="submit" class="btn btn-primary" name="search_btn">Search</button>
            <button type="submit" class="btn btn-primary" name="reload_btn">Reload All</button>
        </form>
    </div>

    <!-- Mission Expenses List Table -->
    <table>
        <thead>
            <tr>
                <th>Mission destination</th>
                <th>Period</th>
                <th>Date of payment</th>
                <th>Amount</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row["end_location"]) . '</td>'; 
                    echo '<td>' . htmlspecialchars($row["start_date_time"]) .' to ' .htmlspecialchars($row["end_date_time"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["start_date_time"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["cost"]) . '</td>';
                    echo '<td>
                            <a class="btn btn-secondary" href="missionformview.php?id=' . $row["mission_id"] . '">View</a>&nbsp;&nbsp;
                            <a class="btn btn-secondary" href="missionformedit.php?id=' . $row["mission_id"] . '">Edit</a>&nbsp;&nbsp;
                        </td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="5">No mission expenses found.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php mysqli_close($link); ?>