<?php
	require_once 'db_connect.php';
	$accept = $conn->query("UPDATE emp_time_off set status = 'A' WHERE `request_id` = '".$_GET['request_id']."'") or die(mysqli_error());
	if($accept){
		echo json_encode(array("status"=>1,'msg'=>"Request successfully accepted."));
	} else {
		echo json_encode(array("status"=>2,'msg'=>"Error."));
	}
	$conn->close();