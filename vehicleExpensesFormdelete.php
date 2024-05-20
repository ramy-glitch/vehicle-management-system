<?php
if (file_exists('dblink.php')) 
{
	require 'dblink.php';
}
else {
	die("File not found");
}


    
$veId = null;

// Retrieve vehicle ID from URL parameter
            if (isset($_GET['id'])) {
                $veId = $_GET['id'];
            }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete This Expense</title>
    <link rel="stylesheet" href="form.css">
</head>
<body>
    <div class="container">
        <h2>Delete This Vehicle Expense</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?id=".$veId; ?>" method="post">

            <label for="penalty_amount">Are you sure you want to delete this record ?</label>

            <input type="submit" value="Delete" name="delete_btn">
            <input type="button" value="Cancel" onclick="window.location.href='vehicleExpensesList.php'">
        </form>
    </div>
</body>
</html>




<?php

    if (isset($_POST['delete_btn']) ){


        $sql = "DELETE FROM vehicle_expense WHERE expense_id = $veId";
        $stmt = mysqli_query($link, $sql);

        mysqli_close($link);
        header("Location: penaltiesExpensestList.php");

        
        exit;
    }
?>


