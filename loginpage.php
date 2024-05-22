<?php
// Check if the database connection file exists
if (file_exists('dblink.php')) {
    require 'dblink.php';
} else {
    die("File not found");
}

// Start a session
session_start();

$message = "";

if (isset($_POST["username"]) && isset($_POST["password"]) && !empty($_POST["username"]) && !empty($_POST["password"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if (isset($_POST["sbt"])) {
        // Prepare and execute query for admin login
        $query = "SELECT adminid,username, adminpwd FROM adminlist WHERE username = '$username'";
        $result = mysqli_query($link, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $hash = $row['adminpwd'];

            if (password_verify($password, $hash)) {
                // Set session variable for admin
                $_SESSION['adminid'] = $row['adminid'];
                $_SESSION['admin_username'] = $row['username'];
                header("Location: adminHomePage.php"); // Redirect to the admin's page
                exit;
            } else {
                $message = "Invalid account.";
            }
        } else {
            // Prepare and execute query for driver login
            $query1 = "SELECT driver_id, username, pwd FROM driver WHERE username = '$username'";
            $result1 = mysqli_query($link, $query1);

            if (mysqli_num_rows($result1) > 0) {
                $row1 = mysqli_fetch_assoc($result1);
                $hash1 = $row1['pwd'];

                if (password_verify($password, $hash1)) {
                    // Set session variable for driver
                    $_SESSION['driver_id'] = $row1['driver_id'];
                    $_SESSION['driver_username'] = $row1['username'];
                    header("Location: driverHomePage.php"); // Redirect to the driver's page
                    exit;
                } else {
                    $message = "Invalid account.";
                }
            } else {
                $message = "Invalid account.";
            }
        }
    }
} else {
    $message = "Both username and password are required.";
}

mysqli_close($link);
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
                <?php echo "<br>$message"; ?>
            </div>
            <button type="submit" name="sbt">Login</button>
        </form>
    </div>
</div>

</body>
</html>
