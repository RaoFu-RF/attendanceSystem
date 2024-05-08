<?php
	require_once 'db_connect.php';
	$decline = $conn->query("UPDATE emp_time_off set status = 'D' WHERE `request_id` = '".$_GET['request_id']."'") or die(mysqli_error());
	if($decline){
		echo json_encode(array("status"=>1,'msg'=>"Request successfully declined."));
	} else {
		echo json_encode(array("status"=>2,'msg'=>"Error."));
	}
	$conn->close();