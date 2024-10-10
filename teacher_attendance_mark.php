<?php
session_start();
@include 'config.php';
$class_id=$_POST['class_id'];
$query="SELECT id, name FROM user_form u JOIN student_classes sc ON sc.student_id=u.id  WHERE sc.class_id = '$class_id'";
$students=mysqli_query($conn,$query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark attendance</title>
</head>
<body>
    <h1>Mark Attendance for class </h1>
    <form method="POST" action="">
        <input type="hidden"  name="class_id" value="<?= $class_id;?>">
        <label>Date</label>
        <input type="date" name="attendance_date">
        <?php
         while($row = mysqli_fetch_assoc($students)){
          echo "<label>".$row['name'].":</label>";
          echo "<input type='radio' name= 'attendance[".$row['id']."]' value= 'Present'> Present";
         echo "<input type='radio' name= 'attendance[".$row['id']."]' value= 'Absent'> Absent<br>";
         }
        ?><br>
        <input type="submit"   name="submit_attendance" value="submit attendance">
    </form>
</body>
</html>
<?php
 if(isset($_POST['submit_attendance'])){
    $attendance_date=$_POST['attendance_date'];
    $attendance=$_POST['attendance'];
    foreach($attendance as $student_id=>$status){
        $insert="INSERT INTO attendance (student_id,class_id,date,status) VALUES ('$student_id', '$class_id', '$attendance_date','$status')";
        mysqli_query($conn,$insert);
    }
}
?>