<?php
    // Database configuration
$host  = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "fleetvehiclemanage_db";

// Create database connection
$link = mysqli_connect($host, $dbuser, $dbpass, $dbname);

// Check connection
if(mysqli_connect_error())
{
    die("Connection establishing failed!");
}
else
{
    echo "Connection established successfully. <br >";
}
mysqli_close($link);
?>
