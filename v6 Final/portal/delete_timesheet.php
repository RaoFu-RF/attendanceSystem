<?php
	require_once 'db_connect.php';
	extract($_POST);
	$delete = $conn->query("DELETE FROM `timesheet` WHERE `id` = '$id' AND `dateInfo` = '$dateInfo' AND `timein` = '$timein' AND `timeout` = '$timeout'") or die(mysqli_error());
	if($delete){
		echo json_encode(array("status"=>1,'msg'=>"Data successfully deleted."));
	} else {
		echo json_encode(array("status"=>2,'msg'=>"Error."));
	}
	$conn->close();