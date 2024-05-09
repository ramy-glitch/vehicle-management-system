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
    <title>List of Maintenance Expenses</title>
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
    <h1>List of Maintenance Expenses</h1>

    <!-- Search and Filter -->
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Search expenses...">
        <select class="filter-select">
            <option value="all">All</option>
            <option value="oil_change">Oil Change</option>
            <option value="tire_rotation">Tire Rotation</option>
            <option value="brake_inspection">Brake Inspection</option>
            <option value="repairs">Repairs</option>
        </select>
        <button class="btn btn-primary">Search</button>
    </div>


    <!-- Maintenance Expenses List Table -->
    <table>
        <thead>
            <tr>
                <th>Workshop name:</th>
                <th>Workshop Phone:</th>
                <th>Type of maintenance:</th>
                <th>Date:</th>
                <th>Amount:</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Auto Shop</td>
                <td>Oil Change</td>
                <td>123</td>
                <td>2024-04-15</td>
                <td>$100</td>
                <td>
                    <button class="btn btn-secondary">View</a></button>
                    <button class="btn btn-secondary">Edit</a></button>
                </td>
            </tr>
            <tr>
                <td>Auto Shop</td>
                <td>Tire Rotation</td>
                <td>456</td>
                <td>2024-04-16</td>
                <td>$50</td>
                <td>
                    <button class="btn btn-secondary">View</a></button>
                    <button class="btn btn-secondary">Edit</a></button>
                </td>
            </tr>
            <!-- Add more rows as needed -->
        </tbody>
    </table>
</div>

</body>
</html>
