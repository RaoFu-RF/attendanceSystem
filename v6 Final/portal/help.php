<!DOCTYPE html>
<?php
	require 'auth.php';
	include 'db_connect.php';
	if ($role == 'employee' || $role == 'manager') {
?>
<html lang="eng">
	<head>
		<title>Help</title>
		<meta charset="utf-8" />
		<?php include('header.php'); ?>
		<link rel="stylesheet" href="../assets/css/navbar.css">
	</head>
	<body>
	<?php include 'nav_bar.php' ?>
		<div class="container-fluid">
			<center><h2><strong>Help</strong></h2></center>
			<br/>
			<div class="col p-4">

				<div class="row">
					<div class="col-sm-6">
						<div class="card">
							<div class="card-body">
								<table class="card-title" >
									<td bgcolor="#FFC0CB"><font size="5"><strong>&emsp;Home&emsp;</strong></font><t/d>
								</table>
								<p><strong>FAQ</strong></p>
								<p class="card-text"><strong>Q:</strong>  What is 'You have 0 record(s) waiting for you to update'?</p>
								<p class="card-text">A: The number indicated how many records in your timesheet which regular hours is empty.</p>
								<?php if($role == 'manager') {?>
								<p class="card-text"><strong>Q:</strong>  About 'Who is working right now?'</p>
								<p class="card-text">A: If an employee clocked in but not clock out yet, his/her name and shift will display here.</p>
								<?php } ?>
							</div>
						</div>
					</div>

					<div class="col-sm-6">
						<div class="card">
							<div class="card-body">
								<table class="card-title" >
									<td bgcolor="#FFCC00"><font size="5"><strong>&emsp;Schedule&emsp;</strong></font><t/d>
								</table>
								<p><strong>FAQ</strong></p>
								<p class="card-text"><strong>Q:</strong>  Why it displayed somthing like #039 in notes?</p>
								<p class="card-text">A: It's a special character problem. No special characters (include single quote and double quote) other than: .,:;?!@#$%&()[]{}-+*/.</p>
								<?php if($role == 'manager') {?>
								<p class="card-text"><strong>Q:</strong>  How can I insert a schedule in a box?</p>
								<p class="card-text">A: You could insert a schedule by single-click on a box, click 'Save' button when you are done.</p>
								<?php } ?>
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
								<table class="card-title" >
									<td bgcolor="#B6C5F2"><font size="5"><strong>&emsp;Time Off&emsp;</strong></font><t/d>
								</table>
								<p><strong>FAQ</strong></p>
								<?php if($role == 'employee') {?>
								<p class="card-text"><strong>Q:</strong>  Why I can't edit my request?</p>
								<p class="card-text">A: If your manager has ready approved/declined your request, then your're not able to edit it.</p>
								<?php } ?>
								<p class="card-text"><strong>Q:</strong>  Why I can't submit a request?</p>
								<p class="card-text">A: Please check and make sure no special characters in your form (Other than: .,:;?!@#$%&()[]{}-+*/.).</p>
							</div>
						</div>
					</div>

					<div class="col-sm-6">
						<div class="card">
							<div class="card-body">
								<table class="card-title" >
									<td bgcolor="#7FFFD4"><font size="5"><strong>&emsp;Clock In/Clock Out&emsp;</strong></font><t/d>
								</table>
								<p><strong>FAQ</strong></p>
								<p class="card-text"><strong>Q:</strong>  What should I do if I selected a wrong shift?</p>
								<p class="card-text">A: You could contact your manager to change it.</p>
								<p class="card-text"><strong>Q:</strong>  What should I do if I forgot clock in/clock out?</p>
								<p class="card-text">A: After you successfully clocked out, contact your manager, your manager will be able to change the clock in/clock out time for you.</p>
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
								<table class="card-title" >
									<td bgcolor="#C9DFA7"><font size="5"><strong>&emsp;Timesheet&emsp;</strong></font><t/d>
								</table>
								<p><strong>FAQ</strong></p>
								<p class="card-text"><strong>Q:</strong>  Where does total regular hours and total over time come from?</p>
								<p class="card-text">A: It comes from Regular Hours column and OT column which manually inputted by user.</p>
								<p class="card-text"><strong>Q:</strong>  The timesheet will inlcude which week?</p>
								<p class="card-text">A: The timesheet will include 2 weeks. Every time you come to the timesheet page, it will include the current week and the week before (start from Sunday). After you selected a date, the timesheet will start from the selected date.</p>
								<p class="card-text"><strong>Q:</strong>  How can I export 'Total' row(s) only?</p>
								<p class="card-text">A: Enter 'Total' in the search box and then click 'Export' button.</p>
							</div>
						</div>
					</div>

					<?php if($role == 'manager') {?>
					<div class="col-sm-6">
						<div class="card">
							<div class="card-body">
								<table class="card-title" >
									<td bgcolor="#E6B8AC"><font size="5"><strong>&emsp;Manage Employee&emsp;</strong></font><t/d>
								</table>
								<p><strong>FAQ</strong></p>
								<p class="card-text"><strong>Q:</strong>  Why I can't change myself's information and password?</p>
								<p class="card-text">A: Due to a log in issue, managers are not able to change their user's information and password themself. Please log out first and ask another manager to change it for you.</p>
								<p class="card-text"><strong>Q:</strong>  Three buttons in 'Action'?</p>
								<p class="card-text">A: You could click the first button to edit user information, click the second button to reset password, click the third button to delete user.</p>
								<p class="card-text"><strong>Q:</strong>  About 'Total Hours' column?</p>
								<p class="card-text">A: For each employee, the total column will calculate total regular hours plus total over time for each year from Jan 1st to Dec 31st. It will reset to zero on Dec 31st at midnight.</p>
							</div>
						</div>
					</div>
					<?php }?>
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