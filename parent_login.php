<?php
define('HOST','127.0.0.1');
define('USER','kidslear');
define('PASS','SxR3m246ts');
define('DB','kidslear_takeyourtime_db');
 
$con = mysqli_connect(HOST,USER,PASS,DB);
 
$studentnumber = $_POST['StudentNumber'];
 
$sql = "SELECT * FROM studentinformation_table WHERE StudentNumber = '$studentnumber'";
 
$res = mysqli_query($con,$sql);
 
$check = mysqli_fetch_array($res);
 
if(isset($check)){
echo 'Login Success!SPLIT'.$check['studentnumber'].'SPLIT'.$check['FirstName'].'SPLIT'.$check['LastName'].'SPLIT'.$check['Course'].'SPLIT'.$check['Year'].'SPLIT'.$check['Section'];
}else{
echo 'Login Failed. Try Again.';
}
 
mysqli_close($con);
?>