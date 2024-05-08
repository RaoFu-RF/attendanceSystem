<!DOCTYPE html>
<?php
	require_once 'auth.php';
	if ($role == 'employee') {
?>
<html lang="eng">
	<head>
        <title>Timesheet</title>
		<meta charset="utf-8" />
        <link rel = "stylesheet" type = "text/css" href = "../assets/css/bootstrap.min.css" />
		<link rel = "stylesheet" type = "text/css" href = "https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
		<link rel = "stylesheet" type = "text/css" href = "https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" />
		<link rel = "stylesheet" type = "text/css" href = "../assets/css/style.css" />
		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
		<script src = "../assets/js/jquery-3.5.1.min.js"></script>
		<script src = "../assets/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="../assets/css/navbar.css">
		<script src = "../assets/js/jquery.table2excel.js"></script>
		<script language="JavaScript" type="text/javascript">
		function ExportToExcel() {      
         $("#table").table2excel({
           exclude : ".noExl", 
           filename : "Timesheet.xls", 
           name: "Excel Document Name.xlsx",
           exclude_img: false,
           exclude_links: true,
           exclude_inputs: true
         });            
		}
		</script>
	</head>
	<body>
		<?php include 'nav_bar.php' ?>			
		<div class="container-fluid" >		

            <div class="padding-down">

                <!-- Start  -->
				<center><h2><strong>Timesheet</strong></h2></center>
				<br/>
                <!-- Select date -->
                <form action="" method="post">
                    <table border="0">
                        <tr>
                            <td><strong>Select a starting week:&nbsp;</strong></td>
                            <td><input type="date" name="selectDate" required="required"></td>
                            <td colspan="2" align="right">
                                <input type="submit" value="Submit">
                            </td>
                        </tr>
                    </table>
                </form>
                <br/>
                <button type="button" data-toggle="tooltip" data-placement="top" title="Export To Excel" class = "btn btn-warning" id="btnExport" onclick="ExportToExcel();">Export</button>
				<br/>
				<br/>
                <!-- assign date to variable -->
                <?php 
                $result = array();
                $week = array();
                $temp = -7;
                if(!($_POST)){
                    if(date('w') == 0) {
                        for($i=0;$i<=13;$i++){
                            $result[$i]=date('Y-m-d', strtotime("+$temp day"));
                            $week[$i]=date('D', strtotime("+$temp day"));
                            $temp++;
                        }
                    } elseif(date('w') != 0){
                        for($i=0;$i<=13;$i++){
                            $result[$i]=date('Y-m-d', strtotime("last sunday +$temp day"));
                            $week[$i]=date('D', strtotime("last sunday +$temp day"));
                            $temp++;
                        }
                    }
                } elseif($_POST) {
                    $selectDate = $_POST['selectDate'];
					for($i=0;$i<=13;$i++){
						$result[$i]=date('Y-m-d', strtotime("$selectDate + $i day"));
						$week[$i]=date('D', strtotime("$selectDate + $i day"));	
					}
                }
                ?>

				<!-- print table -->
                <table id="table" class="table table-bordered table-striped">
					<thead>
						<tr bgcolor="#C9DFA7">
							<th>Date</th>
							<th>Time In</th>
							<th>Time Out</th>
							<th>Shift</th>
							<th>Lunch</th>
							<th>Sick</th>
							<th>Vacation</th>
							<th>Regular</th>
							<th>OT</th>
                            <th>Comments</th>
							<th class="noExl">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$lch = 0;
						$s = 0;
						$vac = 0;
						$reg = 0;
						$overtime = 0;
						for($j=0;$j<=13;$j++) {
							$user_qry=$conn->query("SELECT * FROM timesheet WHERE `dateInfo` = '".$result[$j]."' AND `id` = '".$id."'") or die(mysqli_error());
							while($get=$user_qry->fetch_array()){
								 ?>
								<tr>
									<td><?php echo $get['dateInfo'].' '.$week[$j]?></td>
									<td><?php echo $get['timein']?></td>
									<td><?php echo $get['timeout']?></td>
									<td><?php echo $get['shift']?></td>
									<td><?php echo $get['lunch']?></td>
									<td><?php echo $get['sick']?></td>
									<td><?php echo $get['vacation']?></td>
									<td><?php echo $get['regular']?></td>
									<td><?php echo $get['ot']?></td>
									<td><?php echo $get['notes']?></td>
									<td class="noExl">
										<?php if(($get['regular'] == '') && ($get['timeout'] != '')){ ?>
										<center>
											<button class="btn btn-sm btn-outline-primary edit_timesheet" data-toggle="tooltip" data-placement="top" title="Edit Timesheet"  data-id="<?php echo $get['id']?>" data-dateInfo="<?php echo $get['dateInfo']?>" data-timein="<?php echo $get['timein']?>" data-timeout="<?php echo $get['timeout']?>" type="button"><i class="fa fa-edit"></i></button>
										</center>
										<?php } ?>
									</td>
								</tr>
								<?php
								//calculate totals
								if($get['lunch'] == 'Yes'){
									$lch++;
								}
								$s = $s + $get['sick'];
								$vac = $vac + $get['vacation'];
								$reg = $reg + $get['regular'];
								$overtime = $overtime + $get['ot'];
							}
						} ?>
						<tr>
							<td bgcolor="#E3EFD1" colspan="1"><strong>Total: </strong></td>
							<td bgcolor="#FFFFF0" colspan="2"><strong>No. of lunch: <?php echo $lch; ?></strong></td>
							<td bgcolor="#E3EFD1" colspan="2"><strong>Sick Hrs: <?php echo $s; ?></strong></td>
							<td bgcolor="#FFFFF0" colspan="2"><strong>Vac Hrs: <?php echo $vac; ?></strong></td>
							<td bgcolor="#E3EFD1" colspan="2"><strong>Reg: <?php echo $reg; ?></strong></td>
							<td bgcolor="#FFFFF0" colspan="2"><strong>OT: <?php echo $overtime; ?><strong></td>
						</tr>
					</tbody>
				</table>
                <br />
                <br />		
            </div>
        </div>
		
		<!-- modal: form -->
        <div class="modal fade" id="manage_timesheet" tabindex="-1" role="dialog" aria-labelledby="manage_timesheetlabel">
				<div class="modal-dialog" role="document">
					<div class="modal-content panel-primary">
						<div class="modal-header panel-heading">
							<h4 class="modal-title">Update Timesheet</h4>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</div>
						<form id="user-frm">
							<div class ="modal-body">
								<input type="hidden" name="id" class="form-control" />
								<input type="hidden" name="firstname" class="form-control" />
								<input type="hidden" name="lastname" class="form-control" />
								<input type="hidden" name="dateInfo" class="form-control" />
								<input type="hidden" name="timein" class="form-control" />
								<input type="hidden" name="timeout" class="form-control" />
								<input type="hidden" name="newdateInfo" class="form-control" />
								<input type="hidden" name="newtimein" class="form-control" />
								<input type="hidden" name="newtimeout" class="form-control" />
								<input type="hidden" name="shift" class="form-control" />
								<div class="form-group">
									<label>Lunch Taken</label>
									<select name="lunch" required="required" class="form-control">
										<option value="Yes">Yes</option>
										<option value="No">No</option>
									</select>
								</div>
								<div class="form-group">
									<label>Sick Hours<strong><font color="red">*</font></strong></label>
									<input type="text" name="sick" maxlength="8" required="required" class="form-control" />
								</div>
								<div class="form-group">
									<label>Vacation Hours<strong><font color="red">*</font></strong></label>
									<input type="text" name="vacation" maxlength="8" required="required" class="form-control" />
								</div>
								<div class="form-group">
									<label>Regular Hours<strong><font color="red">*</font></strong></label>
									<input type="text" name="regular" maxlength="8" required="required" class="form-control" />
								</div>
								<div class="form-group">
									<label>Over Time<strong><font color="red">*</font></strong></label>
									<input type="text" name="ot" maxlength="8" required="required" class="form-control" />
								</div>
								<div class="form-group">
  									<label for="notes_textbox">Notes</label>
 									 <textarea class="form-control rounded-0" name="notes" id="notes" rows="3" maxlength="100"></textarea>
									  <p>(Maximum 100 characters)</p>
								</div>
							</br>
								<div class="form-group">
									<p><strong><font color="red">* </font></strong>Number only, put '0' if not applicable</p>
								</div>
							</div>
							<div class="modal-footer">
								<button  class="btn btn-primary" name="submit">Submit</button>
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
		$(document).ready(function(){
			$('#user-frm').submit(function(e){
				e.preventDefault()
				$('#user-frm [name="submit"]').attr('disabled',false)
				$('#user-frm [name="submit"]').html('Save')
				$.ajax({
					url:'update_timesheet.php',
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
		
			$('.edit_timesheet').click(function(){
				var $id=$(this).attr('data-id');
				var $dateInfo=$(this).attr('data-dateInfo');
				var $timein=$(this).attr('data-timein');
				var $timeout=$(this).attr('data-timeout');
				$.ajax({
					url:'get_timesheet.php',
					method:"POST",
					data:{id:$id, dateInfo:$dateInfo, timein:$timein, timeout:$timeout},
					error:err=>console.log(),
					success:function(resp){
						if(typeof resp !=undefined){
							resp = JSON.parse(resp)
							$('[name="id"]').val(resp.id)
							$('[name="firstname"]').val(resp.firstname)
							$('[name="lastname"]').val(resp.lastname)
							$('[name="dateInfo"]').val(resp.dateInfo)
							$('[name="timein"]').val(resp.timein)
							$('[name="timeout"]').val(resp.timeout)
							$('[name="newdateInfo"]').val(resp.dateInfo)
							$('[name="newtimein"]').val(resp.timein)
							$('[name="newtimeout"]').val(resp.timeout)
							$('[name="shift"]').val(resp.shift)
							$('[name="lunch"]').val(resp.lunch)
							$('[name="sick"]').val(resp.sick)
							$('[name="vacation"]').val(resp.vacation)
							$('[name="regular"]').val(resp.regular)
							$('[name="ot"]').val(resp.ot)
							$('[name="notes"]').val(resp.notes)
							$('#manage_timesheet').modal('show')
						}
					}
				})				
			});
			$(document).ready(function(){
				$('[data-toggle="tooltip"]').tooltip();   
				})
		});
	</script>
</html>

<?php 
	}
?>