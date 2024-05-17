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
    <title>Penalties & Fines</title>
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
    <h1>Penalties & Fines</h1><br><br>

    <!-- Search and Filter -->
    <div class="search-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" class="search-input" name="search" placeholder="Search expenses...">
            <button type="submit" class="btn btn-primary" name="search_btn">Search</button>
            <button type="submit" class="btn btn-primary" name="reload_btn">Reload All</button>
        </form>
    </div><br><br><br><br>

    <!-- Penalties List -->
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Description</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Assuming $link is your database connection
            $sql = "SELECT penality_date, penality_type, penality_cost FROM penality_expense where driver_id = '$_SESSION[driver_id]'";

            // Implement the search feature and reload button
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $search = $_POST['search'];
                $sql .= " WHERE penality_type LIKE '%$search%' or penality_cost LIKE '%$search%' or penality_date LIKE '%$search%'";

                if (isset($_POST['reload_btn'])) {
                    $sql = "SELECT penality_date, penality_type, penality_cost FROM penality_expense where driver_id = '$_SESSION[driver_id]'";
                }
            }

            $result = mysqli_query($link, $sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row["penality_date"]) . '</td>';
                    echo '<td>' . htmlspecialchars($row["penality_type"]) . '</td>';
                    echo '<td>$' . htmlspecialchars($row["penality_cost"]) . '</td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="3">No penalties found.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>

<?php mysqli_close($link); ?>
