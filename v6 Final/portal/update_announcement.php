<?php
    require_once 'db_connect.php';
	extract($_POST);
	$data = array();
	$announce = htmlspecialchars($_POST['announce'],ENT_QUOTES);

			$save=$conn->query("UPDATE announcement set announce = '$announce'");
			if($save){
				$data ['status'] = 1;
				$data['msg'] = 'Announcement successfully updated.';
			} else {
				$data ['status'] = 2;
				$data['msg'] = 'Error, please remove special characters and try again.';
			}

	echo json_encode($data);
	$conn->close()	;