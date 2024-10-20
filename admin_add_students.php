<?php
  @include 'config.php';
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add students</title>
</head>
<body>
    <h2>Add Students</h2> 
    <form action="admin_add_students.php" method="POST">
        <label>Select Class:</label>
        <select name="class_id">
        <?php
      $student="SELECT id,name FROM user_form WHERE user_type='student'";
      $class="SELECT class_id,class_name FROM classes";
      $class_res=mysqli_query($conn,$class);
      while($row=mysqli_fetch_assoc($class_res)){
        echo "<option value='".$row['class_id']."'>".$row['class_name']."</option>";
      }
      ?>
        </select>
        <br>
        <label>Select Students:</label>
         <?php
          $stud_res=mysqli_query($conn,$student);
          while($row=mysqli_fetch_assoc($stud_res)){
            echo"<input type='checkbox' name='student_ids[]' value='".$row['id']."'>".$row['name']."<br>";
          }
         ?>
         <input type="submit"  name="enroll_students" value="Enroll Students">
    </form>
    <?php
       if(isset($_POST['enroll_students'])){
        if (isset($_POST['student_ids']) && is_array($_POST['student_ids'])) {
        $student_ids=$_POST['student_ids'];
        $class_id=$_POST['class_id'];
        foreach($student_ids as $student_id){
          $query="INSERT INTO student_classes (student_id,class_id) VALUES('$student_id','$class_id')";
          if(mysqli_query($conn,$query)){
            echo "Students enrolled successfully";
          }
       else{
             echo "error inserting";
          }
        }
      }
       }
    ?>
</body>
</html>