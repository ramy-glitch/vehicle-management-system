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
    <title>Penalties & Fines</title>
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
    <h1>Penalties & Fines</h1>

    <!-- Search and Filter -->
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Search expenses...">
        <select class="filter-select">
            <option value="all">All</option>
            <option value="parking_tickets">Parking Tickets</option>
            <option value="speeding_tickets">Speeding Tickets</option>
            <option value="other_violations">Other Violations</option>
            <option value="late_fees">Late Fees</option>
        </select>
        <button class="btn btn-primary">Search</button>
    </div>

    <!-- Penalties List -->
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Description</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>2024-04-15</td>
                <td>Speeding Ticket</td>
                <td>$100</td>
            </tr>
            <tr>
                <td>2024-03-20</td>
                <td>Parking Violation</td>
                <td>$50</td>
            </tr>
            <!-- Add more rows for additional penalties -->
        </tbody>
    </table>
</div>

</body>
</html>
