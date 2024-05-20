
<?php
if (file_exists('dblink.php')) 
{
	require 'dblink.php';
}
else {
	die("File not found");
}


    
$Id = null;

            if (isset($_GET['id'])) {
                $Id = $_GET['id'];
            }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete This Report</title>
    <link rel="stylesheet" href="form.css">
</head>
<body>
    <div class="container">
        <h2>Delete This Report</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?id=".$Id; ?>" method="post">

            <label for="penalty_amount">Are you sure you want to delete this record ?</label>

            <input type="submit" value="Delete" name="delete_btn">
            <input type="button" value="Cancel" onclick="window.location.href='adminReportList.php'">
        </form>
    </div>
</body>
</html>




<?php

    if (isset($_POST['delete_btn']) ){


        $sql = "DELETE FROM admin_report WHERE report_id = $Id";
        $stmt = mysqli_query($link, $sql);

        mysqli_close($link);
        header("Location: adminReportList.php");

        
        exit;
    }
?>


