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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .header {
            background-color: #17a2b8;
            padding: 10px;
        }

        .sidebar {
            background-color: #343a40;
            width: 15%;
            height: 90vh;
            padding: 20px;
            float: left;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 20px 0;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
        }

        .content {
            margin-left: 15%;
            padding: 20px;
            overflow: auto;
        }

        .card-container {
            display: flex;
            justify-content: space-around;
        }

        .card {
           
            border-radius: 8px;
            padding: 20px;
            position: relative;
            width: 30%;
            margin: 10px;
        }

        .card-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 80px;
            height: 80px;
        }

        .card-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .card-text {
            font-size: 16px;
        }

        /* Announcement section styling */
        .announcement-section {
            border: 2px solid grey;
            border-radius: 8px;
            margin-top: 20px;
            padding: 20px;
        }

        .announcement-title {
            text-transform: uppercase;
            font-size: 22px;
            font-weight: bold;
            color: #333;
        }

        .announcement-content {
            margin:20px;
            font-size: 16px;
            color: #555;
        }
        .task-section {
            border: 2px solid grey;
            border-radius: 8px;
            margin-top: 20px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="header bg-info">
        <h1>Welcome <span class="text-light"><?php echo $_SESSION['admin_name'] ?></span></h1>
        <h2 class="text-dark">You are a Teacher</h2>
    </div>
    <div class="sidebar">
        <ul>
            <li><a href="#">Home</a></li>
            <li><a href="admin_add_class.php">Add classes</a></li>
            <li><a href="#">Add students</a></li>
            <li><a href="#">View and Manage Classes</a></li>
            <li><a href="#">View and Manage Students</a></li>
        </ul>
    </div>
    <div class="content">
        <div class="card-container">
            <div class="card bg-warning">
                <div class="card-title">ATTENDANCE</div>
                <img src="images/attendance.png" class="card-icon">
                <div class="card-text">Maintain student attendance <br> records</div>
            </div>
            <div class="card bg-success">
                <div class="card-title text-light">CLASSES</div>
                <img src="images/bell.png" class="card-icon">
                <div class="card-text text-light">You are teaching<br> in 3 classes</div>
            </div>
            <div class="card bg-danger">
                <div class="card-title text-light">ASSIGNMENT</div>
                <img src="images/assignment.png" class="card-icon">
                <div class="card-text text-light">You have given <br>1 assignment</div>
            </div>
        </div>

        <!-- Announcement Section -->
        <div class="announcement-section bg-light">
            <div class="announcement-title">Announcements</div>
            <div class="announcement-content">
                <ul>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
            </div>
        </div>
        <div class="task-section bg-light">
            <div class="announcement-title">TASKS</div>
            <div class="announcement-content">
                <ul>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
