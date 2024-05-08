<?php
	require_once 'db_connect.php';
	extract($_POST);
		

				$save=$conn->query("INSERT INTO emp_attendance (firstname, lastname) values ('$firstname','$lastname')");
				if($save) {
					$data ['status'] = 1;
					$data['msg'] = 'Data successfully saved.';
				}
		

		

		$conn->close();
		?>