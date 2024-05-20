<?php
session_start();
if (!isset($_SESSION['driver_id'])) {

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

$reportId = $report = null;
// Retrieve vehicle ID from URL parameter
            if (isset($_GET['id'])) {
                $reportId = $_GET['id'];


                // SQL query to retrieve maintenance data by ID
                $sql = "SELECT * FROM driver_report WHERE report_id = ? ";
                $stmt = mysqli_prepare($link, $sql);
                $stmt->bind_param("i", $reportId);
                $stmt->execute();
                $result = $stmt->get_result();

                // Display maintenance information in editable input fields
                if ($result->num_rows > 0) {
                    $report = $result->fetch_assoc(); 
                }
            }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Driver Report Details</title>
    <link rel="stylesheet" href="form.css">
</head>
<body>
    <div class="container">
        <h2>Driver Report Details</h2>
        <form>
            <label for="report_title">Report Title:</label>
            <input type="text" id="report_title" name="report_title" value="<?php echo htmlspecialchars($report['report_issue']); ?>" >


            <label for="report_content">Report Content:</label>
            <textarea id="report_content" name="report_content" rows="6" ><?php echo htmlspecialchars($report['report_description']); ?></textarea>


            <label for="report_date">Report Date:</label>
            <input type="text" id="report_date" name="report_date" value="<?php echo htmlspecialchars($report['report_date']); ?>" >

            <input type="button" value="Back" onclick="window.location.href='driverReportList.php'">
        </form>
    </div>
</body>
</html>

<?php mysqli_close($link); ?>