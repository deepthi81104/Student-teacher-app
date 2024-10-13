<?php 
session_start();
@include 'config.php';
$query = "SELECT c.class_id, c.class_name, u.name AS teacher_name FROM classes c 
          JOIN user_form u ON c.teacher_id = u.id";
$classes = mysqli_query($conn, $query);


$class_studs = "SELECT sc.class_id, u.id, u.name 
                FROM student_classes sc 
                JOIN user_form u ON sc.student_id = u.id";
$query_studs = mysqli_query($conn, $class_studs);

$class_students = [];
while($row = mysqli_fetch_assoc($query_studs)) {
    $class_students[$row['class_id']][] = ['id' => $row['id'], 'name' => $row['name']];
}
?>

<h2>Manage Classes and Students</h2>

<?php while ($row = mysqli_fetch_assoc($classes)): ?>
    <h3><?php echo $row['class_name']; 
    echo "<br>"?> 
     Teacher: <?php echo $row['teacher_name']; ?></h3>
    <table border="1">
        <tr>
            <th>Students</th>
            <th>Actions</th>
        </tr>
        <?php 
       
        if (!empty($class_students[$row['class_id']])) {
            foreach ($class_students[$row['class_id']] as $student): ?>
                <tr>
                    <td><?php echo $student['name']; ?></td>
                    <td>
                     
                        <form method="POST" action="admin_management.php" style="display:inline;">
                            <input type="hidden" name="class_id" value="<?php echo $row['class_id']; ?>">
                            <input type="hidden" name="student_id" value="<?php echo $student['id']; ?>">
                            <input type="submit" name="remove_student" value="Remove">
                        </form>
                    </td>
                </tr>
            <?php endforeach; 
        } else { ?>
            <tr>
                <td colspan="2">No students enrolled.</td>
            </tr>
        <?php } ?>
    </table>


    <form method="POST" action="admin_management.php" style="margin-top: 10px;">
        <input type="hidden" name="class_id" value="<?php echo $row['class_id']; ?>">
        <input type="submit" name="delete_class" value="Delete Class">
    </form>
    <br>
<?php endwhile; ?>

<?php

if (isset($_POST['remove_student'])) {
    $class_id = $_POST['class_id'];
    $student_id = $_POST['student_id'];
    
    $query = "DELETE FROM student_classes WHERE student_id = '$student_id' AND class_id = '$class_id'";
    if (mysqli_query($conn, $query)) {
        echo "Student removed successfully.";
    } else {
        echo "Error removing student: " . mysqli_error($conn);
    }
}

if (isset($_POST['delete_class'])) {
    $class_id = $_POST['class_id'];
   
    $query_students = "DELETE FROM student_classes WHERE class_id = '$class_id'";
    mysqli_query($conn, $query_students);
    
    $query_class = "DELETE FROM classes WHERE class_id = '$class_id'";
    if (mysqli_query($conn, $query_class)) {
        echo "Class deleted successfully.";
    } else {
        echo "Error deleting class: " . mysqli_error($conn);
    }
}
?>
