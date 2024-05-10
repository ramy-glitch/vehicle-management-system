<?php

if (file_exists('dblink.php')) 
{
	require 'dblink.php';
}
else {
	die("File not found");
}

if (isset($_GET['id'])) {
    $vehicleId = $_GET['id'];


    // SQL query to retrieve vehicle data by ID
    $sql = "SELECT * FROM vehicle WHERE vehicle_id = ?";
    $stmt = mysqli_prepare($link, $sql);
    $stmt->bind_param("i", $vehicleId);
    $stmt->execute();
    $result = $stmt->get_result();

    // Display vehicle information in editable input fields
    if ($result->num_rows > 0) {
        $vehicle = $result->fetch_assoc(); 
    }
}
        header("Location: vehicleformedit.php");
        exit;
?>