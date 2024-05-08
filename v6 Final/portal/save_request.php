<?php
	require_once 'db_connect.php';
	extract($_POST);
		$data = array();
		$notes = htmlspecialchars($_POST['notes'],ENT_QUOTES);
		if(empty($request_id)){
				$save=$conn->query("INSERT INTO emp_time_off (id, firstname, lastname, startingdate, endingdate, leavetype, notes, status) values ('$id','$firstname','$lastname','$startingdate','$endingdate','$leavetype','$notes','$status')");
				if($save){
					$data ['status'] =1;
					$data['msg'] = 'Data successfully saved.';
				} else {
					$data ['status'] =2;
					$data['msg'] = 'Please remove special characters. Refresh the page and try again.';
				}
		}else{
			$save=$conn->query("UPDATE emp_time_off set startingdate = '$startingdate', endingdate = '$endingdate', leavetype = '$leavetype', notes = '$notes' where request_id = $request_id ");
			if($save){
				$data ['status'] = 1;
				$data['msg'] = 'Data successfully updated.';
			} else {
				$data ['status'] =2;
				$data['msg'] = 'Please remove special characters. Refresh the page and try again.';
			}
		}

		echo json_encode($data);
	$conn->close();