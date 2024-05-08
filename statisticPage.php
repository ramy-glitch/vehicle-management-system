<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistics</title>
    <link  rel="stylesheet" href="statistic.css"/>
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


<h1>Statistics</h1>

<!-- Vehicle Statistics -->
<h2>Vehicle Statistics</h2>
<table>
    <tr>
        <th>Total Number of Vehicles</th>
        <td>100</td>
    </tr>
    <tr>
        <th>Vehicle Utilization</th>
        <td>75%</td>
    </tr>
    <tr>
        <th>Fuel Efficiency</th>
        <td>20 miles per gallon</td>
    </tr>
    <tr>
        <th>Maintenance Costs</th>
        <td>Total: $50,000 | Average per Vehicle: $500</td>
    </tr>
</table>

<!-- Driver Statistics -->
<h2>Driver Statistics</h2>
<table>
    <tr>
        <th>Total Number of Drivers</th>
        <td>50</td>
    </tr>
    <tr>
        <th>Driver Performance</th>
        <td>Completed Missions: 500 | Adherence to Schedules: 90%</td>
    </tr>
    <tr>
        <th>Driver Safety</th>
        <td>Traffic Violations: 20 | Accidents: 5</td>
    </tr>
</table>

<!-- Mission Statistics -->
<h2>Mission Statistics</h2>
<table>
    <tr>
        <th>Total Number of Missions</th>
        <td>200</td>
    </tr>
    <tr>
        <th>Mission Success Rate</th>
        <td>85%</td>
    </tr>
    <tr>
        <th>Average Mission Duration</th>
        <td>2 hours</td>
    </tr>
</table>

<!-- Expense Statistics -->
<h2>Expense Statistics</h2>
<table>
    <tr>
        <th>Total Expenses</th>
        <td>$150,000</td>
    </tr>
    <tr>
        <th>Cost per Mile</th>
        <td>$0.50 per mile</td>
    </tr>
    <tr>
        <th>Cost per Mission</th>
        <td>$750 per mission</td>
    </tr>
</table>

<!-- Maintenance Statistics -->
<h2>Maintenance Statistics</h2>
<table>
    <tr>
        <th>Total Maintenance Costs</th>
        <td>$50,000</td>
    </tr>
    <tr>
        <th>Average Maintenance Cost per Vehicle</th>
        <td>$500</td>
    </tr>
    <tr>
        <th>Maintenance Frequency</th>
        <td>Every 3 months</td>
    </tr>
</table>

</body>
</html>
