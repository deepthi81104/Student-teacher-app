<?php
@include 'config.php';
session_start();
$student_id=$_SESSION['student_id'];
$query="SELECT c.class_name,a.date,a.status FROM attendance a JOIN classes c ON a.class_id = c.class_id  WHERE  a.student_id='$student_id'";
$attendance=mysqli_query($conn,$query);
$current_class=null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>view attendance</title>
</head>
<body>
    <h2>Your attendance</h2>
    <?php 
    if (mysqli_num_rows($attendance) > 0) {
        while ($row = mysqli_fetch_assoc($attendance)) {
            if ($row['class_name'] !== $current_class) {
                // Close previous table if there was one
                if ($current_class !== null) {
                    echo "</table><br>";
                }
                
                // Set the new current class and start a new table
                $current_class = $row['class_name'];
                echo "<h3>Class: " . $current_class . "</h3>";
                echo "<table border='1'>
                        <tr>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>";
            }
    
            // Display the attendance record for the current row
            echo "<tr>
                    <td>" . $row['date'] . "</td>
                    <td>" . $row['status'] . "</td>
                  </tr>";
        }
    
        // Close the last table
        echo "</table>";
    } 
    ?>
</body>
</html>