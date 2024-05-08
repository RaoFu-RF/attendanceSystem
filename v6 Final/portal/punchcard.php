<!DOCTYPE html>
<?php
	require 'auth.php';
	include 'db_connect.php';
	if ($role == 'employee' || $role == 'manager') {
?>
<html lang="eng">
	<head>
		<title>Punch Card</title>
		<meta charset="utf-8" />
		<?php include('header.php'); ?>
		<link rel="stylesheet" href="../assets/css/navbar.css">
	</head>
	<body>
	<?php include 'nav_bar.php' ?>
		<div class="container-fluid">
			<center><h2><strong>Clock In/Clock Out</strong></h2></center>
			<br/>
			<br/>

			<?php 
			$user_qry=$conn->query("SELECT * FROM attendance WHERE `id` = '$id'") or die(mysqli_error());
			while($row=$user_qry->fetch_array()){
				$status = $row['status'];
				if($status == '') {
					$status = 0;
				}
				} ?>
			<div class="attendance_log_field">
				<div class="col-md-4 offset-md-4">
					<div class="card">
						<div class="card-body">
							<div class="text-center">
								<h4><?php echo date('F d,Y') ?> <span id="now"></span></h4>
							</div>
							<div class="col-md-12">
								<div class="text-center mb-4" id="log_display"></div>
								<!-- form -->
								<form id="user-frm">
									<input type="hidden" name="id" value="<?php echo $id; ?>" />
									<input type="hidden" name="firstname" value="<?php echo $user_fname; ?>" />
									<input type="hidden" name="lastname" value="<?php echo $user_lname; ?>" />
									<input type="hidden" name="status" value="<?php echo $status; ?>" />
									
										<?php 
										if ($status == 0) { ?>
										<div class="form-group">
											<label><strong>Please select your shift:</strong></label>
											<select name="shift" required="required" class="form-control"> 
												<option value="D">D</option>
												<option value="ds">ds</option>
												<option value="E">E</option>
												<option value="es">es</option>
												<option value="N">N</option>
												<option value="H">H</option>
												<option value="C">C</option>
												<option value="SW">SW</option>
												<option value="GB">GB</option>
												<option value="M">M</option>
												<option value="Other">Other</option>
											</select>
										</div>
										<center>
										<button  class="btn btn-primary" name="submit">Clock In</button>
										</center>
										<?php 
										} else if ($status == 1) { ?>
										<center>
										<button  class="btn btn-primary" name="submit">Clock Out</button>
										</center>
										<?php } ?>
																			
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>	
		</div>

		<?php include 'footer.php' ?>
	</body>
	<script src = "../assets/js/navbar.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			setInterval(function(){
				var time = new Date();
				var now = time.toLocaleString('en-CA', {hour: 'numeric', minute: 'numeric', second: 'numeric', hour12: true, })
				$('#now').html(now)
			},500)
			console.log();

			$('#user-frm').submit(function(e){
				e.preventDefault()
				$('#user-frm [name="submit"]').attr('disabled',true)
				$('#user-frm [name="submit"]').html('Saving')
				$.ajax({
					url:'time_log.php',
					method:"POST",
					data:$(this).serialize(),
					error:err=>console.log(),
					success:function(resp){
						if(typeof resp != undefined){
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
			
		});
	</script>
</html>

<?php
}
?>