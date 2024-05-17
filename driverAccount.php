<?php
session_start();

// Check if the database connection file exists
if (file_exists('dblink.php')) {
	require 'dblink.php';
} else {
	die("File not found");
}

?>

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

    <div class="section">
        <h2>Logout:</h2>
        <form action="" method="post">
            <input type="submit" value="Log Out" name="logout_btn">
        </form>
    </div>

</div>
</body>

<?php   
// Handle logout logic
if (isset($_POST['logout_btn'])) {
    // Redirect to index.html upon logout
    header("Location: index.html");
    // Destroy session data
    session_unset();
    session_destroy();
    exit();
}
?>

</html>

<?php
// Close the database connection
mysqli_close($link);
?>
