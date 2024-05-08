<?php
    require_once 'db_connect.php';

	extract($_POST);
	$data = array();
	$notes = htmlspecialchars($_POST['notes'],ENT_QUOTES);

	if(empty($shift) && empty($notes)){
		$delete = $conn->query("DELETE FROM `schedule` WHERE `id` = '$id' AND `dateInfo` = '$dateInfo'") or die(mysqli_error());
		if($delete){
			$data ['status'] = 1;
		}
	}else{
		$chk = $conn->query("SELECT * FROM `schedule` WHERE `id` = '$id' and dateInfo = '$dateInfo' ");
		if($chk->num_rows > 0){
			$save=$conn->query("UPDATE schedule set shift = '$shift', notes = '$notes' WHERE id = '$id' AND dateInfo = '$dateInfo'");
			if($save){
				$data ['status'] = 1;
			} else {
				$data ['status'] = 2;
				$data['msg'] = 'Please remove special characters and try again.';
			}
		}else{
			$save=$conn->query("INSERT INTO schedule (id, firstname, lastname, shift, dateInfo, empType, notes) values ('$id','$firstname','$lastname','$shift','$dateInfo','$empType','$notes')");
			if($save){
				$data ['status'] = 1;
			} else {
				$data ['status'] = 2;
				$data['msg'] = 'Please remove special characters and try again.';
			}
		}	
	}

	echo json_encode($data);
	$conn->close()	;