<?php
session_start();
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

<?php    
    if (isset($_SESSION['driver_id'])) {

        $sql = "SELECT vehicle_id FROM mission WHERE driver_id = ? AND (mission_status = 'in_progress' or mission_status = 'scheduled')";
        $stmt = mysqli_prepare($link, $sql);

        if ($stmt) {
            $stmt->bind_param("i", $_SESSION['driver_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();
        }

    
    } 

?>

<!-- Navbar -->
<div class="navbar">
    <div class="navbar-brand"><a href="driverHomePage.php">Driver Dashboard</a></div>
    <ul class="navbar-menu">
        <!-- Navbar items -->
        <li class="navbar-item"><a href="driverHomePage.php" class="nav-link">Dashboard</a></li>
        <li class="navbar-item"><a href="dmissionsList.php" class="nav-link">Missions</a></li>
        <?php if ($result->num_rows == 0) { ?> <li class="navbar-item"><a href="#"class="nav-link">Vehicle</a></li><?php }else{?> <li class="navbar-item"><?php echo '<a href="dvehicleDetails.php?id=' . $row["vehicle_id"] . '"class="nav-link">Vehicle</a>'?></li><?php } ?>
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
        <?php
            
            if (isset($_SESSION['driver_id'])) {

                $sql = "SELECT driver_name,username FROM driver WHERE driver_id = ?";
                $stmt = mysqli_prepare($link, $sql);
                
                if ($stmt) {
                    $stmt->bind_param("i", $_SESSION['driver_id']);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();
                    $stmt->close();

                    echo "<h1>Welcome, ". $row['driver_name'] ."!</h1>";
                    echo "<p>You are logged in as ".$row['username'].".</p>";
                }
            }
        ?>
    </div>

    <?php    
    if (isset($_SESSION['driver_id'])) {

        $sql = "SELECT * FROM mission WHERE driver_id = ? AND (mission_status = 'in_progress' or mission_status = 'scheduled')";
        $stmt = mysqli_prepare($link, $sql);

        if ($stmt) {
            $stmt->bind_param("i", $_SESSION['driver_id']);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $stmt->close();
        }

    
    } 

?>

    <!-- Section: Current Mission -->
    <div class="section">
        <h1>My Current Mission</h1>
        <div>
            <p>Status: <?php if($result->num_rows > 0){ echo $row['mission_status'];} else{echo "no mission assigned";} ?></p>
        </div>
    </div>



    <!-- Section: Quick Actions -->
    <div class="section">
        <h1>Quick Actions</h1>
        <div>
            <button class="action-button" onclick="window.location.href='ddriverReports.php'">Report Issue</button>
            <button class="action-button" onclick="window.location.href='ddriverReportsform.php'">Request Maintenance</button>
            <button class="action-button secondary" onclick="window.location.href='driverAccount.php'">Edit Profile</button>
        </div>
    </div>

    <!-- Section: Help and Support -->
    <div class="section">
        <h1>Help and Support</h1>
        <div>
            <button class="action-button" onclick="window.location.href='ddriverReportsform.php'" >Contact Support</button>
        </div>
    </div>

</div>

</body>
</html>
