<?php
define('HOST','127.0.0.1');
define('USER','kidslear');
define('PASS','SxR3m246ts');
define('DB','kidslear_takeyourtime_db');
 
$con = mysqli_connect(HOST,USER,PASS,DB);
 
$nfcserialno = $_POST['NFCSerialNumber'];
 
$sql = "SELECT * FROM systemusers_table WHERE NFCSerialNumber='$nfcserialno'";
 
$res = mysqli_query($con,$sql);
 
$check = mysqli_fetch_array($res);
 
if(isset($check)){
echo 'Login Success!SPLIT'.$check[5].'SPLIT'.$check[7];
}else{
echo 'Login Failed. Try Again.';
}
 
mysqli_close($con);
?>