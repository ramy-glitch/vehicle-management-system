<?php
if (file_exists('dblink.php')) 
{
	require 'dblink.php';
}
else {
	die("File not found");
}


$vehicleId = $vehicle = null;
// Retrieve vehicle ID from URL parameter
            if (isset($_GET['id'])) {
                $vehicleId = $_GET['id'];


                // SQL query to retrieve vehicle data by ID
                $sql = "DELETE FROM vehicle WHERE vehicle_id = ?";
                $stmt = mysqli_prepare($link, $sql);
                $stmt->bind_param("i", $vehicleId);
                $stmt->execute();
                $stmt->close(); // Close statement in order to free up resources
                header("Location: vehiclesList.php");
                exit();
            }

// Close database connection
mysqli_close($link);

?>