<?php
 @include 'config.php';
 session_start();

 if(!isset($_SESSION['admin_name'])){
    header('location:login.php');
 }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student page</title>
</head>
<body>
    <h1>Welcome</h1><span><?php echo $_SESSION['admin_name'] ?></span>
    <h2>You are a Admin</h2>
</body>
</html>