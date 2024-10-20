<?php
session_start();
include 'config.php'; 

// Assuming the student is logged in and has an ID stored in the session
if (!isset($_SESSION['student_id'])) {
    header('Location: login.php'); // Redirect to login page if not logged in
    exit;
}

$student_id = $_SESSION['student_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Grades</title>
</head>
<body>
    <h2>View Your Grades</h2>
    
    <!-- Create a form that submits the student ID using POST method -->
    <form action="student_grades.php" method="POST">
        <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
        <input type="submit" value="View Grades">
    </form>
</body>
</html>
