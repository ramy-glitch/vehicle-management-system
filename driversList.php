<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Drivers</title>
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
    <h1>List of Drivers</h1>

    <!-- Search and Filter -->
    <div class="search-container">
        <input type="text" class="search-input" placeholder="Search drivers...">
        <select class="filter-select">
            <option value="all">All</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
        <button class="btn btn-primary">Search</button>
    </div>

    <!-- Insert New Driver Button -->
    <a href="driverForm.html" class="btn btn-primary">Add New Driver</a>

    <!-- Driver List Table -->
    <table>
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Phone Number</th>
                <th>Status</th>
                <th>License Plate Number</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>John Doe</td>
                <td>123-456-7890</td>
                <td>Active</td>
                <td>ABC123</td>
                <td>
                    <button class="btn btn-secondary">View</a></button>
                    <button class="btn btn-secondary">Edit</button>
                    <button class="btn btn-secondary">Delete</a></button>
                </td>
            </tr>
            <tr>
                <td>Jane Smith</td>
                <td>987-654-3210</td>
                <td>Inactive</td>
                <td>XYZ789</td>
                <td>
                    <button class="btn btn-secondary">View</a></button>
                    <button class="btn btn-secondary">Edit</a></button>
                    <button class="btn btn-secondary">Delete</a></button>
                </td>
            </tr>
            <!-- Add more rows as needed -->
        </tbody>
    </table>
</div>

</body>
</html>
