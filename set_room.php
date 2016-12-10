<?php
define('HOST','127.0.0.1');
define('USER','kidslear');
define('PASS','SxR3m246ts');
define('DB','kidslear_takeyourtime_db');
 
$con = mysqli_connect(HOST,USER,PASS,DB);


$wifi_mac = $_POST['WIFIMacAddress'];
$room_id = $_POST['RoomID'];

$sql = "UPDATE rooms_table SET RoomDeviceMac = '$wifi_mac' WHERE RoomID = $room_id";
 
$res = mysqli_query($con,$sql);
 
 
if($res)
{
	$sql = "UPDATE rooms_table SET RoomDeviceMac = 'No Device Set' WHERE RoomDeviceMac = '$wifi_mac'";
 
	$res = mysqli_query($con,$sql);
	
	if($res)
	{
		$sql = "UPDATE rooms_table SET RoomDeviceMac = '$wifi_mac' WHERE RoomID = $room_id";
	 
		$res = mysqli_query($con,$sql);
		echo 'Success';
	}
	else
	{
		echo 'Failed';
	}
}
else
{
	echo 'Failed';
}
mysqli_close($con);
?>
