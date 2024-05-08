<?php
    require_once 'db_connect.php';
	extract($_POST);
	$data = array();
	$notes = htmlspecialchars($_POST['notes'],ENT_QUOTES);

			$save=$conn->query("UPDATE timesheet set dateInfo = '$newdateInfo', timein = '$newtimein', `timeout` = '$newtimeout', shift = '$shift', lunch = '$lunch', sick = '$sick', vacation = '$vacation', regular = '$regular', ot = '$ot', notes = '$notes' WHERE id = '$id' AND (dateInfo = '$dateInfo' AND timein = '$timein' AND `timeout` = '$timeout')");
			if($save){
				$data ['status'] = 1;
			} else {
				$data ['status'] = 2;
				$data['msg'] = 'Please check your input format and remove special characters. Refresh the page and try again.';
			}

	echo json_encode($data);
	$conn->close()	;