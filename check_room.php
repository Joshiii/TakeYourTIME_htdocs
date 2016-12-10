<?php
define('HOST','127.0.0.1');
define('USER','kidslear');
define('PASS','SxR3m246ts');
define('DB','kidslear_takeyourtime_db');
 
$con = mysqli_connect(HOST,USER,PASS,DB);


$wifi_mac = $_POST['WIFIMacAddress'];

$sql = "SELECT * FROM rooms_table WHERE RoomDeviceMac = '$wifi_mac'";
 
$res = mysqli_query($con,$sql);
 
$check = mysqli_fetch_array($res);
 
if(isset($check))
{
	echo $check[0].'SPLIT'.$check[1].'SPLIT'.$check[2].'SPLIT'.$check[3].'SPLIT'.$check[4];
}
else
{
	echo 'No Room Set';
}
mysqli_close($con);
?>
