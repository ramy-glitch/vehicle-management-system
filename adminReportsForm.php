<?php

    $tab = array(
        "report_title" => $_POST["report_title"],
        "report_content" => $_POST["report_content"]
    );

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
    <form action="" method="post">
        <label for="report_title">Report Title:</label>
        <input type="text" id="report_title" name="report_title" required>

        <label for="report_content">Report Content:</label>
        <textarea id="report_content" name="report_content" rows="6" required></textarea>

        <input type="submit" value="Submit">
        <input type="button" value="Back" onclick="window.location.href='adminReportList.php'">
    </form>
    </div>
</body>
</html>
