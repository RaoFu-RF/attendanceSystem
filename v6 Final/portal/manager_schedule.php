<!DOCTYPE html>
<?php
	include 'auth.php';
	if ($role == 'manager') {
?>
<html lang="eng">
	<head>
	<style>
			.padding-down{
				padding-top: 20px;
			}
		</style>
		<title>Manager Schedule</title>
		<meta charset="utf-8" />
		<link rel = "stylesheet" type = "text/css" href = "../assets/css/bootstrap.min.css" />
		<link rel = "stylesheet" type = "text/css" href = "https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
		<link rel = "stylesheet" type = "text/css" href = "https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" />
		<link rel = "stylesheet" type = "text/css" href = "../assets/css/style.css" />
		<script src = "../assets/js/jquery-3.5.1.min.js"></script>
		<script src = "../assets/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="../assets/css/navbar.css">
	</head>
	<body>
	<?php include 'nav_bar.php' ?>
		<div class="container-fluid">
				<!-- Start -->
				<center><h2><strong>Schedule</strong></h2></center>
				<br/>
				<!-- calendar input -->
				<div class="padding-down">
					<form action="" method="post">
						<table border="0">
							<tr>
								<td><strong>Select a starting week:&nbsp;</strong></td>
								<td><input type="date" name="startingDate"></td>
								<td colspan="2" align="right">
									<input type="submit" value="Submit">
								</td>
							</tr>
						</table>
					</form>
					<br/>
					<br/>
						
					<!-- table 1 (3 weeks) -->
					<table id="table" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th style="width: 12%">Employee Name</th>
								<?php 
								$result = array();
								$prt = array();
								if(!($_POST)){
									if(date('w') == 0) {
										for($i=0;$i<=20;$i++){
											$result[$i]=date('Y-m-d', strtotime("+$i day"));
											$week=date('D', strtotime("+$i day"));
											$prt[$i]=date('y M d', strtotime("$result[$i]"));
											if($week == 'Sun'){
												echo '<th bgcolor="#FFCC00">'.$prt[$i].' '.$week.'</th>';
											} else {
												echo '<th>'.$prt[$i].' '.$week.'</th>';
											}
										}
									} elseif(date('w') != 0){
										for($i=0;$i<=20;$i++){
											$result[$i]=date('Y-m-d', strtotime("last sunday +$i day"));
											$week=date('D', strtotime("last sunday +$i day"));
											$prt[$i]=date('y M d', strtotime("$result[$i]"));
											if($week == 'Sun'){
												echo '<th bgcolor="#FFCC00">'.$prt[$i].' '.$week.'</th>';
											} else {
												echo '<th>'.$prt[$i].' '.$week.'</th>';
											}
										}
									}
								} elseif($_POST) {
									$input = $_POST['startingDate'];
									if(date('w', strtotime($input)) == 0) {
										for($i=0;$i<=20;$i++){
											$result[$i]=date('Y-m-d', strtotime("$input + $i day"));
											$week=date('D', strtotime("$input + $i day"));
											$prt[$i]=date('y M d', strtotime("$result[$i]"));
											if($week == 'Sun'){
												echo '<th bgcolor="#FFCC00">'.$prt[$i].' '.$week.'</th>';
											} else {
												echo '<th>'.$prt[$i].' '.$week.'</th>';
											}
										}
									} elseif(date('w', strtotime($input)) != 0){
										$sun = date('Y-m-d', strtotime("$input last sunday"));
										for($i=0;$i<=20;$i++){
											$result[$i]=date('Y-m-d', strtotime("$sun +$i day"));
											$week=date('D', strtotime("$sun +$i day"));
											$prt[$i]=date('y M d', strtotime("$result[$i]"));
											if($week == 'Sun'){
												echo '<th bgcolor="#FFCC00">'.$prt[$i].' '.$week.'</th>';
											} else {
												echo '<th>'.$prt[$i].' '.$week.'</th>';
											}
										}
									}
								}
								?>
								</tr>
							</thead>
							<tbody>
								<!-- RN shifts -->
								<tr>
									<td bgcolor="#FFF9DF" colspan="22"><strong>RN Shifts</strong></td>
								</tr>
								<?php
								$user_qry=$conn->query("SELECT * FROM users WHERE `empType` = 'RN'" ) or die(mysqli_error());
								while($row=$user_qry->fetch_array()){
									?>	
									<tr>
										<td><?php echo $row['firstname'].' '.$row['lastname']?></td>
										<?php 
										for($j=0;$j<=20;$j++) {
											//check schedule
											$chk = $conn->query("SELECT * FROM `schedule` WHERE `id` = '".$row['id']."' AND `dateInfo` = '".$result[$j]."'" );
											//check time off
											$chktoff = $conn->query("SELECT * FROM `emp_time_off` WHERE `id` = '".$row['id']."' AND `status` = 'A' AND (`startingdate` <= '".$result[$j]."' AND `endingdate` >= '".$result[$j]."')" );
											if($chktoff->num_rows > 0){
												$hasoff=$chktoff->fetch_array();
												$offType = '<br><strong><font color="red">'.$hasoff['leavetype'].'</font></strong>';
											} else {
												$offType = '';
											}
											//print
											if($chk->num_rows > 0) {
												$get=$chk->fetch_array();
												$notes = htmlspecialchars($get['notes'],ENT_QUOTES); ?>
												<td onclick="openModal('<?php echo $row['id']; ?>', '<?php echo $row['firstname']; ?>', '<?php echo $row['lastname']; ?>', '<?php echo $row['empType']; ?>', '<?php echo $result[$j]; ?>', '<?php echo $get['shift']; ?>', '<?php echo $notes; ?>')" <?php if($notes != ''){?> bgcolor="#D3D3D3" <?php } ?>><?php echo $get['shift'];?><?php echo $offType;?></td>
												<?php 
												} else { 
													?>
													<td onclick="openModal('<?php echo $row['id']; ?>', '<?php echo $row['firstname']; ?>', '<?php echo $row['lastname']; ?>', '<?php echo $row['empType']; ?>', '<?php echo $result[$j]; ?>', '<?php echo ''; ?>', '<?php echo ''; ?>')"><?php echo $offType;?></td>
													<?php
													}
												}
												?>
												</tr>
												<?php
												}
												?>
								<!-- RHCA shifts -->
								<tr>
									<td bgcolor="#FFF9DF" colspan="22"><strong>RHCA Shifts</strong></td>
								</tr>
								<?php
								$user_qry=$conn->query("SELECT * FROM users WHERE `empType` = 'RHCA'" ) or die(mysqli_error());
								while($row=$user_qry->fetch_array()){
									?>	
									<tr>
										<td><?php echo $row['firstname'].' '.$row['lastname']?></td>
										<?php 
										for($j=0;$j<=20;$j++) {
											$chk = $conn->query("SELECT * FROM `schedule` WHERE `id` = '".$row['id']."' AND `dateInfo` = '".$result[$j]."'" );
											//check time off
											$chktoff = $conn->query("SELECT * FROM `emp_time_off` WHERE `id` = '".$row['id']."' AND `status` = 'A' AND (`startingdate` <= '".$result[$j]."' AND `endingdate` >= '".$result[$j]."')" );
											if($chktoff->num_rows > 0){
												$hasoff=$chktoff->fetch_array();
												$offType = '<br><strong><font color="red">'.$hasoff['leavetype'].'</font></strong>';
											} else {
												$offType = '';
											}
											//print
											if($chk->num_rows > 0) {
												$get=$chk->fetch_array();
												$notes = htmlspecialchars($get['notes'],ENT_QUOTES); ?>
												<td onclick="openModal('<?php echo $row['id']; ?>', '<?php echo $row['firstname']; ?>', '<?php echo $row['lastname']; ?>', '<?php echo $row['empType']; ?>', '<?php echo $result[$j]; ?>', '<?php echo $get['shift']; ?>', '<?php echo $notes; ?>')" <?php if($notes != ''){?> bgcolor="#D3D3D3" <?php } ?>><?php echo $get['shift']?><?php echo $offType;?></td>
												<?php 
												} else { 
													?>
													<td onclick="openModal('<?php echo $row['id']; ?>', '<?php echo $row['firstname']; ?>', '<?php echo $row['lastname']; ?>', '<?php echo $row['empType']; ?>', '<?php echo $result[$j]; ?>', '<?php echo ''; ?>', '<?php echo ''; ?>')"><?php echo $offType;?></td>
													<?php
												}
										}
										?>
									</tr>
									<?php
								}
								?>
								<!-- Housekeeping shifts -->
								<tr>
									<td bgcolor="#FFF9DF" colspan="22"><strong>Housekeeping Shifts</strong></td>
								</tr>
								<?php
								$user_qry=$conn->query("SELECT * FROM users WHERE `empType` = 'Housekeeping'" ) or die(mysqli_error());
								while($row=$user_qry->fetch_array()){
									?>
									<tr>
										<td><?php echo $row['firstname'].' '.$row['lastname']?></td>
										<?php 
										for($j=0;$j<=20;$j++) {
											$chk = $conn->query("SELECT * FROM `schedule` WHERE `id` = '".$row['id']."' AND `dateInfo` = '".$result[$j]."'" );
											//check time off
											$chktoff = $conn->query("SELECT * FROM `emp_time_off` WHERE `id` = '".$row['id']."' AND `status` = 'A' AND (`startingdate` <= '".$result[$j]."' AND `endingdate` >= '".$result[$j]."')" );
											if($chktoff->num_rows > 0){
												$hasoff=$chktoff->fetch_array();
												$offType = '<br><strong><font color="red">'.$hasoff['leavetype'].'</font></strong>';
											} else {
												$offType = '';
											}
											//print
											if($chk->num_rows > 0) {
												$get=$chk->fetch_array();
												$notes = htmlspecialchars($get['notes'],ENT_QUOTES); ?>
												<td onclick="openModal('<?php echo $row['id']; ?>', '<?php echo $row['firstname']; ?>', '<?php echo $row['lastname']; ?>', '<?php echo $row['empType']; ?>', '<?php echo $result[$j]; ?>', '<?php echo $get['shift']; ?>', '<?php echo $notes; ?>')" <?php if($notes != ''){?> bgcolor="#D3D3D3" <?php } ?>><?php echo $get['shift']?><?php echo $offType;?></td>
												<?php 
												} else { 
													?>
													<td onclick="openModal('<?php echo $row['id']; ?>', '<?php echo $row['firstname']; ?>', '<?php echo $row['lastname']; ?>', '<?php echo $row['empType']; ?>', '<?php echo $result[$j]; ?>', '<?php echo ''; ?>', '<?php echo ''; ?>')"><?php echo $offType;?></td>
													<?php
												}
											}
										?>
										</tr>
										<?php
									}
									?>
								<!-- Cook shifts -->
								<tr>
									<td bgcolor="#FFF9DF" colspan="22"><strong>Cook Shifts</strong></td>
								</tr>
								<?php
								$user_qry=$conn->query("SELECT * FROM users WHERE `empType` = 'Cook'" ) or die(mysqli_error());
								while($row=$user_qry->fetch_array()){
									?>	
									<tr>
										<td><?php echo $row['firstname'].' '.$row['lastname']?></td>
										<?php 
										for($j=0;$j<=20;$j++) {
											$chk = $conn->query("SELECT * FROM `schedule` WHERE `id` = '".$row['id']."' AND `dateInfo` = '".$result[$j]."'" );
											//check time off
											$chktoff = $conn->query("SELECT * FROM `emp_time_off` WHERE `id` = '".$row['id']."' AND `status` = 'A' AND (`startingdate` <= '".$result[$j]."' AND `endingdate` >= '".$result[$j]."')" );
											if($chktoff->num_rows > 0){
												$hasoff=$chktoff->fetch_array();
												$offType = '<br><strong><font color="red">'.$hasoff['leavetype'].'</font></strong>';
											} else {
												$offType = '';
											}
											//print
											if($chk->num_rows > 0) {
												$get=$chk->fetch_array();
												$notes = htmlspecialchars($get['notes'],ENT_QUOTES); ?>
												<td onclick="openModal('<?php echo $row['id']; ?>', '<?php echo $row['firstname']; ?>', '<?php echo $row['lastname']; ?>', '<?php echo $row['empType']; ?>', '<?php echo $result[$j]; ?>', '<?php echo $get['shift']; ?>', '<?php echo $notes; ?>')" <?php if($notes != ''){?> bgcolor="#D3D3D3" <?php } ?>><?php echo $get['shift']?><?php echo $offType;?></td>
												<?php 
														} else { 
															?>
														<td onclick="openModal('<?php echo $row['id']; ?>', '<?php echo $row['firstname']; ?>', '<?php echo $row['lastname']; ?>', '<?php echo $row['empType']; ?>', '<?php echo $result[$j]; ?>', '<?php echo ''; ?>', '<?php echo ''; ?>')"><?php echo $offType;?></td>
														<?php
														}
													}
													?>
												</tr>
												<?php
												}
												?>
												<!-- Psych social shifts -->
												<tr>
													<td bgcolor="#FFF9DF" colspan="22"><strong>Psych Social Shifts</strong></td>
												</tr>
												<?php
												$user_qry=$conn->query("SELECT * FROM users WHERE `empType` = 'PsychSocial'" ) or die(mysqli_error());
												while($row=$user_qry->fetch_array()){
													?>	
												<tr>
													<td><?php echo $row['firstname'].' '.$row['lastname']?></td>
													<?php 
													for($j=0;$j<=20;$j++) {
														$chk = $conn->query("SELECT * FROM `schedule` WHERE `id` = '".$row['id']."' AND `dateInfo` = '".$result[$j]."'" );
														//check time off
											$chktoff = $conn->query("SELECT * FROM `emp_time_off` WHERE `id` = '".$row['id']."' AND `status` = 'A' AND (`startingdate` <= '".$result[$j]."' AND `endingdate` >= '".$result[$j]."')" );
											if($chktoff->num_rows > 0){
												$hasoff=$chktoff->fetch_array();
												$offType = '<br><strong><font color="red">'.$hasoff['leavetype'].'</font></strong>';
											} else {
												$offType = '';
											}
											//print
														if($chk->num_rows > 0) {
															$get=$chk->fetch_array();
															$notes = htmlspecialchars($get['notes'],ENT_QUOTES); ?>
															<td onclick="openModal('<?php echo $row['id']; ?>', '<?php echo $row['firstname']; ?>', '<?php echo $row['lastname']; ?>', '<?php echo $row['empType']; ?>', '<?php echo $result[$j]; ?>', '<?php echo $get['shift']; ?>', '<?php echo $notes; ?>')" <?php if($notes != ''){?> bgcolor="#D3D3D3" <?php } ?>><?php echo $get['shift']?><?php echo $offType;?></td>
															<?php 
														} else { 
															?>
														<td onclick="openModal('<?php echo $row['id']; ?>', '<?php echo $row['firstname']; ?>', '<?php echo $row['lastname']; ?>', '<?php echo $row['empType']; ?>', '<?php echo $result[$j]; ?>', '<?php echo ''; ?>', '<?php echo ''; ?>')"><?php echo $offType;?></td>
														<?php
														}
													}
													?>
												</tr>
												<?php
												}
												?>
												<!-- Maintenance shifts -->
												<tr>
													<td bgcolor="#FFF9DF" colspan="22"><strong>Maintenance Shifts</strong></td>
												</tr>
												<?php
												$user_qry=$conn->query("SELECT * FROM users WHERE `empType` = 'Maintenance'" ) or die(mysqli_error());
												while($row=$user_qry->fetch_array()){
													?>	
												<tr>
													<td><?php echo $row['firstname'].' '.$row['lastname']?></td>
													<?php 
													for($j=0;$j<=20;$j++) {
														$chk = $conn->query("SELECT * FROM `schedule` WHERE `id` = '".$row['id']."' AND `dateInfo` = '".$result[$j]."'" );
														//check time off
											$chktoff = $conn->query("SELECT * FROM `emp_time_off` WHERE `id` = '".$row['id']."' AND `status` = 'A' AND (`startingdate` <= '".$result[$j]."' AND `endingdate` >= '".$result[$j]."')" );
											if($chktoff->num_rows > 0){
												$hasoff=$chktoff->fetch_array();
												$offType = '<br><strong><font color="red">'.$hasoff['leavetype'].'</font></strong>';
											} else {
												$offType = '';
											}
											//print
														if($chk->num_rows > 0) {
															$get=$chk->fetch_array();
															$notes = htmlspecialchars($get['notes'],ENT_QUOTES); ?>
															<td onclick="openModal('<?php echo $row['id']; ?>', '<?php echo $row['firstname']; ?>', '<?php echo $row['lastname']; ?>', '<?php echo $row['empType']; ?>', '<?php echo $result[$j]; ?>', '<?php echo $get['shift']; ?>', '<?php echo $notes; ?>')" <?php if($notes != ''){?> bgcolor="#D3D3D3" <?php } ?>><?php echo $get['shift']?><?php echo $offType;?></td>
															<?php 
														} else { 
															?>
														<td onclick="openModal('<?php echo $row['id']; ?>', '<?php echo $row['firstname']; ?>', '<?php echo $row['lastname']; ?>', '<?php echo $row['empType']; ?>', '<?php echo $result[$j]; ?>', '<?php echo ''; ?>', '<?php echo ''; ?>')"><?php echo $offType;?></td>
														<?php
														}
													}
													?>
												</tr>
												<?php
												}
												?>
											</tbody>
										</table>
										<br/>
										<br/>

											<!-- table 2 (3 weeks) -->
											<table id="table" class="table table-bordered table-striped">
												<thead>
													<tr>
														<th style="width: 12%">Employee Name</th>
														<?php 
														for($i=21;$i<=41;$i++){
															$result[$i]=date('Y-m-d', strtotime("$result[0] + $i day"));
															$week=date('D', strtotime("$result[0] + $i day"));
															$prt[$i]=date('y M d', strtotime("$result[$i]"));
															if($week == 'Sun'){
																echo '<th bgcolor="#FFCC00">'.$prt[$i].' '.$week.'</th>';
															} else {
																echo '<th>'.$prt[$i].' '.$week.'</th>';
															}
														}
														?>
													</tr>
												</thead>
												<tbody>

												<!-- RN shifts -->
													<tr>
														<td bgcolor="#FFF9DF" colspan="22"><strong>RN Shifts</strong></td>
													</tr>
													<?php
													$user_qry=$conn->query("SELECT * FROM users WHERE `empType` = 'RN'" ) or die(mysqli_error());
													while($row=$user_qry->fetch_array()){
														?>	
													<tr>
														<td><?php echo $row['firstname'].' '.$row['lastname']?></td>
														<?php 
														for($j=21;$j<=41;$j++) {
															$chk = $conn->query("SELECT * FROM `schedule` WHERE `id` = '".$row['id']."' AND `dateInfo` = '".$result[$j]."'" );
															//check time off
											$chktoff = $conn->query("SELECT * FROM `emp_time_off` WHERE `id` = '".$row['id']."' AND `status` = 'A' AND (`startingdate` <= '".$result[$j]."' AND `endingdate` >= '".$result[$j]."')" );
											if($chktoff->num_rows > 0){
												$hasoff=$chktoff->fetch_array();
												$offType = '<br><strong><font color="red">'.$hasoff['leavetype'].'</font></strong>';
											} else {
												$offType = '';
											}
											//print
															if($chk->num_rows > 0) {
																$get=$chk->fetch_array();
																$notes = htmlspecialchars($get['notes'],ENT_QUOTES); ?>
																
																<td onclick="openModal('<?php echo $row['id']; ?>', '<?php echo $row['firstname']; ?>', '<?php echo $row['lastname']; ?>', '<?php echo $row['empType']; ?>', '<?php echo $result[$j]; ?>', '<?php echo $get['shift']; ?>', '<?php echo $notes; ?>')" <?php if($notes != ''){?> bgcolor="#D3D3D3" <?php } ?>><?php echo $get['shift']?><?php echo $offType;?></td>
																<?php 
															} else { 
																?>
															<td onclick="openModal('<?php echo $row['id']; ?>', '<?php echo $row['firstname']; ?>', '<?php echo $row['lastname']; ?>', '<?php echo $row['empType']; ?>', '<?php echo $result[$j]; ?>', '<?php echo ''; ?>', '<?php echo ''; ?>')"><?php echo $offType;?></td>
															<?php
															}
														}
														?>
													</tr>
													<?php
													}
													?>

													<tr>
														<td bgcolor="#FFF9DF" colspan="22"><strong>RHCA Shifts</strong></td>
													</tr>
													<?php
													$user_qry=$conn->query("SELECT * FROM users WHERE `empType` = 'RHCA'" ) or die(mysqli_error());
													while($row=$user_qry->fetch_array()){
														?>	
													<tr>
														<td><?php echo $row['firstname'].' '.$row['lastname']?></td>
														<?php 
														for($j=21;$j<=41;$j++) {
															$chk = $conn->query("SELECT * FROM `schedule` WHERE `id` = '".$row['id']."' AND `dateInfo` = '".$result[$j]."'" );
															//check time off
											$chktoff = $conn->query("SELECT * FROM `emp_time_off` WHERE `id` = '".$row['id']."' AND `status` = 'A' AND (`startingdate` <= '".$result[$j]."' AND `endingdate` >= '".$result[$j]."')" );
											if($chktoff->num_rows > 0){
												$hasoff=$chktoff->fetch_array();
												$offType = '<br><strong><font color="red">'.$hasoff['leavetype'].'</font></strong>';
											} else {
												$offType = '';
											}
											//print
															if($chk->num_rows > 0) {
																$get=$chk->fetch_array();
																$notes = htmlspecialchars($get['notes'],ENT_QUOTES); ?>
																<td onclick="openModal('<?php echo $row['id']; ?>', '<?php echo $row['firstname']; ?>', '<?php echo $row['lastname']; ?>', '<?php echo $row['empType']; ?>', '<?php echo $result[$j]; ?>', '<?php echo $get['shift']; ?>', '<?php echo $notes; ?>')" <?php if($notes != ''){?> bgcolor="#D3D3D3" <?php } ?>><?php echo $get['shift']?><?php echo $offType;?></td>
																<?php 
															} else { 
																?>
															<td onclick="openModal('<?php echo $row['id']; ?>', '<?php echo $row['firstname']; ?>', '<?php echo $row['lastname']; ?>', '<?php echo $row['empType']; ?>', '<?php echo $result[$j]; ?>', '<?php echo ''; ?>', '<?php echo ''; ?>')"><?php echo $offType;?></td>
															<?php
															}
														}
														?>
													</tr>
													<?php
													}
													?>

													<tr>
														<td bgcolor="#FFF9DF" colspan="22"><strong>Housekeeping Shifts</strong></td>
													</tr>
													<?php
													$user_qry=$conn->query("SELECT * FROM users WHERE `empType` = 'Housekeeping'" ) or die(mysqli_error());
													while($row=$user_qry->fetch_array()){
														?>	
													<tr>
														<td><?php echo $row['firstname'].' '.$row['lastname']?></td>
														<?php 
														for($j=21;$j<=41;$j++) {
															$chk = $conn->query("SELECT * FROM `schedule` WHERE `id` = '".$row['id']."' AND `dateInfo` = '".$result[$j]."'" );
															//check time off
											$chktoff = $conn->query("SELECT * FROM `emp_time_off` WHERE `id` = '".$row['id']."' AND `status` = 'A' AND (`startingdate` <= '".$result[$j]."' AND `endingdate` >= '".$result[$j]."')" );
											if($chktoff->num_rows > 0){
												$hasoff=$chktoff->fetch_array();
												$offType = '<br><strong><font color="red">'.$hasoff['leavetype'].'</font></strong>';
											} else {
												$offType = '';
											}
											//print
															if($chk->num_rows > 0) {
																$get=$chk->fetch_array();
																$notes = htmlspecialchars($get['notes'],ENT_QUOTES); ?>
																<td onclick="openModal('<?php echo $row['id']; ?>', '<?php echo $row['firstname']; ?>', '<?php echo $row['lastname']; ?>', '<?php echo $row['empType']; ?>', '<?php echo $result[$j]; ?>', '<?php echo $get['shift']; ?>', '<?php echo $notes; ?>')" <?php if($notes != ''){?> bgcolor="#D3D3D3" <?php } ?>><?php echo $get['shift']?><?php echo $offType;?></td>
																<?php 
															} else { 
																?>
															<td onclick="openModal('<?php echo $row['id']; ?>', '<?php echo $row['firstname']; ?>', '<?php echo $row['lastname']; ?>', '<?php echo $row['empType']; ?>', '<?php echo $result[$j]; ?>', '<?php echo ''; ?>', '<?php echo ''; ?>')"><?php echo $offType;?></td>
															<?php
															}
														}
														?>
													</tr>
													<?php
													}
													?>

													<tr>
														<td bgcolor="#FFF9DF" colspan="22"><strong>Cook Shifts</strong></td>
													</tr>
													<?php
													$user_qry=$conn->query("SELECT * FROM users WHERE `empType` = 'Cook'" ) or die(mysqli_error());
													while($row=$user_qry->fetch_array()){
														?>	
													<tr>
														<td><?php echo $row['firstname'].' '.$row['lastname']?></td>
														<?php 
														for($j=21;$j<=41;$j++) {
															$chk = $conn->query("SELECT * FROM `schedule` WHERE `id` = '".$row['id']."' AND `dateInfo` = '".$result[$j]."'" );
															//check time off
											$chktoff = $conn->query("SELECT * FROM `emp_time_off` WHERE `id` = '".$row['id']."' AND `status` = 'A' AND (`startingdate` <= '".$result[$j]."' AND `endingdate` >= '".$result[$j]."')" );
											if($chktoff->num_rows > 0){
												$hasoff=$chktoff->fetch_array();
												$offType = '<br><strong><font color="red">'.$hasoff['leavetype'].'</font></strong>';
											} else {
												$offType = '';
											}
											//print
															if($chk->num_rows > 0) {
																$get=$chk->fetch_array();
																$notes = htmlspecialchars($get['notes'],ENT_QUOTES); ?>
																<td onclick="openModal('<?php echo $row['id']; ?>', '<?php echo $row['firstname']; ?>', '<?php echo $row['lastname']; ?>', '<?php echo $row['empType']; ?>', '<?php echo $result[$j]; ?>', '<?php echo $get['shift']; ?>', '<?php echo $notes; ?>')" <?php if($notes != ''){?> bgcolor="#D3D3D3" <?php } ?>><?php echo $get['shift']?><?php echo $offType;?></td>
																<?php 
															} else { 
																?>
															<td onclick="openModal('<?php echo $row['id']; ?>', '<?php echo $row['firstname']; ?>', '<?php echo $row['lastname']; ?>', '<?php echo $row['empType']; ?>', '<?php echo $result[$j]; ?>', '<?php echo ''; ?>', '<?php echo ''; ?>')"><?php echo $offType;?></td>
															<?php
															}
														}
														?>
													</tr>
													<?php
													}
													?>
													
													<tr>
														<td bgcolor="#FFF9DF" colspan="22"><strong>Psych Social Shifts</strong></td>
													</tr>
													<?php
													$user_qry=$conn->query("SELECT * FROM users WHERE `empType` = 'PsychSocial'" ) or die(mysqli_error());
													while($row=$user_qry->fetch_array()){
														?>	
													<tr>
														<td><?php echo $row['firstname'].' '.$row['lastname']?></td>
														<?php 
														for($j=21;$j<=41;$j++) {
															$chk = $conn->query("SELECT * FROM `schedule` WHERE `id` = '".$row['id']."' AND `dateInfo` = '".$result[$j]."'" );
															//check time off
											$chktoff = $conn->query("SELECT * FROM `emp_time_off` WHERE `id` = '".$row['id']."' AND `status` = 'A' AND (`startingdate` <= '".$result[$j]."' AND `endingdate` >= '".$result[$j]."')" );
											if($chktoff->num_rows > 0){
												$hasoff=$chktoff->fetch_array();
												$offType = '<br><strong><font color="red">'.$hasoff['leavetype'].'</font></strong>';
											} else {
												$offType = '';
											}
											//print
															if($chk->num_rows > 0) {
																$get=$chk->fetch_array();
																$notes = htmlspecialchars($get['notes'],ENT_QUOTES); ?>
																<td onclick="openModal('<?php echo $row['id']; ?>', '<?php echo $row['firstname']; ?>', '<?php echo $row['lastname']; ?>', '<?php echo $row['empType']; ?>', '<?php echo $result[$j]; ?>', '<?php echo $get['shift']; ?>', '<?php echo $notes; ?>')" <?php if($notes != ''){?> bgcolor="#D3D3D3" <?php } ?>><?php echo $get['shift']?><?php echo $offType;?></td>
																<?php 
															} else { 
																?>
															<td onclick="openModal('<?php echo $row['id']; ?>', '<?php echo $row['firstname']; ?>', '<?php echo $row['lastname']; ?>', '<?php echo $row['empType']; ?>', '<?php echo $result[$j]; ?>', '<?php echo ''; ?>', '<?php echo ''; ?>')"><?php echo $offType;?></td>
															<?php
															}
														}
														?>
													</tr>
													<?php
													}
													?>

													<tr>
														<td bgcolor="#FFF9DF" colspan="22"><strong>Maintenance Shifts</strong></td>
													</tr>
													<?php
													$user_qry=$conn->query("SELECT * FROM users WHERE `empType` = 'Maintenance'" ) or die(mysqli_error());
													while($row=$user_qry->fetch_array()){
														?>	
													<tr>
														<td><?php echo $row['firstname'].' '.$row['lastname']?></td>
														<?php 
														for($j=21;$j<=41;$j++) {
															$chk = $conn->query("SELECT * FROM `schedule` WHERE `id` = '".$row['id']."' AND `dateInfo` = '".$result[$j]."'" );
															//check time off
											$chktoff = $conn->query("SELECT * FROM `emp_time_off` WHERE `id` = '".$row['id']."' AND `status` = 'A' AND (`startingdate` <= '".$result[$j]."' AND `endingdate` >= '".$result[$j]."')" );
											if($chktoff->num_rows > 0){
												$hasoff=$chktoff->fetch_array();
												$offType = '<br><strong><font color="red">'.$hasoff['leavetype'].'</font></strong>';
											} else {
												$offType = '';
											}
											//print
															if($chk->num_rows > 0) {
																$get=$chk->fetch_array();
																$notes = htmlspecialchars($get['notes'],ENT_QUOTES); ?>
																<td onclick="openModal('<?php echo $row['id']; ?>', '<?php echo $row['firstname']; ?>', '<?php echo $row['lastname']; ?>', '<?php echo $row['empType']; ?>', '<?php echo $result[$j]; ?>', '<?php echo $get['shift']; ?>', '<?php echo $notes; ?>')" <?php if($notes != ''){?> bgcolor="#D3D3D3" <?php } ?>><?php echo $get['shift']?><?php echo $offType;?></td>
																<?php 
															} else { 
																?>
															<td onclick="openModal('<?php echo $row['id']; ?>', '<?php echo $row['firstname']; ?>', '<?php echo $row['lastname']; ?>', '<?php echo $row['empType']; ?>', '<?php echo $result[$j]; ?>', '<?php echo ''; ?>', '<?php echo ''; ?>')"><?php echo $offType;?></td>
															<?php
															}
														}
														?>
													</tr>
													<?php
													}
													?>
										</tbody>
							</table>
							</br>
						<label><strong>RN/RHCA Shift Hours:</strong></label>
						<p><strong>D:</strong> 07:00 - 15:00; <strong>ds:</strong> 08:00 - 15:00; <strong>E:</strong> 15:00 - 23:00; <strong>es:</strong> 15:00 - 21:30; <strong>N:</strong> 23:00 - 07:00;</p>
						<label><strong>Leave Type:</strong></label>
						<p><strong>V:</strong> Vacation; <strong>S:</strong> Sick; <strong>U:</strong> Union; <strong>SE:</strong> Shift Exchange; <strong>LOA:</strong> Leave of Absence; <strong>EDU:</strong> Education; <strong>B:</strong> Bereavement; <strong>LV:</strong> Left Vacant; <strong>SM:</strong> Staff Meeting;</p>
					</br>
				</br>
			</br>
		</div>		
	</div>
			<!-- Ending -->

			<div class="modal fade" id="manage_schedule" tabindex="-1" role="dialog" aria-labelledby="manage_schedulelabel">
				<div class="modal-dialog modal-dialog-centered"  role="document">
					<div class="modal-content panel-primary">
						<div class="modal-header panel-heading">
							<h4 class="modal-title">Shift Information</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>
						<form id="user-frm">
							<div class ="modal-body">
								<input type="hidden" name='id'>
								<input type="hidden" name='firstname'>
								<input type="hidden" name='lastname'>
								<input type="hidden" name='empType'>
								<input type="hidden" name='dateInfo'>
								<div class="form-group">
									<label>Shift:</label>
									<input type="text" name="shift" maxlength="15" class="form-control" />
								</div>
								<div class="form-group">
  									<label for="notes_textbox">Notes</label>
 									 <textarea class="form-control rounded-0" name="notes" id="notes" rows="3" maxlength="100"></textarea>
									  <p>(Maximum 100 characters)</p>
								</div>
							</div>
							<div class="modal-footer">
								<button  class="btn btn-primary" name="save">Save</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			</br>
			</br>
			<?php include 'footer.php' ?>
	</body>
	<script src = "../assets/js/navbar.js"></script>
	<script type="text/javascript">
		function openModal(id, firstname, lastname, empType, dateInfo, shift, notes){
			var id=id;
			var firstname=firstname;
			var lastname=lastname;
			var empType=empType;
			var dateInfo=dateInfo;
			var shift=shift;
			var notes=notes;
			$('[name="id"]').val(id)
			$('[name="firstname"]').val(firstname)
			$('[name="lastname"]').val(lastname)
			$('[name="empType"]').val(empType)
			$('[name="dateInfo"]').val(dateInfo)
			$('[name="shift"]').val(shift)
			$('[name="notes"]').val(notes)
			$('#manage_schedule').modal('show')
		;}  

	    $(document).ready(function(){		
			$('#user-frm').submit(function(e){
				e.preventDefault()
				$('#user-frm [name="submit"]').attr('disabled',false)
				$('#user-frm [name="submit"]').html('Save')
				$.ajax({
					url:'update_schedule.php',
					method:"POST",
					data:$(this).serialize(),
					error:err=>console.log(),
					success:function(resp){
						if(typeof resp !=undefined){
							resp = JSON.parse(resp)
							if(resp.status == 1){
								location.reload();
							} else {
								alert(resp.msg);
							}
						}
					}
				})
			})	
		});

	</script>
		<script type="text/javascript">
		$(document).ready(function(){
			$('#table').DataTable({
				'fixedHeader': true
			});
		});
	</script>
</html>

<?php
}
?>