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
    
$penaltyId = $penalty = null;

// Retrieve vehicle ID from URL parameter
            if (isset($_GET['id'])) {
                $penaltyId = $_GET['id'];
            }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete This penalty</title>
    <link rel="stylesheet" href="form.css">
</head>
<body>
    <div class="container">
        <h2>Delete This penalty</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?id=".$penaltyId; ?>" method="post">

            <label for="penalty_amount">Are you sure you want to delete this record ?</label>

            <input type="submit" value="Delete" name="delete_btn">
            <input type="button" value="Cancel" onclick="window.location.href='penaltiesExpensestList.php'">
        </form>
    </div>
</body>
</html>




<?php

    if (isset($_POST['delete_btn']) ){


        $sql = "DELETE FROM penality_expense WHERE penality_id = $penaltyId";
        $stmt = mysqli_query($link, $sql);

        mysqli_close($link);
        header("Location: penaltiesExpensestList.php");

        
        exit;
    }
?>


