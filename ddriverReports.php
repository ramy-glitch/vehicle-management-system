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
        <?php if ($result->num_rows == 0) { ?> <li class="navbar-item"><a href="#"class="nav-link">Vehicle</a></li><?php }else{?> <li class="navbar-item"><?php echo '<a href="dvehicleDetails.php?id=' . $row["vehicle_id"] . '"class="nav-link">Vehicle</a>'?></li><?php } ?>
        <li class="navbar-item"><a href="ddriverReports.php" class="nav-link">Reports</a></li>
        <li class="navbar-item"><a href="dpenaltiesList.php" class="nav-link">Penalties & Fines</a></li>
        <li class="navbar-item"><a href="#" class="nav-link">Notifications</a></li>
        <li class="navbar-item"><a href="driverAccount.php" class="nav-link">Account</a></li>
    </ul>
</div>

<!-- Main content container -->
<div class="container">
    <h1>List of Driver Reports</h1><br><br>

    <!-- Search and Filter -->
    <div class="search-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" name="search" class="search-input" placeholder="Search reports...">
            <button type="submit" class="btn btn-primary" name="search_btn">Search</button>
            <button type="submit" class="btn btn-primary" name="reload_btn">Reload All</button>
        </form>
    </div><br><br>

    <!-- Write a new report Button -->
    <a href="ddriverReportsform.php" class="btn btn-primary" style="width: fit-content;">Write a Report</a><br><br>

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
            <?php
            // Assuming $link is your database connection
            $sql = "SELECT report_id, report_issue, report_date FROM driver_report where driver_id = '$_SESSION[driver_id]'";

            // Implement the search feature and reload button
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $search = $_POST['search'];
                $sql .= " AND (report_issue LIKE '%$search%' or report_date LIKE '%$search%')";

                if (isset($_POST['reload_btn'])) {
                    $sql = "SELECT report_id, report_issue, report_date FROM driver_report where driver_id = '$_SESSION[driver_id]'";
                }
            }

            $result = mysqli_query($link, $sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row["report_issue"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["report_date"]) . '</td>';
                    echo '<td>';
                    // View button 
                    echo '<a class="btn btn-secondary" href="ddriverReportsformview.php?id=' . $row['report_id'] . '">View</a>&nbsp;&nbsp;';
                    // Delete button 
                    echo '<a class="btn btn-secondary" href="ddriverReportsformdelete.php?id=' . $row['report_id'] . '">Delete</a>&nbsp;&nbsp;';
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="3">No driver reports found.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php mysqli_close($link); ?>