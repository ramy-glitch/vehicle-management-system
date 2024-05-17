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
    <title>Admin Dashboard</title>
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

    <div class="section">
        <h1>Welcome, Admin!</h1>
        <p>Total Vehicles: 100 | Total Drivers: 50 | Ongoing Missions: 10</p>
    </div>

    <div class="section">
        <h1>Quick Access</h1>
        <div>
            <button class="action-button" onclick="window.location.href='vehicleForm.php'">Add New Vehicle</button>
            <button class="action-button" onclick="window.location.href='driverForm.php'">Add New Driver</button>
            <button class="action-button" onclick="window.location.href='missionForm.php'">Create Mission</button>
            <button class="action-button secondary" onclick="window.location.href='maintenanceList.php'">Manage Maintenance</button>
            <button class="action-button secondary" onclick="window.location.href='adminAccount.php'">Configure Settings</button>
        </div>
    </div>

    <div class="section">
        <h1>Recent Activities and Notifications</h1>
        <div>
            <h2>Recent Activity Feed:</h2>
            <p>Driver John Doe completed Mission XYZ.</p>
            <p>Vehicle ABC underwent maintenance.</p>
        </div>
        <div>
            <h2>Notifications:</h2>
            <p>New mission assignment for Driver Jane Doe.</p>
        </div>
    </div>

    <div class="section">
        <h1>Visual Data Representation</h1>
        <p>Placeholder for Vehicle Utilization Graph</p>
        <p>Placeholder for Driver Performance Metrics</p>
    </div>

    <div class="section">
        <h1>Quick Search and Filtering</h1>
        <div>
            <input type="text" class="search-input" placeholder="Search Vehicles...">
            <select class="filter-select">
                <option value="all">All</option>
                <option value="in-service">In Service</option>
                <option value="maintenance">Maintenance</option>
            </select>
        </div>
    </div>

    <div class="section">
        <h1>Help and Support</h1>
        <div>
            <button class="action-button">FAQs</button>
            <button class="action-button">Contact Support</button>
            <button class="action-button">User Guide</button>
        </div>
    </div>



</div>

</body>
</html>
