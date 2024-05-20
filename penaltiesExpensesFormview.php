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

<?php

$penaltyId = $penalty = null;
// Retrieve vehicle ID from URL parameter
            if (isset($_GET['id'])) {
                $penaltyId = $_GET['id'];


                // SQL query to retrieve maintenance data by ID
                $sql = "SELECT * FROM penality_expense WHERE penality_id = ?";
                $stmt = mysqli_prepare($link, $sql);
                $stmt->bind_param("i", $penaltyId);
                $stmt->execute();
                $result = $stmt->get_result();

                // Display maintenance information in editable input fields
                if ($result->num_rows > 0) {
                    $penalty = $result->fetch_assoc(); 
                }
            }
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penalties and Fines Form</title>
    <link rel="stylesheet" href="form.css">
</head>
<body>
    <div class="container">
        <h2>Penalties and Fines Form</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?id=".$penaltyId; ?>" method="post">
            
        
        <label for="driver_concerned">Driver Concerned:</label>
                    <?php
                    // SQL query to retrieve inactive driver data
                    $sql = "SELECT driver_name, driver_phone FROM driver WHERE driver_id = $penalty[driver_id]";
                    $result = mysqli_query($link, $sql);

                    // Check if any rows are returned
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            $driverName = htmlspecialchars($row["driver_name"]);
                            $driverPhone = htmlspecialchars($row["driver_phone"]);

                            // Output the option with the appropriate value and selected attribute
                            echo '<input type="text" value="' . $driverName . ' - ' . $driverPhone . '">';
                        }
                    }
                    ?>
            

            
            <!-- Penalty Type -->
            <label for="penalty_type">Penalty Type:</label>
            <input type="text" id="penalty_type" name="penalty_type" value="<?php echo htmlspecialchars($penalty['penality_type']); ?>" >

            
            <!-- Penalty Date -->
            <label for="penalty_date">Penalty Date:</label>
            <input type="text" id="penalty_date" name="penalty_date" value="<?php echo htmlspecialchars($penalty['penality_date']); ?>" >
            
            <!-- Penalty Amount -->
            <label for="penalty_amount">Penalty Amount:</label>
            <input type="text" id="penalty_amount" name="penalty_amount" value="<?php echo htmlspecialchars($penalty['penality_cost']); ?>" >

            <input type="button" value="Back" onclick="window.location.href='penaltiesExpensestList.php'">
        </form>
    </div>
</body>
</html>
<?php mysqli_close($link); ?>