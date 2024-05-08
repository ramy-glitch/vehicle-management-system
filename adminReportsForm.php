<?php
// Initialize variables to store form data and error messages
$report_title = $report_content = $report_date = '';
$errorMessages = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (isset($_POST["submit"])) {
    // Retrieve form data
    $report_title = $_POST["report_title"];
    $report_content = $_POST["report_content"];
    $report_date = $_POST["report_date"];
    }


    // Validate report title
    if (empty($report_title)) {
        $errorMessages["report_title"] = "Report title is required.";
    }

    // Validate report content
    if (empty($report_content)) {
        $errorMessages["report_content"] = "Report content is required.";
    }

    if(empty($report_date) || !preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $report_date)){  // Matches yyyy-mm-dd
        $errorMessages["report_date"] = "Report date is required.";
    }

    // Process form data if no validation errors
    if (empty($errorMessages)) {
        // Process the form data (e.g., save to database)
        // For example, you can use a function to save the report to a database
        // saveReport($report_title, $report_content);

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
            <input type="text" id="report_title" name="report_title" value="<?php echo htmlspecialchars($report_title); ?>" required>
            <?php if(isset($errorMessages["report_title"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["report_title"]; ?></p>
            <?php } ?>

            <label for="report_content">Report Content:</label>
            <textarea id="report_content" name="report_content" rows="6" required><?php echo htmlspecialchars($report_content); ?></textarea>
            <?php if(isset($errorMessages["report_content"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["report_content"]; ?></p>
            <?php } ?>

            <label for="report_date">Report Date:</label>
            <input type="date" id="report_date" name="report_date" value="<?php echo htmlspecialchars($report_date);?>" required>
            <?php if(isset($errorMessages["report_date"])) { ?>
                <p style="color: red;"><?php echo $errorMessages["report_date"]; ?></p>
            <?php } ?>


            <input type="submit" value="submit" name="submit">
            <input type="button" value="Back" onclick="window.location.href='adminReportList.php'">
        </form>
    </div>
</body>
</html>
