<?php
session_start();
include 'config.php'; // DB connection

$teacher_id = $_SESSION['teacher_id'];

// Fetch courses taught by the teacher
$query = "SELECT class_id, class_name FROM classes WHERE teacher_id = '$teacher_id'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher's Courses</title>
</head>
<body>
    <h2>Your Courses</h2>
    <ul>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <li>
                <a href="input_grade_teacher.php?class_id=<?php echo $row['class_id']; ?>">
                    <?php echo $row['class_name']; ?>
                </a>
            </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>
