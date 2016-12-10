<?php
define('HOST','127.0.0.1');
define('USER','kidslear');
define('PASS','SxR3m246ts');
define('DB','kidslear_takeyourtime_db');
 
$con = mysqli_connect(HOST,USER,PASS,DB);


$nfcserialno = $_POST['NFCSerialNumber'];
$day = $_POST['Day'];
$time = $_POST['Time'];
$room_id = $_POST['RoomID'];
$date =  $_POST['Date'];

/*$nfcserialno = '04B3CDC2C84880';
$day = 'Monday';
$time = '03:12:49';
$room_id = 1;
$date = '2016-09-19'*/

//if ($day != "Sunday")
//{
	if (isset($nfcserialno))
	{
		$roomsql = "SELECT * FROM rooms_table WHERE RoomID = $room_id";

		$roomsqlResult = mysqli_query($con,$roomsql);

		$checkroomresult = mysqli_fetch_array($roomsqlResult);

		if ($checkroomresult)
		{
			if ($checkroomresult[1] == 'ENTRANCE')
			{
				$sql = "SELECT * FROM studentinformation_table WHERE NFCSerialNumber = '$nfcserialno'";
	 
				$res = mysqli_query($con,$sql);
				 
				$check = mysqli_fetch_array($res);

				if ($check)
				{
					$readstudentattendancequery = "SELECT * FROM schoolentrancelog_table WHERE NFCSerialNumber = '$nfcserialno' AND Date = '$date' ORDER BY SchoolAttendanceLogID DESC";
	 
					$readstudentattendancequeryresult = mysqli_query($con,$readstudentattendancequery);
					 
					$checkreadstudentattendancequerydata = mysqli_fetch_array($readstudentattendancequeryresult);

					if ($checkreadstudentattendancequerydata)
					{
						if ($checkreadstudentattendancequerydata[4] == 'Inside')
						{
							$sql = "INSERT INTO schoolentrancelog_table (NFCSerialNumber, Time, Date, Status) VALUES ('$nfcserialno', '$time', '$date', 'Outside')";
							$result = mysqli_query($con,$sql);
				 
							if ($result)
							{
								echo 'Success';
							}
							else
							{
								echo 'Error';
							}
						}
						else
						{
							$sql = "INSERT INTO schoolentrancelog_table (NFCSerialNumber, Time, Date, Status) VALUES ('$nfcserialno', '$time', '$date', 'Inside')";
							$result = mysqli_query($con,$sql);
				 
							if ($result)
							{
								echo 'Success';
							}
							else
							{
								echo 'Error';
							}
						}
					}
					else
					{
						$sql = "INSERT INTO schoolentrancelog_table (NFCSerialNumber, Time, Date, Status) VALUES ('$nfcserialno', '$time', '$date', 'Inside')";
						$result = mysqli_query($con,$sql);
			 
						if ($result)
						{
							echo 'Success';
						}
						else
						{
							echo 'Error';
						}
					}
				}
				else
				{
					$sql = "SELECT * FROM systemusers_table WHERE NFCSerialNumber = '$nfcserialno'";
			 
					$res = mysqli_query($con,$sql);
					 
					$check = mysqli_fetch_array($res);

					if ($check)
					{
						echo $check[3].'SPLIT'.$nfcserialno.'SPLIT'.$check[2].'SPLIT'.$check[5].'SPLIT'.$check[7];
					}
					else
					{
						$sql2 = "SELECT * FROM teacherinformation_table WHERE NFCSerialNumber = '$nfcserialno'";
			 
						$res2 = mysqli_query($con,$sql2);
						 
						$check2 = mysqli_fetch_array($res2);

						if($check2)
						{
							echo 'TeacherSPLIT'.$nfcserialno.'SPLIT'.$check2[4].'SPLIT'.$check2[6];
						}
						else
						{
							echo 'Card not Recognized!';
						}
					}
				}
			}
			else
			{
				$sql = "SELECT * FROM teacherinformation_table WHERE NFCSerialNumber = '$nfcserialno'";
	 
				$res = mysqli_query($con,$sql);
				 
				$check = mysqli_fetch_array($res);
				 
				if($check)
				{
					//$GetClassIDQuery = "SELECT * FROM classes_table WHERE RoomID = $room_id AND Day = '$day' AND StartTime <= '$time' AND EndTime >= '$time' AND '$time' BETWEEN DATE_ADD(EndTime,INTERVAL -30 MINUTE) AND EndTime";

					$GetClassIDQuery = "SELECT * FROM classes_table WHERE RoomID = $room_id AND Day = '$day' AND StartTime <= '$time' AND EndTime >= '$time'";
					
					$res2 = mysqli_query($con,$GetClassIDQuery);
				 
					$ClassInfoData = mysqli_fetch_array($res2);
					
					if ($ClassInfoData)
					{

						$AttendanceID = "SELECT * FROM classattendance_table WHERE ClassID = $ClassInfoData[0] AND Day = '$day' AND Date = '$date'";
						
						$res4 = mysqli_query($con,$AttendanceID);
				 
						$check4 = mysqli_fetch_array($res4);
					
						if (!$check4)
						{
							$InsertNewAttendance = "INSERT INTO classattendance_table (ClassID, Day, Date, Status) VALUES ($ClassInfoData[0],'$day','$date','Ongoing')";
					
							$InsertNewAttendanceResult = mysqli_query($con,$InsertNewAttendance);
							
							if ($InsertNewAttendanceResult)
							{
					
								$res4 = mysqli_query($con,$AttendanceID);
						 
								$check4 = mysqli_fetch_array($res4);
							}
						}

						if ($check4[4] == 'Ongoing')
						{
							$StudentAttendace = "SELECT * FROM classattendanceteacher_table WHERE AttendanceID = $check4[0] AND NFCSerialNumber = '$check[0]'";
						
							$res5 = mysqli_query($con,$StudentAttendace);
					 
							$check5 = mysqli_fetch_array($res5);
							
							$InsertQuery = "";
							
							if ($check5)
							{
								$CheckIFLessThan30_QUERY = "SELECT * FROM classes_table WHERE ClassID = ".$ClassInfoData[0]." AND '$time' BETWEEN DATE_ADD(EndTime,INTERVAL -30 MINUTE) AND EndTime";

								$CheckIFLessThan30_RESULT = mysqli_query($con,$CheckIFLessThan30_QUERY);
						 
								$CheckIFLessThan30_DATA = mysqli_fetch_array($CheckIFLessThan30_RESULT);

								if($CheckIFLessThan30_DATA)
								{
									$UpdateQuery = "";
								
									if ($check5[3] == 'In')
									{
										$InsertQuery = "UPDATE teacher_attendance_log_table SET TimeOut = '$time' WHERE AttendanceID = $check4[0] AND NFCSerialNumber = '$check[0]'";
									}
									else
									{
										$InsertQuery = "INSERT INTO teacher_attendance_log_table VALUES ($check4[0],'$check[0]','$time','In')";
									}
									
							
									$qresult = mysqli_query($con,$InsertQuery);
							 
									if ($qresult)
									{
										
										if ($check5[3] == 'In')
										{
											$UpdateQuery = "UPDATE classattendanceteacher_table SET Status = 'Out', Remarks = 'Present' WHERE AttendanceID = $check4[0] AND NFCSerialNumber = '$check[0]'";

											$qresult2 = mysqli_query($con,$UpdateQuery);
										
											if ($qresult2)
											{
												echo 'OutSPLIT'.$check[0].'SPLIT'.$check[1].'SPLIT'.$check[2].'SPLIT'.$check[4].'SPLIT'.$check[5].'SPLIT'.$time;
											}
											else
											{
												echo 'Error';
											}
										}
										else
										{
											echo 'You already timed out';
										}
									}
									else
									{
										echo 'Error';
									}
								}
								else
								{
									echo 'You are not allowed to time out';
								}
							}
							else
							{
								$CheckIFLessThan15_QUERY = "SELECT * FROM classes_table WHERE ClassID = ".$ClassInfoData[0]." AND '$time' BETWEEN DATE_ADD(StartTime,INTERVAL 15 MINUTE) AND StartTime";

								$CheckIFLessThan15_RESULT = mysqli_query($con,$CheckIFLessThan15_QUERY);
						 
								$CheckIFLessThan15_DATA = mysqli_fetch_array($CheckIFLessThan15_RESULT);

								if ($CheckIFLessThan15_DATA)
								{
									$InsertQuery = "INSERT INTO classattendanceteacher_table (AttendanceID, NFCSerialNumber, Remarks, Status) VALUES ($check4[0],'$check[0]','Present','In')";

									$qresult = mysqli_query($con,$InsertQuery);
									if ($qresult)
									{
										$InsertQuery2 = "INSERT INTO teacher_attendance_log_table VALUES ($check4[0],'$check[0]','$time','In')";
										$qresult2 = mysqli_query($con,$InsertQuery2);
										
										if ($qresult2)
										{
											echo 'FirstInSPLIT'.$check[0].'SPLIT'.$check[1].'SPLIT'.$check[2].'SPLIT'.$check[4].'SPLIT'.$check[5].'SPLIT'.$time;
										}
										else
										{
											echo 'Error';
										}
									}
									else
									{
										echo 'Error';
									}
								}
								else
								{
									$InsertQuery = "INSERT INTO classattendanceteacher_table (AttendanceID, NFCSerialNumber, Remarks, Status) VALUES ($check4[0],'$check[0]','Late','In')";

									$qresult = mysqli_query($con,$InsertQuery);
									if ($qresult)
									{
										$InsertQuery2 = "INSERT INTO teacher_attendance_log_table VALUES ($check4[0],'$check[0]','$time','In')";
										$qresult2 = mysqli_query($con,$InsertQuery2);
										
										if ($qresult2)
										{
											echo 'FirstInSPLIT'.$check[0].'SPLIT'.$check[1].'SPLIT'.$check[2].'SPLIT'.$check[4].'SPLIT'.$check[5].'SPLIT'.$time;
										}
										else
										{
											echo 'Error';
										}
									}
									else
									{
										echo 'Error';
									}
								}
							}
						}
						else if ($check4[4] == 'Canceled')
						{
							echo "Class '".$ClassInfoData[1]."' was Canceled.";
						}
						else if ($check4[4] == 'Dismissed')
						{
							echo "Class '".$ClassInfoData[1]."' was already Dismissed.";
						}
					}
					else
					{
						echo 'There are no class in this room';
					}
				}
				else
				{
					$sql = "SELECT * FROM systemusers_table WHERE NFCSerialNumber = '$nfcserialno'";
			 
					$res = mysqli_query($con,$sql);
					 
					$check = mysqli_fetch_array($res);

					if ($check)
					{
						echo $check[3].'SPLIT'.$nfcserialno.'SPLIT'.$check[2].'SPLIT'.$check[5].'SPLIT'.$check[7];
					}
					else
					{
						$sql2 = "SELECT * FROM teacherinformation_table WHERE NFCSerialNumber = '$nfcserialno'";
			 
						$res2 = mysqli_query($con,$sql2);
						 
						$check2 = mysqli_fetch_array($res2);

						if($check2)
						{
							echo 'TeacherSPLIT'.$nfcserialno.'SPLIT'.$check2[4].'SPLIT'.$check2[6];
						}
						else
						{
							echo 'Card not Recognized!';
						}
					}
				}
			}
		}
		mysqli_close($con);
	}
/*}
else
{
	//echo "It's Sunday!";

	$sql = "SELECT * FROM systemusers_table WHERE NFCSerialNumber = '$nfcserialno'";
			 
	$res = mysqli_query($con,$sql);
	 
	$check = mysqli_fetch_array($res);

	if ($check)
	{
		echo $check[3].'SPLIT'.$nfcserialno.'SPLIT'.$check[2].'SPLIT'.$check[5].'SPLIT'.$check[7];
	}
	else
	{
		echo '';
	}
}*/

?>