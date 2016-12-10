<?php
define('HOST','127.0.0.1');
define('USER','kidslear');
define('PASS','SxR3m246ts');
define('DB','kidslear_takeyourtime_db');
 
$con = mysqli_connect(HOST,USER,PASS,DB);

$sql = "SELECT * FROM rooms_table";
 
$res = mysqli_query($con,$sql);
 
$result = array();
 
while($row = mysqli_fetch_array($res)){
	array_push($result,
	array(
		'RoomID'=>$row[0],
		'RoomCode'=>$row[1],
		'RoomName'=>$row[2],
		'RoomDescription'=>$row[3],
		'RoomDeviceMAC'=>$row[4]
	));
}
 
echo json_encode(array("result"=>$result));
 
mysqli_close($con);
?>
