<!DOCTYPE html>
<?php
require_once 'auth.php';
if ($role == 'manager') {
	?>
<html lang = "eng">
	<head>
		<title>Home</title>
		<link rel="stylesheet" href="../assets/css/navbar.css">
		<?php include 'header.php'; ?>
	</head>
	<body>
		<?php include 'nav_bar.php'; ?>
		<?php $today = date('Y-m-d'); ?>
		<div class="container-fluid">
			<div class="col p-4">

				<div class="row">
					<div class="col-sm-6">
						<div class="card">
							<div class="card-body">
								<h5 class="card-title">Who's Working Today?</h5>
								<br/>
								<?php 
								$schedule=$conn->query("SELECT firstname, lastname, shift FROM schedule WHERE `dateInfo` = '$today'") or die(mysqli_error());
								while($work=$schedule->fetch_array()){
									?>
									<p class="card-text"><?php echo $work['firstname'].' '.$work['lastname'];?>&emsp;&emsp;Shift: <?php echo $work['shift']; ?></p>
									<?php
								} ?>
								<a href="manager_schedule.php" class="btn btn-success">Go To Schedule</a>
							</div>
						</div>
					</div>

					<div class="col-sm-6">
						<div class="card">
							<div class="card-body">
								<h5 class="card-title">Who's Working Right Now?</h5>
								<br/>
								<?php 
								$user_qry=$conn->query("SELECT * FROM attendance WHERE `status` = 1") or die(mysqli_error());
								while($row=$user_qry->fetch_array()){ 
									$working=$conn->query("SELECT firstname, lastname, shift FROM timesheet WHERE `id` = '".$row['id']."' AND `dateInfo` = '".$row['dateInfo']."' AND `timein` = '".$row['timeInfo']."'") or die(mysqli_error());
									while($get=$working->fetch_array()){
										?>
										<p class="card-text"><?php echo $get['firstname'].' '.$get['lastname'];?>&emsp;&emsp;Shift: <?php echo $get['shift']; ?></p>
									<?php
									}
								} ?>
							</div>
						</div>
					</div>
				</div>

				<br/>
				<br/>

				<div class="row">
					<div class="col-sm-6">
						<div class="card">
							<div class="card-body">
								<h5 class="card-title">Reminder</h5>
								<br/>
								<?php
								$empty = 0;
								$timesheet=$conn->query("SELECT * FROM timesheet WHERE `id` = '$id'") or die(mysqli_error());
								while($chk=$timesheet->fetch_array()){
									if(($chk['timeout'] == '')){ 
										?>
										<p class="card-text">Don't forget clock out.</p>
										<a href="punchcard.php" class="btn btn-primary">Go Clock Out</a>
										<p></p>
										<?php
										break;
									} elseif(($chk['timeout'] != '') && ($chk['regular'] == '')){
										$empty++;
									}
								} ?>								
								<p class="card-text">You have <strong><?php echo $empty; ?></strong> record(s) waiting for you to update.</p>
								<a href="manager_timesheet.php" class="btn btn-warning">Go To Timesheet</a>
							</div>
						</div>
					</div>
				</div>
				
				<br/>
				<br/>

				<div class="row">
					<div class="col-sm-6">
						<div class="card">
							<div class="card-body">
								<h5 class="card-title">Holidays</h5>
								<br/>
								<?php 
								$holidays=$conn->query("SELECT * FROM holidays") or die(mysqli_error());
								while($h=$holidays->fetch_array()){ 
									?>
									<p class="card-text"><?php echo $h['holiday']; ?></p>
									<?php
								} ?>
								<button class="btn btn-primary edit_holidays" type="button">Reset Holidays</button>
							</div>
						</div>
					</div>

					<div class="col-sm-6">
						<div class="card">
							<div class="card-body">
								<h5 class="card-title">Announcement</h5>
								<br/>
								<?php 
								$announcement=$conn->query("SELECT * FROM announcement") or die(mysqli_error());
								while($announce=$announcement->fetch_array()){ 
									?>
									<p class="card-text"><?php echo $announce['announce']; ?></p>
									<?php
								} ?>
								<button class="btn btn-info edit_announcement" type="button">Change Announcement</button>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
		<br/>
		<br/>

		<!-- announcement modal form-->
		<div class="modal fade" id="change_announcement" tabindex="-1" role="dialog" aria-labelledby="change_announcementlabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content panel-primary">
					<div class="modal-header panel-heading">
						<h4 class="modal-title">Change Announcement</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<form id="user-frm">
						<div class ="modal-body">	
							<div class="form-group">
								<textarea class="form-control rounded-0" name="announce" rows="10" maxlength="300"></textarea>
								<p>(Maximum 300 characters)</p>
							</div>
						</div>
						<div class="modal-footer">
							<button  class="btn btn-primary" name="submit">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<!-- holiday modal form-->
		<div class="modal fade" id="change_holidays" tabindex="-1" role="dialog" aria-labelledby="change_holidayslabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content panel-primary">
					<div class="modal-header panel-heading">
						<h4 class="modal-title">Edit Holidays</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<form id="holidays-frm">
						<div class ="modal-body">	
							<div class="form-group">
								<label>Holiday #1</label>
								<input type="text" name="holiday1" required="required" class="form-control" />
							</div>
							<div class="form-group">
								<label>Holiday #2</label>
								<input type="text" name="holiday2" class="form-control" />
							</div>
							<div class="form-group">
								<label>Holiday #3</label>
								<input type="text" name="holiday3" class="form-control" />
							</div>
							<div class="form-group">
								<label>Holiday #4</label>
								<input type="text" name="holiday4" class="form-control" />
							</div>
							<div class="form-group">
								<label>Holiday #5</label>
								<input type="text" name="holiday5" class="form-control" />
							</div>
							<div class="form-group">
								<label>Holiday #6</label>
								<input type="text" name="holiday6" class="form-control" />
							</div>
							<div class="form-group">
								<label>Holiday #7</label>
								<input type="text" name="holiday7" class="form-control" />
							</div>
							<div class="form-group">
								<label>Holiday #8</label>
								<input type="text" name="holiday8" class="form-control" />
							</div>
							<div class="form-group">
								<label>Holiday #9</label>
								<input type="text" name="holiday9" class="form-control" />
							</div>
							<div class="form-group">
								<label>Holiday #10</label>
								<input type="text" name="holiday10" class="form-control" />
							</div>
							<div class="form-group">
								<label>Holiday #11</label>
								<input type="text" name="holiday11" class="form-control" />
							</div>
							<div class="form-group">
								<label>Holiday #12</label>
								<input type="text" name="holiday12" class="form-control" />
							</div>
							<div class="form-group">
								<label>Holiday #13</label>
								<input type="text" name="holiday13" class="form-control" />
							</div>
							<div class="form-group">
								<label>Holiday #14</label>
								<input type="text" name="holiday14" class="form-control" />
							</div>
							<div class="form-group">
								<label>Holiday #15</label>
								<input type="text" name="holiday15" class="form-control" />
							</div>
						</div>
						<div class="modal-footer">
							<button  class="btn btn-primary" name="submit">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<?php include 'footer.php' ?>
	</body>

	<script src = "../assets/js/navbar.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#user-frm').submit(function(e){
				e.preventDefault()
				$('#user-frm [name="submit"]').attr('disabled',false)
				$('#user-frm [name="submit"]').html('Save')
				$.ajax({
					url:'update_announcement.php',
					method:"POST",
					data:$(this).serialize(),
					error:err=>console.log(),
					success:function(resp){
						if(typeof resp !=undefined){
							resp = JSON.parse(resp)
							if(resp.status == 1){
								alert(resp.msg);
								location.reload();
							}else{
								alert(resp.msg);
							}
						}
					}
				})
			})

			$('.edit_announcement').click(function(){
				$('[name="announce"]').val('')
				$('#change_announcement').modal('show')
			})

			$('#holidays-frm').submit(function(e){
				e.preventDefault()
				$('#holidays-frm [name="submit"]').attr('disabled',false)
				$('#holidays-frm [name="submit"]').html('Save')
				$.ajax({
					url:'update_holidays.php',
					method:"POST",
					data:$(this).serialize(),
					error:err=>console.log(),
					success:function(resp){
						if(typeof resp !=undefined){
							resp = JSON.parse(resp)
							if(resp.status == 1){
								alert(resp.msg);
								location.reload();
							}else{
								alert(resp.msg);
							}
						}
					}
				})
			})

			$('.edit_holidays').click(function(){
				$('[name="holiday1"]').val('')
				$('[name="holiday2"]').val('')
				$('[name="holiday3"]').val('')
				$('[name="holiday4"]').val('')
				$('[name="holiday5"]').val('')
				$('[name="holiday6"]').val('')
				$('[name="holiday7"]').val('')
				$('[name="holiday8"]').val('')
				$('[name="holiday9"]').val('')
				$('[name="holiday10"]').val('')
				$('[name="holiday11"]').val('')
				$('[name="holiday12"]').val('')
				$('[name="holiday13"]').val('')
				$('[name="holiday14"]').val('')
				$('[name="holiday15"]').val('')
				$('#change_holidays').modal('show')
			})
		});
	</script>
