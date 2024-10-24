<?php 
session_start();
@include 'config.php';
$student_id=$_SESSION['student_id'];
$query= "SELECT c.class_id,c.class_name FROM classes c JOIN  student_classes sc ON c.class_id=sc.class_id WHERE sc.student_id='$student_id'";
$classes=mysqli_query($conn,$query);
if(mysqli_num_rows($classes)>0){
     while($row=mysqli_fetch_assoc($classes)){
        $class_id=$row['class_id'];
        $class_name=$row['class_name'];
        $assignment_dir="assignments/class_$class_name/";

        echo "<h2>Assignments for Class: $class_name</h2>";


       if(is_dir($assignment_dir)){
        $assignments=scandir($assignment_dir);
        if(count($assignments)>2){
            foreach($assignments as $file){
                if($file!='.' && $file!='..'){
                    echo"<p><strong>Download assignment :</p></strong><a href='$assignment_dir$file'download>View Assignment</a></p>";
                }
            }
        }
        else{
            echo "<p>No assignments posted for this class</p>";
        }
       } else{
            echo "<p>No assignments for this class</p>";
       }
     }
}
else{
    echo "<p>You are not enrolled in any class</p>";
}
mysqli_data_seek($classes, 0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Assignment Submission</title>
</head>
<body>
    <h2>Submit your work</h2>
    <form action="student_assignment.php" method="POST"  enctype="multipart/form-data">
        <label>Select class</label>
        <select name="class_id">
            <?php 
            while($row=mysqli_fetch_assoc($classes)){
               echo"<option value='".$row['class_id']."'>".$row['class_name']."</option>";
               echo "<input type='hidden' name='class_name' value='".$row['class_name']."'";
            }
            
            ?>
        </select><br>
        <label>Upload file</label>
        <input type="file" name="submit_file"><br>
        <input type="submit" name="submit_work" value="submit assignment"> 
    </form>
</body>
</html>
<?php 
if(isset($_POST['submit_work'])){
   $class_name=$_POST['class_name'];
   $upload_dir="submissions/class_$class_name/";

if(!is_dir($upload_dir)){
    mkdir($upload_dir,0777,true);
}
$file_name=$_FILES['submit_file']['name'];
$file_path=$_FILES['submit_file']['tmp_name'];
$new_file_name = "stud_id_".$student_id."_".$file_name; 
$destination=$upload_dir.$new_file_name;
if(move_uploaded_file($file_path,$destination)){
    echo "<p>Assignments submitted successfully!</p>";
}
else {
    echo "<p>Failed to submit assignment. Please try again.</p>";
}
}
?>