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
    <title>List of Missions</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <div class="navbar-brand"><a href="driverHomePage.php">Driver Dashboard</a></div>
    <ul class="navbar-menu">
        <li class="navbar-item"><a href="driverHomePage.php" class="nav-link">Dashboard</a></li>
        <li class="navbar-item"><a href="dmissionsList.php" class="nav-link">Missions</a></li>
        <li class="navbar-item"><a href="dvehicleDetails.php" class="nav-link">Vehicle</a></li>
        <li class="navbar-item"><a href="ddriverReports.php" class="nav-link">Reports</a></li>
        <li class="navbar-item"><a href="dpenaltiesList.php" class="nav-link">Penalties & Fines</a></li>
        <li class="navbar-item"><a href="#" class="nav-link">Notifications</a></li>
        <li class="navbar-item"><a href="driverAccount.php" class="nav-link">Account</a></li>
    </ul>
</div>

<!-- Main content container -->
<div class="container">
    <h1>List of Missions</h1>

    <!-- Search and Filter -->
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Search missions...">
        <select class="filter-select">
            <option value="all">All</option>
            <option value="in_progress">In Progress</option>
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
        </select>
        <button class="btn btn-primary">Search</button>
    </div>


    <!-- Mission List Table -->
    <table>
        <thead>
            <tr>
                <th>Mission ID</th>
                <th>Status</th>
                <th>Destination</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>In Progress</td>
                <td>Destination A</td>
                <td>
                    <button class="btn btn-secondary" ><a href="dmissionDetails.php">View</a></button>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td>Completed</td>
                <td>Destination B</td>
                <td>
                    <button class="btn btn-secondary"><a href="dmissionDetails.php">View</a></button>
                </td>
            </tr>
            <!-- Add more rows for additional missions -->
        </tbody>
    </table>
</div>

</body>
</html>