</html>

<?php 
} else if ($role == "employee") {
?>
<html lang = "eng">
	<head>
		<title>Home</title>
		<link rel="stylesheet" href="../assets/css/navbar.css">
		<?php include 'header.php'; ?>	
	</head>
	<body>
		<?php include 'nav_bar.php' ?>
		<?php $today = date('Y-m-d'); ?>
		<div class="container-fluid">
			<div class="col p-4">

				<div class="row">
				<div class="col-sm-6">
						<div class="card">
							<div class="card-body">
								<h5 class="card-title">Who's Working Today?</h5>
								<br/>
								<?php 
								$schedule=$conn->query("SELECT firstname, lastname, shift FROM schedule WHERE `dateInfo` = '$today'") or die(mysqli_error());
								while($work=$schedule->fetch_array()){
									?>
									<p class="card-text"><?php echo $work['firstname'].' '.$work['lastname'];?>&emsp;&emsp;Shift: <?php echo $work['shift']; ?></p>
									<?php
								} ?>
								<a href="employee_schedule.php" class="btn btn-success">Go To Schedule</a>
							</div>
						</div>
					</div>

					<div class="col-sm-6">
						<div class="card">
							<div class="card-body">
								<h5 class="card-title">Reminder</h5>
								<br/>
								<?php
								$empty = 0;
								$timesheet=$conn->query("SELECT * FROM timesheet WHERE `id` = '$id'") or die(mysqli_error());
								while($chk=$timesheet->fetch_array()){
									if(($chk['timeout'] == '')){ 
										?>
										<p class="card-text">Don't forget clock out.</p>
										<a href="punchcard.php" class="btn btn-primary">Go Clock Out</a>
										<p></p>
										<?php
										break;
									} elseif(($chk['timeout'] != '') && ($chk['regular'] == '')){
										$empty++;
									}
								} ?>								
								<p class="card-text">You have <strong><?php echo $empty; ?></strong> record(s) waiting for you to update.</p>
								<a href="employee_timesheet.php" class="btn btn-warning">Go To Timesheet</a>
							</div>
						</div>
					</div>
				</div>

				<br/>
				<br/>
				
				<div class="row">
					<div class="col-sm-6">
						<div class="card">
							<div class="card-body">
								<h5 class="card-title">Holidays</h5>
								<br/>
								<?php 
								$holidays=$conn->query("SELECT * FROM holidays") or die(mysqli_error());
								while($h=$holidays->fetch_array()){ 
									?>
									<p class="card-text"><?php echo $h['holiday']; ?></p>
									<?php
								} ?>
							</div>
						</div>
					</div>

					<div class="col-sm-6">
						<div class="card">
							<div class="card-body">
								<h5 class="card-title">Announcement</h5>
								<br/>
								<?php 
								$announcement=$conn->query("SELECT * FROM announcement") or die(mysqli_error());
								while($announce=$announcement->fetch_array()){ 
									?>
									<p class="card-text"><?php echo $announce['announce']; ?></p>
									<?php
								} ?>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
		<br/>
		<br/>
		<?php include 'footer.php' ?>
	</body>

	<script src = "../assets/js/navbar.js"></script>
</html>
<?php
}
?>