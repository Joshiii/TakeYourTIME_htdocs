<?php
define('HOST','127.0.0.1');
define('USER','kidslear');
define('PASS','SxR3m246ts');
define('DB','kidslear_takeyourtime_db');
 
$con = mysqli_connect(HOST,USER,PASS,DB);

/*$day = 'Monday';
$time = '14:57:17';
$room_id = 1;*/

$day = $_POST['Day'];
$date= $_POST['Date'];
$time = $_POST['Time'];
$room_id = $_POST['RoomID'];

//if ($day != "Sunday")
//{
	$updateNotOngoingClassesQuery = "UPDATE classattendance_table LEFT JOIN classes_table ON classattendance_table.ClassID = classes_table.ClassID SET classattendance_table.Status = 'Dismissed' WHERE classes_table.EndTime <= '$time' AND classattendance_table.Status != 'Canceled' AND classattendance_table.Day = '$day' AND classes_table.RoomID = $room_id";

	$result = mysqli_query($con,$updateNotOngoingClassesQuery);

	/*$updateNotOngoingClassesStudentAttendanceQuery = "INSERT INTO classattendancestudents_table SELECT DISTINCT classattendance_table.AttendanceID, classstudents_table.StudentNumber, 'Absent', NULL FROM classstudents_table LEFT JOIN classattendance_table ON classstudents_table.ClassID = classattendance_table.ClassID LEFT JOIN classattendancestudents_table ON classstudents_table.StudentNumber = classattendancestudents_table.StudentNumber LEFT JOIN classes_table ON classattendance_table.ClassID = classes_table.ClassID WHERE classattendance_table.Date = DATE_FORMAT(NOW(),'%Y-%m-%d') AND classattendancestudents_table.Remarks IS NULL AND classes_table.Day = '$day' AND classes_table.RoomID = '$room_id' AND classattendance_table.Status = 'Dismissed'";

	$result = mysqli_query($con,$updateNotOngoingClassesStudentAttendanceQuery);*/

	$sql = "SELECT * FROM classes_table WHERE Day = '$day' AND RoomID = $room_id AND StartTime <= '$time' AND EndTime >= '$time'";
 
	$res = mysqli_query($con,$sql);
	 
	$check = mysqli_fetch_array($res);
	 
	if($check)
	{
		$sql2 = "SELECT * FROM teacherinformation_table WHERE NFCSerialNumber = '$check[2]'";
	 
		$res2 = mysqli_query($con,$sql2);
		 
		$check2 = mysqli_fetch_array($res2);
		
		if($check2)
		{
			if ($check2['Gender'] == 'Male')
			{
				echo 'Mr. '.$check2['LastName'].'SPLIT'.$check['ClassName'].'SPLIT'.$check['ClassID'];
			}
			else
			{
				echo 'Ms. '.$check2['LastName'].'SPLIT'.$check['ClassName'].'SPLIT'.$check['ClassID'];
			}
		}
		else
		{
			echo 'No Ongoing Class';
		}
	}
	else
	{
		echo 'No Ongoing Class';
	}

	$sql = "SELECT * FROM classes_table WHERE Day = '$day' AND RoomID = $room_id AND StartTime <= '$time' AND EndTime >= '$time'";
 
	$res = mysqli_query($con,$sql);
	 
	$check = mysqli_fetch_array($res);

	mysqli_close($con);
/*}
else
{
	echo "It's Sunday";
}*/


?>
