<?php
@include 'config.php';
session_start();
?>
<html>
  <head><title>Add classes</title></head>
  <body>
<h2>Add Class</h2>
<form action="admin_add_class.php" method="POST">
    <label>Class Name</label>
    <input type="text" name="class_name"><br>
    <label>Teacher </label>
    <select  name="teacher_id" placeholder="select teacher">
        <?php
        $query="SELECT id,name FROM user_form WHERE user_type='teacher'";
        $teacher=mysqli_query($conn,$query);
        while($row=mysqli_fetch_assoc($teacher)){
            echo"<option value='".$row['id']."'>".$row['name']."</option>";
        }
        ?>
    </select><br>
    <input type="submit" name="add_class" value="Add Class">
</form>
</body>
</html>
<?php 
if(isset($_POST['add_class'])){
  $class_name=$_POST['class_name'];
  $teacher_id=$_POST['teacher_id'];
  $insert="INSERT INTO CLASSES(class_name,teacher_id) VALUES('$class_name','$teacher_id')";
  if(mysqli_query($conn,$insert)){
    echo "class inserted successfully";
  }
  else{
    echo"Error".mysqli_error($conn);
  }
}
?>
