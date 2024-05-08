<?php
    require_once 'db_connect.php';
	extract($_POST);
	$data = array();

	//delete old holidays
	$delete = $conn->query("DELETE FROM holidays") or die(mysqli_error());

	//insert new holidays
	if($holiday1 != '') {
		$holiday1 = htmlspecialchars($_POST['holiday1'],ENT_QUOTES);
		$save=$conn->query("INSERT INTO holidays (holiday) values ('$holiday1')");
	}
	if($holiday2 != '') {
		$holiday2 = htmlspecialchars($_POST['holiday2'],ENT_QUOTES);
		$save=$conn->query("INSERT INTO holidays (holiday) values ('$holiday2')");
	}
	if($holiday3 != '') {
		$holiday3 = htmlspecialchars($_POST['holiday3'],ENT_QUOTES);
		$save=$conn->query("INSERT INTO holidays (holiday) values ('$holiday3')");
	}
	if($holiday4 != '') {
		$holiday4 = htmlspecialchars($_POST['holiday4'],ENT_QUOTES);
		$save=$conn->query("INSERT INTO holidays (holiday) values ('$holiday4')");
	}
	if($holiday5 != '') {
		$holiday5 = htmlspecialchars($_POST['holiday5'],ENT_QUOTES);
		$save=$conn->query("INSERT INTO holidays (holiday) values ('$holiday5')");
	}
	if($holiday6 != '') {
		$holiday6 = htmlspecialchars($_POST['holiday6'],ENT_QUOTES);
		$save=$conn->query("INSERT INTO holidays (holiday) values ('$holiday6')");
	}
	if($holiday7 != '') {
		$holiday7 = htmlspecialchars($_POST['holiday7'],ENT_QUOTES);
		$save=$conn->query("INSERT INTO holidays (holiday) values ('$holiday7')");
	}
	if($holiday8 != '') {
		$holiday8 = htmlspecialchars($_POST['holiday8'],ENT_QUOTES);
		$save=$conn->query("INSERT INTO holidays (holiday) values ('$holiday8')");
	}
	if($holiday9 != '') {
		$holiday9 = htmlspecialchars($_POST['holiday9'],ENT_QUOTES);
		$save=$conn->query("INSERT INTO holidays (holiday) values ('$holiday9')");
	}
	if($holiday10 != '') {
		$holiday10 = htmlspecialchars($_POST['holiday10'],ENT_QUOTES);
		$save=$conn->query("INSERT INTO holidays (holiday) values ('$holiday10')");
	}
	if($holiday11 != '') {
		$holiday11 = htmlspecialchars($_POST['holiday11'],ENT_QUOTES);
		$save=$conn->query("INSERT INTO holidays (holiday) values ('$holiday11')");
	}
	if($holiday12 != '') {
		$holiday12 = htmlspecialchars($_POST['holiday12'],ENT_QUOTES);
		$save=$conn->query("INSERT INTO holidays (holiday) values ('$holiday12')");
	}
	if($holiday13 != '') {
		$holiday13 = htmlspecialchars($_POST['holiday13'],ENT_QUOTES);
		$save=$conn->query("INSERT INTO holidays (holiday) values ('$holiday13')");
	}
	if($holiday14 != '') {
		$holiday14 = htmlspecialchars($_POST['holiday14'],ENT_QUOTES);
		$save=$conn->query("INSERT INTO holidays (holiday) values ('$holiday14')");
	}
	if($holiday15 != '') {
		$holiday15 = htmlspecialchars($_POST['holiday15'],ENT_QUOTES);
		$save=$conn->query("INSERT INTO holidays (holiday) values ('$holiday15')");
	}

	//print message
	if($save){
		$data ['status'] = 1;
		$data['msg'] = 'Holidays successfully updated.';
	} else {
		$data ['status'] = 2;
		$data['msg'] = 'Please remove special characters and try again.';
	}

	echo json_encode($data);
	$conn->close()	;