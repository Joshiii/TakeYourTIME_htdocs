<?php
define('HOST','127.0.0.1');
define('USER','kidslear');
define('PASS','SxR3m246ts');
define('DB','kidslear_takeyourtime_db');
 
$con = mysqli_connect(HOST,USER,PASS,DB);

$sql = "SELECT classes_table.ClassName, student_attendance_log_table.Status, student_attendance_log_table.Time, classes_table.Day FROM student_attendance_log_table LEFT JOIN classattendance_table ON student_attendance_log_table.AttendanceID = classattendance_table.AttendanceID LEFT JOIN classes_table ON classattendance_table.ClassID = classes_table.ClassID";
 
$res = mysqli_query($con,$sql);
 
$result = array();
 
while($row = mysqli_fetch_array($res)){
	array_push($result,
	array(
		'ClassName'=>$row[0],
		'AttendanceType'=>$row[1],
		'Time'=>$row[2],
		'Day'=>$row[3]
	));
}
 
echo json_encode(array("result"=>$result));
 
mysqli_close($con);
?>
