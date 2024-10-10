<?php
@include 'config.php';
session_start();
$teacher_id= $_SESSION['teacher_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
    <?php
      $query="SELECT class_id,class_name FROM classes WHERE teacher_id='$teacher_id'" ;
      $select=mysqli_query($conn,$query);
    ?>
    <form action="teacher_attendance_mark.php" method="POST">
    <h2>Select Class</h2>
    <select name="class_id" id="class_id">
    <?php
      while($row=mysqli_fetch_assoc($select)){
        echo"<option value='" .$row['class_id']."'>" .$row['class_name']."</option>";
      }
      ?>
      </select><br>
      <input type="submit"  value="Mark Attendance">
      </form>
</body>
</html>