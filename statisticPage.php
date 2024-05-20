<?php

session_start();
if (!isset($_SESSION['adminid'])) {

    header("Location: loginpage.php");
    exit;
}


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


<h1>Statistics</h1>

<!-- Vehicle Statistics -->
<h2>Vehicle Statistics</h2>
    
<table>
    <tr>
        <?php 
            $sql = "SELECT COUNT(vehicle_id) AS total_vehicles FROM vehicle";
            $result = mysqli_query($link, $sql);
            $row = mysqli_fetch_assoc($result);
        ?>
        
        <th>Total Number of Vehicles</th>
        <td><?php echo $row['total_vehicles']; ?></td>
    </tr>
    <tr>

        <?php 
            $sql = "SELECT COUNT(vehicle_id) AS active_vehicles FROM vehicle WHERE vehicle_status = 'in_service'";
            $result = mysqli_query($link, $sql);
            $row = mysqli_fetch_assoc($result);

            $sql = "SELECT COUNT(vehicle_id) AS inactive_vehicles FROM vehicle WHERE vehicle_status = 'out_of_service'";
            $result = mysqli_query($link, $sql);
            $row2 = mysqli_fetch_assoc($result);

            $sql = "SELECT COUNT(vehicle_id) AS maintenance_vehicles FROM vehicle WHERE vehicle_status = 'under_maintenance'";
            $result = mysqli_query($link, $sql);
            $row3 = mysqli_fetch_assoc($result);
        ?>
        <th>Vehicle Status</th>
        <td>Active: <?php echo $row['active_vehicles']; ?> | Inactive: <?php echo $row2['inactive_vehicles']; ?> | Under Maintenance: <?php echo $row3['maintenance_vehicles']; ?></td>
    </tr>
    <tr>

        <?php 
            $sql = "SELECT COUNT(vehicle_id) AS car FROM vehicle WHERE vehicle_type like '%Car%'";
            $result = mysqli_query($link, $sql);
            $row = mysqli_fetch_assoc($result);

            $sql = "SELECT COUNT(vehicle_id) AS sedan FROM vehicle WHERE vehicle_type like '%Sedan%'";
            $result = mysqli_query($link, $sql);
            $row2 = mysqli_fetch_assoc($result);

            $sql = "SELECT COUNT(vehicle_id) AS suv FROM vehicle WHERE vehicle_type like '%SUV%'";
            $result = mysqli_query($link, $sql);
            $row3 = mysqli_fetch_assoc($result);

            $sql = "SELECT COUNT(vehicle_id) AS van FROM vehicle WHERE vehicle_type like '%Van%'";
            $result = mysqli_query($link, $sql);
            $row4 = mysqli_fetch_assoc($result);

            $sql = "SELECT COUNT(vehicle_id) AS bus FROM vehicle WHERE vehicle_type like '%Bus%'";
            $result = mysqli_query($link, $sql);
            $row5 = mysqli_fetch_assoc($result);

            $sql = "SELECT COUNT(vehicle_id) AS truck FROM vehicle WHERE vehicle_type like '%Truck%'";
            $result = mysqli_query($link, $sql);
            $row6 = mysqli_fetch_assoc($result);
        ?>
        
        <th>Vehicle Types</th>
        <td>Car: <?php echo $row['car']; ?> | Sedan: <?php echo $row2['sedan']; ?> | SUV: <?php echo $row3['suv']; ?> | Van: <?php echo $row4['van']; ?> | Bus: <?php echo $row5['bus']; ?> | Truck: <?php echo $row6['truck']; ?></td>
    </tr>
    <tr>
        <?php 
            $sql = "SELECT COUNT(vehicle_id) AS electric FROM vehicle WHERE fuel_type like '%Electric%'";
            $result = mysqli_query($link, $sql);
            $row = mysqli_fetch_assoc($result);

            $sql = "SELECT COUNT(vehicle_id) AS essence FROM vehicle WHERE fuel_type like '%essence%'";
            $result = mysqli_query($link, $sql);
            $row2 = mysqli_fetch_assoc($result);

            $sql = "SELECT COUNT(vehicle_id) AS diesel FROM vehicle WHERE fuel_type like '%diesel%' or fuel_type like '%gasoil%' ";
            $result = mysqli_query($link, $sql);
            $row3 = mysqli_fetch_assoc($result);
        ?>
        <th>Vehicle Fuel Types</th>
        <td>Electric: <?php echo $row['electric']; ?> | Essence: <?php echo $row2['essence']; ?> | Diesel: <?php echo $row3['diesel']; ?></td>
    </tr>
</table>

<!-- Driver Statistics -->
<h2>Driver Statistics</h2>

