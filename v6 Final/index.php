<!DOCTYPE html>
<?php
	session_start();
	if(ISSET($_SESSION['login_id'])){
		header('location: home.php');
	}
?>
<html lang = "eng">
	<head>
		<title>NOHS - Attendance/Leave System</title>
		<?php include 'header.php' ?>
	</head>
	<body>
	<a href="https://nohs.ca/" target="_blank">
	<img src="assets/images/NOHS.png" width="300" height="100" alt="NOHS">
            </a>
	<div style="background-color:grey;height:70px;">
	<h2 style="font-weight: bold; font-size: 40px; color: white; min-width:1000px; text-align: center;">North Okanagan Hospice Society</h2>
</div>

<h2 style="font-weight: bold; font-size: 40px;left: 50%; min-width:1000px; text-align: center;">Attendance/Leave System</h2>
<br/>

		<div style="background-color:#DDDEDE;height:1200px;">

		<div class = "container" style="margin-top:10px;">
		<br/>
			<div class = "col-lg-12">
			<div class = "row">
				<div class = "col-md-6 offset-md-3 ">
					<div class = "card login-field">
						<div class = "card-header">
							<h4 style="text-align: center;">Login</h4>
						</div>
						<div class = "card-body">
							<form id = "login-frm">
								<div id = "" class = "form-group">
									<label class = "control-label" >E-mail: </label>
									<input type = "text" name = "email" class = "form-control" maxlength="50" required/>
								</div>
								<div id = "" class = "form-group">
									<label class = "control-label">Password:</label>
									<input type = "password" maxlength = "20" name = "password" class = "form-control" required/>
								</div>
								<br />
								<button type = "submit" class = "btn btn-warning btn-block" >Login <i class="fa fa-arrow-right"></i></button>
							</form>
						</div>
					</div>
				</div>
			</div>
			</div>
		</div>
		</div>

	</body>
	<script src = "assets/js/jquery.js"></script>
	<script src = "assets/js/bootstrap.js"></script>

	<script>
		$(document).ready(function(){
			$('#login-frm').submit(function(e){
				e.preventDefault();
				$.ajax({
					url:'login.php',
					method:'POST',
					data:$(this).serialize(),
					error:err=>{
						console.log(err)
					},
					success:function(resp){
						if(typeof resp !=undefined){
							resp = JSON.parse(resp)
						if(resp.status == 1){
							location.replace('home.php')
						} else {
							alert(resp.msg);
						}
					}
					}
				})
			})
		})
	</script>
</html>