<?php
	require_once 'db_connect.php';
	extract($_POST);
		$data = array();
			
        $chk = $conn->query("SELECT * FROM `users` WHERE `email` = '$email' and id != '$id' ");
        if($chk->num_rows > 0){
            $data ['status'] = 2;
            $data['msg'] = 'Email already exist';
        }else{
            $save=$conn->query("UPDATE users set email = '$email', firstname = '$firstname', lastname = '$lastname', email = '$email', dateHired = '$dateHired', empType = '$empType', category = '$category', role = '$role', phone = '$phone' where id = $id ");
            if($save){
                $data ['status'] = 1;
                $data['msg'] = 'Data successfully updated.';
            } else {
                $data ['status'] = 2;
                $data['msg'] = 'Please check your input format and remove special characters. Refresh the page and try again.';
            }
        }

		echo json_encode($data);
        $conn->close()	;