<table>
    <tr>
        <?php 
            $sql = "SELECT COUNT(driver_id) AS total_drivers FROM driver";
            $result = mysqli_query($link, $sql);
            $row = mysqli_fetch_assoc($result);
        ?>
        <th>Total Number of Drivers</th>
        <td><?php echo $row['total_drivers']; ?></td>
    </tr>
    <tr>
        <?php 
            $sql = "SELECT COUNT(driver_id) AS active_drivers FROM driver WHERE driver_status = 'active'";
            $result = mysqli_query($link, $sql);
            $row = mysqli_fetch_assoc($result);

            $sql = "SELECT COUNT(driver_id) AS inactive_drivers FROM driver WHERE driver_status = 'inactive'";
            $result = mysqli_query($link, $sql);
            $row2 = mysqli_fetch_assoc($result);
        ?>
        <th>Driver Status</th>
        <td>Active: <?php echo $row['active_drivers']; ?> | Inactive: <?php echo $row2['inactive_drivers']; ?></td>
    </tr>
    <tr>
        <?php
            $sql = "SELECT AVG(YEAR(CURDATE()) - YEAR(STR_TO_DATE(driver_birthdate, '%Y-%m-%d'))) AS avg_driver_age
            FROM driver";
            $result = mysqli_query($link, $sql);
            $row = mysqli_fetch_assoc($result);
            $row['avg_driver_age'] = round($row['avg_driver_age']);
        ?>

            <th>Drivers Average Age:</th> 
            <td><?php echo $row['avg_driver_age'].' years old'; ?></td>
    </tr>
</table>


<!-- Mission Statistics -->
<h2>Mission Statistics</h2>
<table>
    <tr>
        <?php 
            $sql = "SELECT COUNT(mission_id) AS total_missions FROM mission";
            $result = mysqli_query($link, $sql);
            $row = mysqli_fetch_assoc($result);
        ?>

        <th>Total Number of Missions</th>
        <td><?php echo $row['total_missions']; ?></td>
    </tr>
    <tr>
        <?php 
            $sql = "SELECT COUNT(mission_id) AS successful_missions FROM mission WHERE mission_status = 'completed'";
            $result = mysqli_query($link, $sql);
            $row = mysqli_fetch_assoc($result);

            $sql = "SELECT COUNT(mission_id) AS failed_missions FROM mission WHERE mission_status = 'cancelled'";
            $result = mysqli_query($link, $sql);
            $row2 = mysqli_fetch_assoc($result);

            
            $row['total_missions'] = $row['successful_missions'] + $row2['failed_missions'];
            $average = 0;
            if($row['total_missions'] != 0){
            $average = ($row['successful_missions'] / $row['total_missions']) * 100;}
        ?>


        <th>Mission Success Rate</th>
        <td>Completed: <?php echo $row['successful_missions']; ?> | Cancelled: <?php echo $row2['failed_missions']; ?> | Average: <?php echo round($average).'%'; ?></td>
    </tr>
    <tr>
        <?php 
            $sql = "SELECT AVG(TIME_TO_SEC(TIMEDIFF(end_date_time, start_date_time)) / 3600) AS avg_duration
            FROM mission";
            $result = mysqli_query($link, $sql);
            $row = mysqli_fetch_assoc($result);
        ?>
        <th>Average Mission Duration</th>
        <td><?php echo round($row['avg_duration']).' hours'; ?></td>
    </tr>
</table>

<!-- Expense Statistics -->
<h2>Expense Statistics year <?php echo date("Y"); ?>:</h2>
<table>
    <tr>
        <?php 
            $sql ="SELECT SUM(cost) AS total_expenses
            FROM mission
            WHERE YEAR(start_date_time) = YEAR(CURRENT_DATE)";
            $result = mysqli_query($link, $sql);
            $row = mysqli_fetch_assoc($result);
        ?>
            
        <th>Total Missions Expenses:</th>
        <td><?php echo $row['total_expenses'].'DA'; ?></td>
    </tr>
    <tr>
        <?php 
            $sql ="SELECT SUM(cost) AS total_expenses
            FROM vehicle_maintenance 
            WHERE YEAR(maintenance_date) = YEAR(CURRENT_DATE)";
            $result = mysqli_query($link, $sql);
            $row = mysqli_fetch_assoc($result);
        ?>
        <th>Total Maintenance Expenses:</th>
        <td><?php echo $row['total_expenses'].'DA'; ?></td>
    </tr>
    <tr>
        <?php 
            $sql ="SELECT SUM(penality_cost) AS total_expenses
            FROM penality_expense
            WHERE YEAR(penality_date) = YEAR(CURRENT_DATE)";
            $result = mysqli_query($link, $sql);
            $row = mysqli_fetch_assoc($result);
        ?>
        <th>Total Penalties Expenses:</th>
        <td><?php echo $row['total_expenses'].'DA'; ?></td>
    </tr>
    <tr>
        <?php 
            $sql ="SELECT SUM(expense_cost) AS total_expenses
            FROM vehicle_expense
            WHERE YEAR(expense_date) = YEAR(CURRENT_DATE)";
            $result = mysqli_query($link, $sql);
            $row = mysqli_fetch_assoc($result);
        ?>
        <th>Total Vehicle Expenses:</th>
        <td><?php echo $row['total_expenses'].'DA'; ?></td>
    </tr>

</table>

</body>
</html>
<?php mysqli_close($link); ?>