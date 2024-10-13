<?php 
session_start();
@include 'config.php';
$teacher_id=$_SESSION['teacher_id'];
$query="SELECT class_id, class_name FROM classes WHERE teacher_id='$teacher_id'";
$result=mysqli_query($conn,$query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   <h2>POST ASSIGNMENT</h2> 
    <form action="teacher_assignment.php" method="post"  enctype="multipart/form-data">
    <label>Class</label>
    <select name="class_id">
        <option value="">Select a class</option>
        <?php
         while($row=mysqli_fetch_assoc($result)){
            echo "<option value='".$row['class_id']."'>".$row['class_name']."</option>";
            echo "<input type='hidden' name='class_name' value='".$row['class_name']."' >";
         }
        ?>
    </select><br>
    <label >Assignment Name:</label>
    <input type="text" name="assignment_name"><br>

    <label for="description">Description:</label>
    <textarea name="description" ></textarea><br>

    <label for="assignment_file">Upload Assignment File:</label>
    <input type="file" name="assignment_file" ><br>

    <input type="submit" name="submit_assignment" value="Post Assignment">
</form>
</body>
</html>
<?php 
if(isset($_POST['submit_assignment'])){
    $name=$_POST['assignment_name'];
    $description=$_POST['description'];
   $class_name=$_POST['class_name'];
   $file_name=$_FILES['assignment_file']['name'];
   $file_temp=$_FILES['assignment_file']['tmp_name'];
   $upload_dir="assignments/class_$class_name/";
   if(!is_dir($upload_dir)){
    mkdir($upload_dir,0777,true);
   }
   $destination=$upload_dir.$file_name;
   if(move_uploaded_file($file_temp,$destination)){
    echo "Assignment '$name' uploaded successfully";
   }
    else{
        echo "failed to upload";
    }
}

?>