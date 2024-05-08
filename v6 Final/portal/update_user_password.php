<?php
	require_once 'db_connect.php';
	extract($_POST);
	$data = array();	
	$password = md5($password);

	$save=$conn->query("UPDATE users set password = '$password' WHERE id = $id ");
	if($save){
		$data ['status'] = 1;
		$data['msg'] = 'Password successfully reset.';
	} else {
		$data ['status'] = 2;
		$data['msg'] = 'Please remove special characters. Refresh the page and try again.';
	}

	echo json_encode($data);
	$conn->close()	;