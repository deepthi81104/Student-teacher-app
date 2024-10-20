<?php
session_start();
include 'config.php'; // DB connection

// Check if form data is submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and validate the class ID and other form inputs
    $class_id = isset($_POST['class_id']) ? $_POST['class_id'] : null;
    $student_ids = isset($_POST['student_ids']) ? $_POST['student_ids'] : null;
    $grades = isset($_POST['grades']) ? $_POST['grades'] : null;

    // Debug: Display the received data to check if they are properly passed
    echo "<pre>";
    echo "Class ID: " . htmlspecialchars($class_id, ENT_QUOTES, 'UTF-8') . "\n";
    echo "Student IDs: " . implode(", ", array_map('htmlspecialchars', $student_ids)) . "\n";
    echo "Grades: " . implode(", ", array_map('htmlspecialchars', $grades)) . "\n";
    echo "</pre>";

    // Check if the required data is available
    if ($class_id !== null && $student_ids !== null && $grades !== null) {
        // Prepare the insert statement
        $query = "INSERT INTO student_grades (student_id, class_id, grade) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);

        $successful_inserts = 0; // Counter for successful inserts
        $error_messages = []; // Store any error messages for invalid grades

        // Loop through student IDs and their corresponding grades
        foreach ($student_ids as $index => $student_id) {
            $grade = $grades[$index];

            // Validate that the grade is numeric
            if (!is_numeric($grade)) {
                $error_messages[] = "Grade for student ID $student_id is not valid: '$grade'. Please enter a numeric value.";
                continue; // Skip this iteration if the grade is invalid
            }

            // Bind parameters and execute the statement
            $stmt->bind_param("iis", $student_id, $class_id, $grade); // Assuming grade is a string (e.g., varchar)

            if ($stmt->execute()) {
                $successful_inserts++;
            } else {
                $error_messages[] = "Error inserting grade for student ID $student_id: " . $stmt->error;
            }
        }

        // Summary of inserts
        echo "<h2>Grades Submission Summary</h2>";
        echo "<p>Successfully saved grades for $successful_inserts students.</p>";

        if (!empty($error_messages)) {
            echo "<h3>Errors:</h3>";
            foreach ($error_messages as $message) {
                echo "<p style='color:red;'>$message</p>";
            }
        }
    } else {
        echo "<p style='color:red;'>Missing required data.</p>";
    }
} else {
    echo "<p style='color:red;'>No data submitted.</p>";
}
?>
