<!DOCTYPE html>
<?php
	require_once 'auth.php';
	if ($role == 'employee') {
?>
<html lang="eng">
	<head>
		<title>Request</title>
		<meta charset="utf-8" />
		<?php include 'header.php' ?>
		<link rel="stylesheet" href="../assets/css/navbar.css">
	</head>
	<body>
	<?php include 'nav_bar.php' ?>

	<div class="container-fluid">
		<center><h2><strong>Request</strong></h2></center>
		<br/>

		<div class="well col-lg-12">
			<button type="button" class="btn btn-primary btn-sm" id="new_request"><i class="fa fa-plus"></i> New Request</button>
			<br />
			<br />
			<table id="table" class="table table-bordered table-striped">
				<thead>
						<tr bgcolor="#B6C5F2">
							<th>Firstname</th>
							<th>Lastname</th>
							<th>Starting Date</th>
							<th>Ending Date</th>
							<th>Type</th>
							<th>Notes</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
					<?php
						$user_qry=$conn->query("SELECT * FROM emp_time_off WHERE `id` = '".$id."'" ) or die(mysqli_error());
						while($row=$user_qry->fetch_array()){
					?>	
						<tr>
							<td><?php echo $row['firstname']?></td>
							<td><?php echo htmlentities($row['lastname'])?></td>
							<td><?php echo $row['startingdate']?></td>
							<td><?php echo $row['endingdate']?></td>
							<td><?php echo $row['leavetype']?></td>
							<td style="word-break:break-all" width="300"><?php echo $row['notes']?></td>
							<td><?php echo $row['status']?></td>

							<td>
								<?php
								if ($row['status'] == 'P') {
									?>
								<center>
								 <button class="btn btn-sm btn-outline-primary edit_request" data-id="<?php echo $row['request_id']?>" type="button"><i class="fa fa-edit"></i></button>
								<button class="btn btn-sm btn-outline-danger remove_request" data-id="<?php echo $row['request_id']?>" type="button"><i class="fa fa-trash"></i></button>
								</center>
								<?php
									} elseif ($row['status'] != 'P'){
										echo 'Not Available';
									}
								?>
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
		
			<div class="modal fade" id="manage_request" tabindex="-1" role="dialog" aria-labelledby="manage_requestlabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content panel-primary">
						<div class="modal-header panel-heading">
							<h4 class="modal-title"></h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>
						<form id="user-frm">
							<div class ="modal-body">
								<input type="hidden" name='request_id'>
								<input type="hidden" name="id" class="form-control" />
								<input type="hidden" name="firstname" class="form-control" />
								<input type="hidden" name="lastname" class="form-control" />
								<input type="hidden" name="status" class="form-control" />							
								<div class="form-group">
									<label>Starting Date</label>
									<input type="date" name="startingdate" id="startDate" required="required" class="form-control" />
								</div>
								<div class="form-group">
									<label>Ending Date</label>
									<input type="date" name="endingdate" id="endDate" required="required" class="form-control" />
								</div>
								<div class="form-group">
									<label>Type</label>
									<select name="leavetype" required="required" class="form-control">
										<option value="S">Sick</option>
										<option value="V">Vacation</option>
										<option value="U">Union</option>
										<option value="SE">Shift Exchange</option>
										<option value="LOA">Leave of Absence</option>
										<option value="EDU">Education</option>
										<option value="B">Bereavement</option>
										<option value="LV">Left Vacant</option>
										<option value="SM">Staff Meeting</option>
										<option value="OT">Over Time</option>
									</select>
								</div>
								<div class="form-group">
  									<label for="notes_textbox">Notes</label>
 									 <textarea class="form-control rounded-0" name="notes" id="notes" rows="3" maxlength="200"></textarea>
									  <p>(Maximum 200 characters)</p>
								</div>
							</div>
							<div class="modal-footer">
								<button  class="btn btn-primary" name="save">Submit</button>
							</div>
						</form>
					</div>
				</div>
				</div>
			</div>
			</div><!-- Main Col END -->
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
			var dtToday = new Date();
			var month = dtToday.getMonth() + 1;
			var day = dtToday.getDate();
			var year = dtToday.getFullYear();
			if(month < 10)
			month = '0' + month.toString();
			if(day < 10)
			day = '0' + day.toString();
			var maxDate = year + '-' + month + '-' + day;
			$('#startDate').attr('min', maxDate);
			$('#endDate').attr('min', maxDate);

			$('#user-frm').submit(function(e){
				e.preventDefault()
				$('#user-frm [name="submit"]').attr('disabled',false)
				$('#user-frm [name="submit"]').html('Save')
				$.ajax({
					url:'save_request.php',
					method:"POST",
					data:$(this).serialize(),
					error:err=>console.log(),
					success:function(resp){
						if(typeof resp !=undefined){
							resp = JSON.parse(resp)
							if(resp.status == 1){
								location.reload();
							}else{
								alert(resp.msg);
							}
						}
					}
				})
			})

			$('.remove_request').click(function(){
				var request_id=$(this).attr('data-id');
				var _conf = confirm("Are you sure you want to delete this request?");		

				if(_conf == true){
					$.ajax({
						url:'delete_request.php?request_id='+request_id,
						error:err=>console.log(err),
						success:function(resp){
							if(typeof resp != undefined){
								resp = JSON.parse(resp)
								if(resp.status == 1){
									location.reload()
								}
							}
						}
					})
				}
			});

			$('.edit_request').click(function(){
				var $request_id=$(this).attr('data-id');
				$.ajax({
					url:'get_request.php',
					method:"POST",
					data:{request_id:$request_id},
					error:err=>console.log(),
					success:function(resp){
						if(typeof resp !=undefined){
							resp = JSON.parse(resp)
							$('[name="request_id"]').val(resp.request_id)
							$('[name="id"]').val(resp.id)
							$('[name="firstname"]').val(resp.firstname)
							$('[name="lastname"]').val(resp.lastname)
							$('[name="startingdate"]').val(resp.startingdate)
							$('[name="endingdate"]').val(resp.endingdate)
							$('[name="leavetype"]').val(resp.leavetype)
							$('[name="notes"]').val(resp.notes)
							$('[name="status"]').val(resp.status)
							$('#manage_request .modal-title').html('Edit Request')
							$('#manage_request').modal('show')
						}
					}
				})
			});
			$('#new_request').click(function(){
				$('[name="request_id"]').val('')
				$('[name="id"]').val('<?php echo $id; ?>')
				$('[name="firstname"]').val('<?php echo $user_fname; ?>')
				$('[name="lastname"]').val('<?php echo $user_lname; ?>')
				$('[name="startingdate"]').val('')
				$('[name="endingdate"]').val('')
				$('[name="leavetype"]').val('')
				$('[name="notes"]').val('')
				$('[name="status"]').val('P')
				$('#manage_request .modal-title').html('New Request')
				$('#manage_request').modal('show')
			})
		});
	</script>
</html>

<?php 
	}
?>