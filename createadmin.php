
<?php

$admin= "admin";
$adminpwd = "admin";

$adminpwdh = password_hash($adminpwd, PASSWORD_DEFAULT);

$sql = "INSERT INTO adminlist (username, adminpwd) VALUES (?, ?)";
$stmt = mysqli_prepare($link, $sql);
$stmt->bind_param("ss", $admin, $adminpwdh);
$stmt->execute();
echo "Admin account created successfully";


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Admin</title>
    <link rel="stylesheet" href="form.css">
</head>
<body>
    <div class="container">

    </div>

</body>
</html>

