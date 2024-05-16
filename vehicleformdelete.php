<?php
// Check if database connection file exists
if (file_exists('dblink.php')) {
    require 'dblink.php';
} else {
    die("Database connection file not found");
}

// Initialize variables
$currentStatus = $vehicle = null;

// Retrieve vehicle ID from URL parameter
if (isset($_GET['id'])) {
    $vehicleId = $_GET['id'];

    // Check vehicle status
    $sql = "SELECT vehicle_status FROM vehicle WHERE vehicle_id = ?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "i", $vehicleId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $currentStatus = $row['vehicle_status'];

        // Check vehicle status and perform actions accordingly
        if ($currentStatus == 'in_service') {
            // Vehicle is in service, display message
            echo "<script>alert('Vehicle is currently in service and cannot be deleted.')</script>";
        } else {
            // Add a confirmation dialog before deleting the vehicle
            echo "<script>if (confirm('Are you sure you want to delete this vehicle?')) {";

            // Vehicle can be deleted
            $deleteSql = "DELETE FROM vehicle WHERE vehicle_id = ?";
            $deleteStmt = mysqli_prepare($link, $deleteSql);
            mysqli_stmt_bind_param($deleteStmt, "i", $vehicleId);
            if (mysqli_stmt_execute($deleteStmt)) {
                echo "alert('Vehicle deleted successfully.');";
            } else {
                echo "alert('Failed to delete vehicle.');";
            }

            echo "} else {";
            echo "alert('Vehicle deletion cancelled.');";
            echo "}</script>";
        }
    } else {
        // Vehicle not found
        echo "<script>alert('Vehicle not found.')</script>";
    }

    // Close database connection
    mysqli_close($link);

    // Display "Go Back" button within HTML structure
    echo '<html>';
    echo '<head>';
    echo '<title>Vehicle Deletion Result</title>';
    echo '</head>';
    echo '<body>';
    echo '<h2>Vehicle Deletion Result</h2>';
    echo '<p><a href="vehiclesList.php"><button>Go Back to Vehicle List</button></a></p>';
    echo '</body>';
    echo '</html>';
}
?>
