<?php
	require_once 'db_connect.php';
	$delete = $conn->query("DELETE FROM `users` WHERE `id` = '".$_GET['id']."'") or die(mysqli_error());
	if($delete){
		echo json_encode(array("status"=>1,'msg'=>"Data successfully deleted."));
	} else {
		echo json_encode(array("status"=>2,'msg'=>"Error."));
	}
	$conn->close();