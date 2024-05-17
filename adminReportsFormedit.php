<?php
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
                $sql = "SELECT * FROM admin_report WHERE report_id = ?";
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

<?php
// Initialize variables to store form data and error messages
$report_title = $report_content = $report_date = '';
$errorMessages = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    
    // Retrieve form data
    $report_title = $_POST["report_title"];
    $report_content = $_POST["report_content"];
    $report_date = $_POST["report_date"];
    


    // Validate report title
    if (empty($report_title)) {
        $report_title = $report['report_issue'];
    }

    // Validate report content
    if (empty($report_content)) {
        $report_content = $report['report_description'];
    }

    if(empty($report_date)){ 
        $report_date = $report['report_date'];
    }elseif($report_date=="0000-00-00" || !preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $report_date))
    {
        $errorMessages["report_date"] = "Invalid date.";
    }

    // Process form data if no validation errors
    if (empty($errorMessages)) {
        // Process the form data (e.g., save to database)
        $sql = "UPDATE admin_report SET report_date = ? , report_issue = ?, report_description = ? WHERE report_id = ? ";
        $stmt = mysqli_prepare($link, $sql);
        $stmt->bind_param("sssi", $report_date, $report_title, $report_content, $reportId);
        $stmt->execute();
        $stmt->close();

        // Redirect after successful submission
        header("Location: adminReportList.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Report Form</title>
    <link rel="stylesheet" href="form.css">
</head>
<body>
    <div class="container">
        <h2>Admin Report Form</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="report_title">Report Title:</label>
            <input type="text" id="report_title" name="report_title" value="<?php echo htmlspecialchars($report_title); ?>" placeholder="<?php echo htmlspecialchars($report['report_issue']); ?>"  >
            <?php if(isset($errorMessages["report_title"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["report_title"]; ?></p>
            <?php } ?>

            <label for="report_content">Report Content:</label>
            <textarea id="report_content" name="report_content" rows="6" placeholder="<?php echo htmlspecialchars($report['report_description']); ?>" ><?php echo htmlspecialchars($report_content); ?></textarea>
            <?php if(isset($errorMessages["report_content"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["report_content"]; ?></p>
            <?php } ?>

            <label for="report_date">Report Date:</label>
            <input type="date" id="report_date" name="report_date" value="<?php echo htmlspecialchars($report_date);?>" >
            <?php if(isset($errorMessages["report_date"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["report_date"]; ?></p>
            <?php } ?>


            <input type="submit" value="submit" name="submit">
            <input type="button" value="Back" onclick="window.location.href='adminReportList.php'">
        </form>
    </div>
</body>
</html>

<?php mysqli_close($link); ?>