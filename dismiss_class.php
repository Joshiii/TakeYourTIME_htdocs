<?php
define('HOST','127.0.0.1');
define('USER','kidslear');
define('PASS','SxR3m246ts');
define('DB','kidslear_takeyourtime_db');
 
$con = mysqli_connect(HOST,USER,PASS,DB);

/*$day = 'Monday';
$time = '14:57:17';
$room_id = 1;*/

$class_id = $_POST['ClassID'];
$date = $_POST['Date'];

$GetOngoingClass_QUERY = "SELECT * FROM classattendance_table WHERE ClassID = $class_id AND Date = '$date' AND Status != 'Dismissed'";

$GetOngoingClass_RESULT = mysqli_query($con,$GetOngoingClass_QUERY);

$GetOngoingClass_DATA = mysqli_fetch_array($GetOngoingClass_RESULT);

if($GetOngoingClass_DATA)
{
	$dismissclass_QUERY = "UPDATE classattendance_table SET Status = 'Dismissed' WHERE ClassID = $class_id AND Date = '$date'";

	$result = mysqli_query($con,$dismissclass_QUERY);

	if ($result)
	{
		$UpdateStudentAttendance_QUERY = "INSERT INTO classattendancestudents_table SELECT DISTINCT classattendance_table.AttendanceID, classstudents_table.StudentNumber, 'Absent', NULL FROM classstudents_table LEFT JOIN classattendance_table ON classstudents_table.ClassID = classattendance_table.ClassID LEFT JOIN classattendancestudents_table ON classstudents_table.StudentNumber = classattendancestudents_table.StudentNumber WHERE classattendance_table.Date = DATE_FORMAT(NOW(),'%Y-%m-%d') AND classattendancestudents_table.Remarks IS NULL AND classattendance_table.AttendanceID = $GetOngoingClass_DATA[0] AND classattendance_table.Status = 'Dismissed'";

		$UpdateStudentAttendance_RESULT = mysqli_query($con,$UpdateStudentAttendance_QUERY);

		echo 'Class Dismissed!';
	}
	else
	{
		echo 'Error';
	}
}
else
{
	echo 'There is no Class to dismiss!';
}


mysqli_close($con);


?>
