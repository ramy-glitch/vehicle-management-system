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

        <?php 
            $sql = "SELECT COUNT(vehicle_id) AS totalVehicles FROM vehicle";
            $result = mysqli_query($link, $sql);
            $row = mysqli_fetch_assoc($result);
            $totalVehicles = $row['totalVehicles'];

            $sql = "SELECT COUNT(driver_id) AS totalDrivers FROM driver";
            $result = mysqli_query($link, $sql);
            $row = mysqli_fetch_assoc($result);
            $totalDrivers = $row['totalDrivers'];

            $sql = "SELECT COUNT(mission_id) AS totalMissions FROM mission WHERE mission_status = 'in_progress' ";
            $result = mysqli_query($link, $sql);
            $row = mysqli_fetch_assoc($result);
            $totalMissions = $row['totalMissions'];

            $sql = "SELECT COUNT(mission_id) AS totalScheduledMissions FROM mission WHERE mission_status = 'scheduled' ";
            $result = mysqli_query($link, $sql);
            $row = mysqli_fetch_assoc($result);
            $totalScheduledMissions = $row['totalScheduledMissions'];
        ?>

        <p>Total Vehicles: <?php echo $totalVehicles; ?> | Total Drivers: <?php echo $totalDrivers; ?>  | Ongoing Missions: <?php echo $totalMissions; ?>  | scheduled Missions: <?php echo $totalScheduledMissions; ?> </p>
    </div><br><br><br>

    <div class="section">
        <h2 style="color: blue;">Quick Access</h2>
        <div>
            <button class="action-button" onclick="window.location.href='vehicleForm.php'">Add New Vehicle</button>
            <button class="action-button" onclick="window.location.href='driverForm.php'">Add New Driver</button>
            <button class="action-button" onclick="window.location.href='missionForm.php'">Create Mission</button>
            <button class="action-button secondary" onclick="window.location.href='maintenanceList.php'">Manage Maintenance</button>
            <button class="action-button secondary" onclick="window.location.href='adminAccount.php'">Configure Settings</button>
        </div>
    </div><br><br><br>

    <div class="section">
        <h2 style="color: blue;"> Today's Scheduled Missions:</h2>
        <div>
            <table>
                <tr>
                    <th>Mission purpose</th>
                    <th>Driver</th>
                    <th>Vehicle</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Destination</th>
                    <th>Status</th>
                </tr>
                <?php

                    function truncateString($str, $maxLength, $ellipsis = '...') {
                        if (mb_strlen($str) <= $maxLength) {
                            return $str; // No need to truncate
                        } else {
                            // Truncate and add ellipsis
                            return mb_substr($str, 0, $maxLength) . $ellipsis;
                        }
                    }
                    
                    $sql = "SELECT mission_id, purpose, driver_name, vehicle_license_plate, start_date_time, end_date_time, end_location, mission_status FROM mission JOIN driver ON mission.driver_id = driver.driver_id JOIN vehicle ON mission.vehicle_id = vehicle.vehicle_id WHERE mission_status = 'scheduled' AND DATE(start_date_time) = CURDATE()";
                    $result = mysqli_query($link, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            
                            $purpose = truncateString($row['purpose'], 30) ;

                            echo "<td>" . $purpose . "</td>";
                            echo "<td>" . $row['driver_name'] . "</td>";
                            echo "<td>" . $row['vehicle_license_plate'] . "</td>";
                            echo "<td>" . $row['start_date_time'] . "</td>";
                            echo "<td>" . $row['end_date_time'] . "</td>";
                            echo "<td>" . $row['end_location'] . "</td>";
                            echo "<td>" . $row['mission_status'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No scheduled missions for today.</td></tr>";
                    }
                ?>
            </table>
        </div>

    </div><br><br><br>

    <div class="section">
        <h2 style="color: blue;">Recent Missions:</h2>
        <div>
            <table>
                <tr>
                    <th>Mission purpose</th>
                    <th>Driver</th>
                    <th>Vehicle</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Destination</th>
                    <th>Status</th>
                </tr>
                <?php
                    $sql = "SELECT mission_id, purpose, driver_name, vehicle_license_plate, start_date_time, end_date_time, end_location, mission_status FROM mission JOIN driver ON mission.driver_id = driver.driver_id JOIN vehicle ON mission.vehicle_id = vehicle.vehicle_id WHERE mission_status = 'in_progress' ORDER BY start_date_time DESC LIMIT 5";
                    $result = mysqli_query($link, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            $purpose = truncateString($row['purpose'], 30) ;
                            echo "<td>" . $purpose . "</td>";
                            echo "<td>" . $row['driver_name'] . "</td>";
                            echo "<td>" . $row['vehicle_license_plate'] . "</td>";
                            echo "<td>" . $row['start_date_time'] . "</td>";
                            echo "<td>" . $row['end_date_time'] . "</td>";
                            echo "<td>" . $row['end_location'] . "</td>";
                            echo "<td>" . $row['mission_status'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>No recent missions.</td></tr>";
                    }
                ?>
            </table>
        </div>

    </div><br><br><br>

    <div class="section">
        <h2 style="color: blue;">Today's scheduled Maintenances:</h2>
        <div>
            <table>
                <tr>
                    <th>Maintenance Type</th>
                    <th>Vehicle</th>
                    <th>Start Date</th>
                    <th>Cost</th>
                    <th>Status</th>
                </tr>
                <?php
                // The CURDATE() function in MySQL returns the current date in the format ‘YYYY-MM-DD’.

                    $sql = "SELECT maintenance_type, vehicle_license_plate, maintenance_date, cost, maintenance_status FROM vehicle_maintenance JOIN vehicle ON vehicle_maintenance.vehicle_id = vehicle.vehicle_id where (maintenance_status = 'scheduled' AND maintenance_date = CURDATE())";
                    $result = mysqli_query($link, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            $maintenance_type = truncateString($row['maintenance_type'], 20) ;
                            echo "<td>" . $maintenance_type . "</td>";
                            echo "<td>" . $row['vehicle_license_plate'] . "</td>";
                            echo "<td>" . $row['maintenance_date'] . "</td>";
                            echo "<td>" . $row['cost'] . "</td>";
                            echo "<td>" . $row['maintenance_status'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No recent maintenance.</td></tr>";
                    }
                ?>
            </table>
        </div>

    </div><br><br><br>


    <div class="section">
        <h2 style="color: blue;">Today's Recent Penalties:</h2>
        <div>
            <table>
                <tr>
                    <th>Driver</th>
                    <th>Driver License</th>
                    <th>Penalty Date</th>
                    <th>Amount</th>
                    <th>Reason</th>
                </tr>
                <?php
                    $sql = "SELECT driver_name,driver_license_number, penality_date, penality_cost , penality_type FROM penality_expense JOIN driver ON penality_expense.driver_id = driver.driver_id where penality_date = CURDATE()";
                    $result = mysqli_query($link, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['driver_name'] . "</td>";
                            echo "<td>" . $row['driver_license_number'] . "</td>";
                            echo "<td>" . $row['penality_date'] . "</td>";
                            echo "<td>" . $row['penality_cost'] . "</td>";
                            $reason = truncateString($row['penality_type'], 20) ;
                            echo "<td>" . $reason . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No recent penalties.</td></tr>";
                    }
                ?>
            </table>
        </div>

    
    </div><br><br><br>


    <div class="section">
        <h1>Help and Support</h1>
        <div>
            <p>For any assistance or support, please contact our support team.</p>
            <button class="action-button" onclick="window.location.href='adminReportsForm.php'">Contact Support</button>
            
        </div>
    </div>



</div>

</body>
</html>
