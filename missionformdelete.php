
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


    
$Id = null; $errorMessages = [];

            if (isset($_GET['id'])) {
                $Id = $_GET['id'];
            }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete This Mission</title>
    <link rel="stylesheet" href="form.css">
</head>
<body>
    <div class="container">
        <h2>Delete This Mission</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?id=".$Id; ?>" method="post">

            <label>Are you sure you want to delete this record ?</label>

            <input type="submit" value="Delete" name="delete_btn">
            <input type="button" value="Cancel" onclick="window.location.href='missionList.php'">
        </form>
        <?php

            if (isset($_POST['delete_btn']) ){
                
                $sql = "SELECT mission_status from mission WHERE mission_id = $Id";
                $stmt = mysqli_query($link, $sql);
                $row = mysqli_fetch_assoc($stmt);
                $status = $row['mission_status'];
                if($status == 'completed' || $status == 'cancelled' || $status == 'scheduled'){
                    $sql ="DELETE FROM mission WHERE mission_id = $Id";
                    $stmt = mysqli_query($link, $sql);
                    mysqli_close($link);
                    header("Location: missionList.php");
                    exit;
                }else{
                        $errorMessages["no_delete"] = "You can only delete completed or cancelled or scheduled missions";
                }  
                
            }
        ?>

            <?php if(isset($errorMessages["no_delete"])) { ?>
                    <p style="color: red;"><?php echo $errorMessages["no_delete"]; ?></p>
            <?php } ?>


    </div>
</body>
</html>







