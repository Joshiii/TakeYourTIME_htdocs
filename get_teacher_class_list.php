<?php
define('HOST','127.0.0.1');
define('USER','kidslear');
define('PASS','SxR3m246ts');
define('DB','kidslear_takeyourtime_db');
 
$con = mysqli_connect(HOST,USER,PASS,DB);

$sql = $_POST['SelectQuery'];

/*$sql = "SELECT classes_table.ClassID, ".
			  "classes_table.ClassName, ".
			  "classes_table.NFCSerialNumber, ".
			  "subjects_table.SubjectID, ". 
			  "subjects_table.SubjectCode, ".
			  "rooms_table.RoomID, ".
			  "rooms_table.RoomCode, ".
			  "classes_table.Day, ".
			  "classes_table.StartTime, ".
			  "classes_table.EndTime ".
			  "COUNT(classstudents_table.StudentNumber) AS 'ClassTotalStudents' ".
	   "FROM classes_table ".
	   "LEFT JOIN rooms_table ".
	   "ON classes_table.RoomID = rooms_table.RoomID ".
	   "LEFT JOIN subjects_table ".
	   "ON classes_table.SubjectID = subjects_table.SubjectID ".
	   "LEFT JOIN classstudents_table ".
	   "ON classes_table.ClassID = classstudents_table.ClassID "
	   "WHERE NFCSerialNumber = '$nfcserialno'";*/
 
$res = mysqli_query($con,$sql);
 
$result = array();
 
while($row = mysqli_fetch_array($res)){
	array_push($result,
	array(
		'ClassID'=>$row[0],
		'ClassName'=>$row[1],
		'NFCSerialNumber'=>$row[2],
		'SubjectID'=>$row[3],
		'SubjectCode'=>$row[4],
		'RoomID'=>$row[5],
		'RoomCode'=>$row[6],
		'Day'=>$row[7],
		'StartTime'=>$row[8],
		'EndTime'=>$row[9],
		'ClassTotalStudents'=>$row[10]
	));
}
 
echo json_encode(array("result"=>$result));
 
mysqli_close($con);
?>
