<?php
include 'db_connect.php';
	extract($_POST);
	$data = array();
	date_default_timezone_set("America/Los_Angeles");
	$timeInfo = date("H:i:s"); //current time
	$dateInfo = date("Y-m-d"); //current date

	if($status == '0') {   //0 means the user not clock in yet
		//when the user click 'clock in' button
		$update = $conn->query("UPDATE attendance set `status` = 1, dateInfo = '$dateInfo', timeInfo = '$timeInfo' WHERE id = '$id'");
		$save = $conn->query("INSERT INTO timesheet (id, firstname, lastname, dateInfo, timein, shift) values ('$id','$firstname','$lastname','$dateInfo','$timeInfo','$shift')");
		if($save){
			$data['status'] = 1;
			$data['msg'] = "You're now clocked in.";
		} else {
			$data ['status'] = 2;
			$data['msg'] = 'Error.';
		}
	} elseif ($status == '1') {   //1 means the user already clocked in
		$save = $conn->query("UPDATE attendance set `status` = 0 WHERE id = '$id'");
		$user_qry=$conn->query("SELECT * FROM attendance WHERE `id` = '$id'" ) or die(mysqli_error());
		while($row=$user_qry->fetch_array()){
			$timein = $row['timeInfo'];
			$datein = $row['dateInfo'];
		}
		$update = $conn->query("UPDATE timesheet set `timeout` = '$timeInfo', sick = 0, vacation = 0, ot = 0 WHERE id = '$id' AND dateInfo = '$datein' AND timein = '$timein'");
		if($update){
			$data['status'] = 1;
			$data['msg'] = "You're now clocked out.";
		} else {
			$data ['status'] = 2;
			$data['msg'] = 'Error.';
		}
	}
	echo json_encode($data);
	$conn->close();