<?php
	require_once 'db_connect.php';
	extract($_POST);
		$data = array();
		$password = md5($password);

		$chk = $conn->query("SELECT * FROM `users` WHERE `email` = '$email'")->num_rows;
		if($chk > 0){
			$data ['status'] = 2;
			$data['msg'] = 'Email already exist, User already added!';
		} else {
			$save=$conn->query("INSERT INTO users (firstname, lastname, email, dateHired, empType, category, role, phone, password) values ('$firstname','$lastname','$email','$dateHired','$empType','$category','$role','$phone', '$password')");
			if($save){
				$data ['status'] = 1;
				$data['msg'] = 'Data successfully saved.';
			} else {
				$data ['status'] = 2;
				$data['msg'] = 'Please check your input format and remove special characters. Refresh the page and try again.';
			}
		}
		
		echo json_encode($data);
		$conn->close()	;