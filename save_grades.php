<?php
session_start();
include 'config.php'; // DB connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class_id = $_POST['class_id'];
    $student_ids = $_POST['student_ids'];
    $grades = $_POST['grades'];
    $cat_type = $_POST['cat_type']; // Get CAT type from form

    foreach ($student_ids as $index => $student_id) {
        $grade = $grades[$index];

        // Validate that the grade is a numeric value
        if (!is_numeric($grade)) {
            echo "Grade for student ID $student_id is not valid: '$grade'. Please enter a numeric value.";
            continue;
        }

        // Check if a grade already exists for this student, class, and CAT type
        $check_query = "
            SELECT * FROM student_grades 
            WHERE student_id = '$student_id' 
            AND class_id = '$class_id' 
            AND cat_type = '$cat_type'
        ";
        $check_result = mysqli_query($conn, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            echo "Grade for student ID $student_id for CAT $cat_type already exists. Do you want to edit it?";
        } else {
            // Insert the new grade
            $insert_query = "
                INSERT INTO student_grades (student_id, class_id, cat_type, grade) 
                VALUES ('$student_id', '$class_id', '$cat_type', '$grade')
            ";
            if (mysqli_query($conn, $insert_query)) {
                echo "Grade inserted successfully for student ID $student_id.<br>";
            } else {
                echo "Error inserting grade for student ID $student_id.<br>";
            }
        }
    }
}
?>
