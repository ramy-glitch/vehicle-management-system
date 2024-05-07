<?php
if (file_exists('dblink.php')) 
{
	require 'dblink.php';
}
else {
	die("File not found");
}

$message = "";

if (isset($_POST["sbt"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    $query = "SELECT username,adminpwd FROM adminlist WHERE username = '$username'";
    
    $result = mysqli_query($link, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hash = $row['adminpwd'];
        
        if (password_verify($password, $hash)) {
            header("Location: adminHomePage.html"); // Redirect to the user's page
            exit;
        } else {
            $message = "Invalid password.";
        }
    } else {
        $message = "Invalid username.";
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="loginpage.css">
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <a href="index.html"><img class="logo" src="logo-black.png" alt="logo" width="200px"></a>
    <ul class="navbar-menu">
        <li><a href="index.html">Home</a></li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <li><a href="loginpage.php">Log in</a></li>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </ul>
</div>
<br><br><br><br><br><br><br><br><br>
<!-- Login Form -->
<div class="container">
    <div class="login-container">
        <h2>Login</h2>
        <form action="" method="POST">
            <div class="input-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br>
                <?php if (isset($_POST["username"]) && isset($_POST["password"])) echo $message;?>
            </div>
            <button type="submit" name="sbt">Login</button>
        </form>
    </div>
</div>

</body>
</html>
