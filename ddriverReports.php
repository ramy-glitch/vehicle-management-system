<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Driver Reports</title>
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
    <h1>List of Driver Reports</h1>

    <!-- Search and Filter -->
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Search reports...">
        <select class="filter-select">
            <option value="all">All</option>
            <option value="pending">Pending</option>
            <option value="resolved">Resolved</option>
        </select>
        <button class="btn btn-primary">Search</button>
    </div>

    <!-- Write a new report Button -->
    <a href="driverReportForm.html" class="btn btn-primary" style="width: fit-content;">Write a Report</a>

    <!-- Driver Reports List Table -->
    <table>
        <thead>
            <tr>
                <th>Issue</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Vehicle Maintenance Needed</td>
                <td>2024-04-16</td>
                <td>
                    <button class="btn btn-secondary">View</button>
                    <button class="btn btn-secondary">Response</button>
                    <button class="btn btn-secondary">Delete</button>
                </td>
            </tr>
            <tr>
                <td>Driving Route Issue</td>
                <td>2024-04-17</td>
                <td>
                    <button class="btn btn-secondary">View</button>
                    <button class="btn btn-secondary">Response</button>
                    <button class="btn btn-secondary">Delete</button>
                </td>
            </tr>
            <!-- Add more rows as needed -->
        </tbody>
    </table>
</div>

</body>
</html>
