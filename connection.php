<?php
define('HOST','127.0.0.1');
define('USER','kidslear');
define('PASS','SxR3m246ts');
define('DB','kidslear_takeyourtime_db');
 
$con = mysqli_connect(HOST,USER,PASS,DB);

if (!$con){
	echo 'Connection Failed';
}
else{
	echo 'Connection Successfully Established';
}
?>