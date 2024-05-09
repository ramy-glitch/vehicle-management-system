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
    <title>Driver Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <div class="navbar-brand"><a href="driverHomePage.php">Driver Dashboard</a></div>
    <ul class="navbar-menu">
        <!-- Navbar items -->
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

    <!-- Section: Welcome Message -->
    <div class="section">
        <h1>Welcome, Driver!</h1>
        <p>You are logged in as John Doe.</p>
    </div>

    <!-- Section: Current Mission -->
    <div class="section">
        <h1>My Current Mission</h1>
        <div>
            <p>Mission Name: Delivery Route A</p>
            <p>Status: In Progress</p>
            <p>Assigned Vehicle: ABC123</p>
        </div>
    </div>

    <!-- Section: My Vehicle Details -->
    <div class="section">
        <h1>My Vehicle Details</h1>
        <div>
            <p>Vehicle: ABC123</p>
            <p>Model: Sedan</p>
            <p>Year: 2022</p>
            <p>License Plate: XYZ456</p>
            <p>Registration Expiry: 2024-12-31</p>
        </div>
    </div>

    <!-- Section: My Reports -->
    <div class="section">
        <h1>My Reports</h1>
        <div>
            <p>No reports available.</p>
        </div>
    </div>

    <!-- Section: Penalties & Fines -->
    <div class="section">
        <h1>Penalties & Fines</h1>
        <div>
            <p>No penalties or fines.</p>
        </div>
    </div>

    <!-- Section: Notifications -->
    <div class="section">
        <h1>Notifications</h1>
        <div>
            <p>No new notifications.</p>
        </div>
    </div>

    <!-- Section: Quick Actions -->
    <div class="section">
        <h1>Quick Actions</h1>
        <div>
            <button class="action-button" onclick="window.location.href='reportIssue.html'">Report Issue</button>
            <button class="action-button" onclick="window.location.href='maintenanceRequest.html'">Request Maintenance</button>
            <button class="action-button secondary" onclick="window.location.href='driverAccount.html'">Edit Profile</button>
        </div>
    </div>

    <!-- Section: Help and Support -->
    <div class="section">
        <h1>Help and Support</h1>
        <div>
            <button class="action-button">FAQs</button>
            <button class="action-button">Contact Support</button>
        </div>
    </div>

</div>

</body>
</html>
