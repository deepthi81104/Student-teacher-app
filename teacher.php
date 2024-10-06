<?php
 @include 'config.php';
 session_start();
 if(!isset($_SESSION['teacher_name'])){
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
    <h1>Welcome</h1><span><?php echo $_SESSION['teacher_name'] ?></span>
    <h2>You are a Teacher</h2>
</body>
</html>