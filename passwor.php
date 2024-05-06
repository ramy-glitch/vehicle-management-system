<?php
    // Database configuration
$host  = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "adminlist";
 
// Create database connection
$link = mysqli_connect($host, $dbuser, $dbpass, $dbname);

// mysqli_select_db($link,"quiz");
  
// Check connection
if(mysqli_connect_error())
{
 echo "Connection establishing failed! <br >";
}
else
{
    $user= admin;
    $pwd= admin;

    $passhash=password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_query($link,"Insert into adminlist (username,adminpwd) values('$user','$passhash')");

    

 echo "Connection established successfully. <br >";
}
mysqli_close($link);
?>