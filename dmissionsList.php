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
    <title>List of Missions</title>
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
    <h1>List of Missions</h1>

    <!-- Search and Filter -->
    <div class="search-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" name="search" class="search-input" placeholder="Search missions...">
            <button type="submit" class="btn btn-primary" name="search_btn">Search</button>
            <button type="submit" class="btn btn-primary" name="reload_btn">Reload All</button>
        </form>
    </div>

    <!-- Mission List Table -->
    <table>
        <thead>
            <tr>
                <th>Status</th>
                <th>Destination</th>
                <th>End Date Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Assuming $link is your database connection
            $sql = "SELECT mission_id, mission_status, end_location, end_date_time FROM mission";

            // Implement the search feature and reload button
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $search = $_POST['search'];
                $sql .= " WHERE end_location LIKE '%$search%'";

                if (isset($_POST['reload_btn'])) {
                    $sql = "SELECT mission_id, mission_status, end_location, end_date_time FROM mission";
                }
            }

            $result = mysqli_query($link, $sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row["mission_status"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["end_location"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["end_date_time"]) . '</td>';
                    echo '<td>';
                    echo '<button class="btn btn-secondary"><a href="dmissionDetails.php?mission_id=' . $row["mission_id"] . '">View</a></button>';
                    echo '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="4">No missions found.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
