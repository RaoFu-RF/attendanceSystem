<!DOCTYPE html>
<?php
	require_once 'auth.php';
	if ($role == 'manager') {
?>
<html lang="eng">
	<head>
		<title>Manage Employee</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="../assets/css/navbar.css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
		<?php include 'header.php'; ?>
	</head>
	<body>
		<?php include 'nav_bar.php' ?>

		<div class="container-fluid">
			<center>
				<h2><strong>Manage Employee</strong></h2>
			</center>
			<br/>

			<div class="well col-lg-12">
				<button type="button" class="btn btn-primary btn-sm" id="new_user"><i class="fa fa-user-plus"></i> Add New</button>
				<br />
				<br />
				<table id="table" class="table table-bordered table-striped">
					<thead>
						<tr bgcolor="#E6B8AC">
							<th>Firstname</th>
							<th>Lastname</th>
							<th>E-mail</th>
							<th>Phone</th>
							<th>Date Of Hired</th>
							<th>Role</th>
							<th>Employee Type</th>
							<th>Category</th>
							<th>Total Hours</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php
					//current year
					$currentyear = date('Y');
					$firstdateofyear = $currentyear.'-01-01';
					$lastdateofyear = $currentyear.'-12-31';

					$user_qry=$conn->query("SELECT * FROM users") or die(mysqli_error());
					while($row=$user_qry->fetch_array()){
						//initialize total worked hrs for each user
						$totalreg = 0;
						$totalot = 0;
						$total = 0;
						$user_total=$conn->query("SELECT * FROM timesheet WHERE `id` = '".$row['id']."' AND (`dateInfo` >= '".$firstdateofyear."' AND `dateInfo` <= '".$lastdateofyear."')") or die(mysqli_error());
						while($get=$user_total->fetch_array()){
							$totalreg = $totalreg + $get['regular'];
							$totalot = $totalot + $get['ot'];
						}
						$total = $totalreg + $totalot;?>

						<tr>
							<td><?php echo $row['firstname']?></td>
							<td><?php echo htmlentities($row['lastname'])?></td>
							<td><?php echo $row['email']?></td>
							<td><?php echo $row['phone']?></td>
							<td><?php echo $row['dateHired']?></td>
							<td><?php echo $row['role']?></td>
							<td><?php echo $row['empType']?></td>
							<td><?php echo $row['category']?></td>
							<td><?php echo $total?></td>
							<td>
								<?php
								if($row['id'] != $id){?>
								<center>
								 <button class="btn btn-sm btn-outline-primary edit_user" data-toggle="tooltip" data-placement="top" title="Edit" data-id="<?php echo $row['id']?>" type="button"><i class="fa fa-pencil"></i></button>
								 <button class="btn btn-sm btn-outline-primary edit_password" data-toggle="tooltip" data-placement="top" title="Reset Password" data-id="<?php echo $row['id']?>" type="button"><i class="fa fa-repeat"></i></button>
								<button class="btn btn-sm btn-outline-danger remove_user" data-toggle="tooltip" data-placement="top" title="Delete" data-id="<?php echo $row['id']?>" type="button"><i class="fa fa-trash"></i></button>
								</center>
								<?php }?>
							</td>
						</tr>

					<?php
						}
					?>
					</tbody>
				</table>
				<br />
				<br />	
				<br />		
			</div>
		</div>
		
		<div class="modal fade" id="manage_user" tabindex="-1" role="dialog" aria-labelledby="manage_userlabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content panel-primary">
					<div class="modal-header panel-heading">
						<h4 class="modal-title"></h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<form id="user-frm">
						<div class ="modal-body">
							<input type="hidden" name='id'/>
							<div class="form-group">
								<label>Firstname</label>
								<input type="text" name="firstname" required="required" maxlength="20" class="form-control" />
							</div>
							<div class="form-group">
								<label>Lastname</label>
								<input type="text" name="lastname" required="required" maxlength="20" class="form-control" />
							</div>
							<div class="form-group">
								<label>E-mail</label>
								<input type="email" name ="email" required="required" maxlength="50" class="form-control" />
							</div>
							<div class="form-group">
								<label>Phone</label>
								<input type="text" name="phone" required="required" maxlength="20" class="form-control" />
							</div>
							<div class="form-group">
								<label>Create Password</label>
								<input type="password" maxlength="20" required="required" name="password" class="form-control" />
							</div>
							<div class="form-group">
								<label>Date Of Hired</label>
								<input type="date" name="dateHired" required="required" class="form-control" />
							</div>
							<div class="form-group">
								<label>Role</label>
								<select name="role" required="required" class="form-control">
									<option value="employee">Employee</option>
									<option value="manager">Manager</option>
								</select>
							</div>
							<div class="form-group">
								<label>Employee Type</label>
								<select name="empType" required="required" class="form-control">
									<option value="RN">RN</option>
									<option value="RHCA">RHCA</option>
									<option value="Housekeeping">Housekeeping</option>
									<option value="Cook">Cook</option>
									<option value="PsychSocial">Psych Social</option>
									<option value="Maintenance">Maintenance</option>
								</select>
							</div>
							<div class="form-group">
								<label>Category</label>
								<select name="category" required="required" class="form-control">
									<option value="Casual">Casual</option>
									<option value="Regular">Regular</option>
								</select>
							</div>
						</div>
						<div class="modal-footer">
							<button  class="btn btn-primary" name="submit">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>






		<div class="modal fade" id="edit_user" tabindex="-1" role="dialog" aria-labelledby="edit_userlabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content panel-primary">
					<div class="modal-header panel-heading">
						<h4 class="modal-title">Edit User</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<form id="edit-user-frm">
						<div class ="modal-body">
							<input type="hidden" name='id'/>
							<div class="form-group">
								<label>Firstname</label>
								<input type="text" name="firstname" maxlength="20" required="required" class="form-control" />
							</div>
							<div class="form-group">
								<label>Lastname</label>
								<input type="text" name="lastname" maxlength="20" required="required" class="form-control" />
							</div>
							<div class="form-group">
								<label>E-mail</label>
								<input type="email" name ="email" maxlength="50" required="required" class="form-control" />
							</div>
							<div class="form-group">
								<label>Phone</label>
								<input type="text" name="phone" maxlength="20" required="required" class="form-control" />
							</div>
							<div class="form-group">
								<label>Date Of Hired</label>
								<input type="date" name="dateHired" required="required" class="form-control" />
							</div>
							<div class="form-group">
								<label>Role</label>
								<select name="role" required="required" class="form-control">
									<option value="employee">Employee</option>
									<option value="manager">Manager</option>
								</select>
							</div>
							<div class="form-group">
								<label>Employee Type</label>
								<select name="empType" required="required" class="form-control">
									<option value="RN">RN</option>
									<option value="RHCA">RHCA</option>
									<option value="Housekeeping">Housekeeping</option>
									<option value="Cook">Cook</option>
									<option value="PsychSocial">Psych Social</option>
									<option value="Maintenance">Maintenance</option>
								</select>
							</div>
							<div class="form-group">
								<label>Category</label>
								<select name="category" required="required" class="form-control">
									<option value="Casual">Casual</option>
									<option value="Regular">Regular</option>
								</select>
							</div>
						</div>
						<div class="modal-footer">
							<button  class="btn btn-primary" name="submit">Submit</button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div class="modal fade" id="manage_user_password" tabindex="-1" role="dialog" aria-labelledby="manage_user_passwordlabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content panel-primary">
					<div class="modal-header panel-heading">
						<h4 class="modal-title"></h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<form id="password-frm">
						<div class ="modal-body">
							<input type="hidden" name='id'/>
		
							<div class="form-group">
								<label>New Password</label>
								<input type="password" maxlength="20" required="required" name="password" class="form-control" />
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
			$('#table').DataTable({
				'paging': false
			});
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#user-frm').submit(function(e){
				e.preventDefault()
				$('#user-frm [name="submit"]').attr('disabled',false)
				$('#user-frm [name="submit"]').html('Save')
				$.ajax({
					url:'save_user.php',
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
			
			$('#edit-user-frm').submit(function(e){
				e.preventDefault()
				$('#edit-user-frm [name="submit"]').attr('disabled',false)
				$('#edit-user-frm [name="submit"]').html('Save')
				$.ajax({
					url:'update_user.php',
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

			$('#password-frm').submit(function(e){
				e.preventDefault()
				$('#password-frm [name="submit"]').attr('disabled',false)
				$('#password-frm [name="submit"]').html('Save')
				$.ajax({
					url:'update_user_password.php',
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

			$('.remove_user').click(function(){
				var id=$(this).attr('data-id');
				var _conf = confirm("Are you sure you want to delete this user?");		

				if(_conf == true){
					$.ajax({
						url:'delete_user.php?id='+id,
						error:err=>console.log(err),
						success:function(resp){
							if(typeof resp != undefined){
								resp = JSON.parse(resp)
								if(resp.status == 1){
									alert(resp.msg);
									location.reload()
								}else{
									alert(resp.msg);
								}
							}
						}
					})
				}
			});

			$('.edit_user').click(function(){
				var $id=$(this).attr('data-id');
				$.ajax({
					url:'get_user.php',
					method:"POST",
					data:{id:$id},
					error:err=>console.log(),
					success:function(resp){
						if(typeof resp !=undefined){
							resp = JSON.parse(resp)
							$('[name="id"]').val(resp.id)
							$('[name="firstname"]').val(resp.firstname)
							$('[name="lastname"]').val(resp.lastname)
							$('[name="email"]').val(resp.email)
							$('[name="phone"]').val(resp.phone)
							$('[name="dateHired"]').val(resp.dateHired)
							$('[name="role"]').val(resp.role)
							$('[name="empType"]').val(resp.empType)
							$('[name="category"]').val(resp.category)
							$('#edit_user').modal('show')
						}
					}
				})
				
			});

			$('#new_user').click(function(){
				$('[name="id"]').val('')
				$('[name="firstname"]').val('')
				$('[name="lastname"]').val('')
				$('[name="email"]').val('')
				$('[name="phone"]').val('')
				$('[name="password"]').val('')
				$('[name="dateHired"]').val('')
				$('[name="role"]').val('')
				$('[name="empType"]').val('')
				$('[name="category"]').val('')
				$('#manage_user .modal-title').html('Add New User')
				$('#manage_user').modal('show')
			})
			$(document).ready(function(){
				$('[data-toggle="tooltip"]').tooltip();   
			})	
		});
	</script>
</html>

<?php 
	}
?>