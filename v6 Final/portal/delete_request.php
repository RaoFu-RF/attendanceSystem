<?php
	require_once 'db_connect.php';
	$delete = $conn->query("DELETE FROM `emp_time_off` WHERE `request_id` = '".$_GET['request_id']."'") or die(mysqli_error());
	if($delete){
		echo json_encode(array("status"=>1,'msg'=>"Data successfully deleted."));
	} else {
		echo json_encode(array("status"=>2,'msg'=>"Error."));
	}
	$conn->close();