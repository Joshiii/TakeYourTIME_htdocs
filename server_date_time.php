<?php
define('HOST','127.0.0.1');
define('USER','kidslear');
define('PASS','SxR3m246ts');
define('DB','kidslear_takeyourtime_db');
 
$con = mysqli_connect(HOST,USER,PASS,DB);


$sql = "SELECT (CURRENT_TIMESTAMP) AS 'ServerDateTime' FROM serverdatetime_table";
 
$res = mysqli_query($con,$sql);
 
$check = mysqli_fetch_array($res);
 
if($check)
{
	echo $check[0];
}
mysqli_close($con);
?>
