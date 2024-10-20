<?php
session_start();
include 'config.php'; // DB connection

// Check if student_id exists in the session
if (!isset($_SESSION['student_id'])) {
    echo "Student ID not found in session.";
    exit;
}

$student_id = $_SESSION['student_id'];
echo "Logged in as Student ID: $student_id<br>";

// Fetch the grades for the student
$query = "
    SELECT c.class_name, sg.cat_type, sg.grade 
    FROM student_grades sg
    JOIN classes c ON sg.class_id = c.class_id
    WHERE sg.student_id = '$student_id'
";
$result = mysqli_query($conn, $query);

// Check if the query returns results
if (mysqli_num_rows($result) === 0) {
    echo "No grades found for student ID: $student_id.";
} else {
    // Prepare an array to hold the grades grouped by class
    $grades = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $class_name = $row['class_name'];
        $cat_type = $row['cat_type'];
        $grade = $row['grade'];

        // Group by class and CAT
        if (!isset($grades[$class_name])) {
            $grades[$class_name] = [];
        }
        $grades[$class_name][$cat_type] = $grade;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Grades</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        table, th, td {
            border: 1px solid black;
            padding: 10px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Your Grades</h2>

    <?php if (empty($grades)): ?>
        <p>No grades available at this time.</p>
    <?php else: ?>
        <?php foreach ($grades as $class_name => $cat_grades): ?>
            <h3><?php echo htmlspecialchars($class_name, ENT_QUOTES, 'UTF-8'); ?></h3>
            <table>
                <tr>
                    <th>CAT Type</th>
                    <th>Grade</th>
                </tr>

                <?php if (isset($cat_grades['CAT1'])): ?>
                    <tr>
                        <td>CAT1</td>
                        <td><?php echo htmlspecialchars($cat_grades['CAT1'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (isset($cat_grades['CAT2'])): ?>
                    <tr>
                        <td>CAT2</td>
                        <td><?php echo htmlspecialchars($cat_grades['CAT2'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                <?php endif; ?>

                <?php if (isset($cat_grades['CAT3'])): ?>
                    <tr>
                        <td>CAT3</td>
                        <td><?php echo htmlspecialchars($cat_grades['CAT3'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                <?php endif; ?>
            </table>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
