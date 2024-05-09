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
    <title>List of Driver Expenses</title>
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
    <h1>List of Driver Expenses</h1>

    <!-- Search and Filter -->
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Search expenses...">
        <select class="filter-select">
            <option value="all">All</option>
            <option value="salary">Salary</option>
            <option value="benefits">Benefits</option>
            <option value="training">Training Costs</option>
        </select>
        <button class="btn btn-primary">Search</button>
    </div>

    <!-- Driver Expenses List Table -->
    <table>
        <thead>
            <tr>
                <th>Driver's name:</th>
                <th>Driver'phone number:</th>
                <th>Date of next payment:</th>
                <th>Amount:</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Salary</td>
                <td>123</td>
                <td>2024-04-15</td>
                <td>$2000</td>
                <td>
                    <button class="btn btn-secondary">View</button>
                    <button class="btn btn-secondary"><a href="vehicleform.php">Edit</a></button>
                </td>
            </tr>
            <tr>
                <td>Training Costs</td>
                <td>456</td>
                <td>2024-04-16</td>
                <td>$500</td>
                <td>
                    <button class="btn btn-secondary">View</button>
                    <button class="btn btn-secondary"><a href="vehicleform.php">Edit</a></button>
                </td>
            </tr>
            <!-- Add more rows as needed -->
        </tbody>
    </table>
</div>

</body>
</html>
