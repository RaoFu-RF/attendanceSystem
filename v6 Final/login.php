<?php
	require_once 'portal/db_connect.php';
	extract($_POST);
	
	$email = $_POST['email'];
	$password = $_POST['password'];
	$password = md5($password);

	$qry = $conn->query("SELECT * FROM users WHERE email = '$email' and  password = '$password'") or die(msqli_error());
	$login = $qry->fetch_array();


	if($qry->num_rows > 0) {
		$data ['status'] = 1;
		session_start();
		foreach($login as $k => $v) {
			if(!is_numeric($k) && $k !='password') {
			$_SESSION['login_'.$k] = $v;
			}
		}
	} else {
		$data ['status'] = 2;
		$data['msg'] = 'Login Information is Incorrect.';
	}

	echo json_encode($data);
	$conn->close();