<?php
session_start();
include 'config.php'; // DB connection

// Check if class_id is provided
$class_id = isset($_GET['class_id']) ? $_GET['class_id'] : null;
if ($class_id === null) {
    echo "Class ID not provided.";
    exit;
}

// Fetch students enrolled in the class
$query = "
    SELECT u.id, u.name 
    FROM student_classes sc
    JOIN user_form u ON sc.student_id = u.id
    WHERE sc.class_id = '$class_id'
";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Grades</title>
</head>
<body>
    <h2>Input Grades for Class</h2>
    
    <form action="save_grades.php" method="POST">
        <input type="hidden" name="class_id" value="<?php echo htmlspecialchars($class_id, ENT_QUOTES, 'UTF-8'); ?>">

        <label>Select CAT:</label>
        <select name="cat_type" required>
            <option value="CAT1">CAT1</option>
            <option value="CAT2">CAT2</option>
            <option value="CAT3">CAT3</option>
        </select>
        <br>

        <table border="1">
            <tr>
                <th>Student Name</th>
                <th>Grade</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <?php
                // Check if the student already has a grade for the selected CAT
                $student_id = $row['id'];
                $cat_query = "
                    SELECT grade 
                    FROM student_grades 
                    WHERE student_id = '$student_id' AND class_id = '$class_id' AND cat_type = 'CAT1'"; // example, can be dynamic
                $cat_result = mysqli_query($conn, $cat_query);
                $existing_grade = mysqli_fetch_assoc($cat_result);

                // Prevent the warning by checking if $existing_grade is not null
                $grade_value = isset($existing_grade['grade']) ? $existing_grade['grade'] : null;
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                    <td>
                        <input type="hidden" name="student_ids[]" value="<?php echo htmlspecialchars($student_id, ENT_QUOTES, 'UTF-8'); ?>">
                        <input type="number" name="grades[]" placeholder="Enter grade" 
                               value="<?php echo htmlspecialchars($grade_value, ENT_QUOTES, 'UTF-8'); ?>" 
                               <?php echo ($grade_value !== null) ? 'readonly' : ''; ?>>
                        <?php if ($grade_value !== null): ?>
                            <span style="color: red;">Already exists (<?php echo $grade_value; ?>). Edit disabled.</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
        
        <input type="submit" value="Submit Grades">
    </form>
</body>
</html>
