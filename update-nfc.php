<?php
define('HOST','127.0.0.1');
define('USER','kidslear');
define('PASS','SxR3m246ts');
define('DB','kidslear_takeyourtime_db');
 
$con = mysqli_connect(HOST,USER,PASS,DB);

/*$mac_address = '40:F3:08:74:97:A1';
$nfc_serial = '04ADCDC2C84880';*/
 
$mac_address = $_POST['DeviceMACAddress'];
$nfc_serial = $_POST['NFCSerialNumber'];

$checkConnectionExist_QUERY = "SELECT * FROM scannfc_table WHERE DeviceMACAddress = '$mac_address'";

$checkConnectionExist_RESULT = mysqli_query($con,$checkConnectionExist_QUERY);

$checkConnectionExist_DATA = mysqli_fetch_array($checkConnectionExist_RESULT);

$sqlQuery = "";

if ($checkConnectionExist_DATA)
{
	$sqlQuery = "UPDATE scannfc_table SET NFCSerialNumberScanned = '$nfc_serial' WHERE DeviceMACAddress = '$mac_address'";
}
else
{
	$sqlQuery = "INSERT INTO scannfc_table (DeviceMACAddress, NFCSerialNumberScanned) VALUES ('$mac_address', '$nfc_serial')";
}
 
if(mysqli_query($con,$sqlQuery))
{
	echo 'Read Success';
}
 else
 {
	echo 'Read Failed';
}
mysqli_close($con);
?>