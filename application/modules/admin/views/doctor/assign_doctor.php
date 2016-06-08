<section class="panel">
    <header class="panel-heading">
        <h2 class="panel-title">Assign doctors</h2>
    </header>
    <div class="panel-body">
        
        <div class="row" style="margin-bottom:20px;">
            <div class="col-lg-12">
                <a href="<?php echo site_url().'website/doctors';?>" class="btn btn-info btn-sm pull-right">Back to doctors</a>
            </div>
        </div>
        <div class="table-responsive">


<?php	

		$success = $this->session->userdata('success_message');
		
		if(!empty($success))
		{
			echo '<div class="alert alert-success"> <strong>Success!</strong> '.$success.' </div>';
			$this->session->unset_userdata('success_message');
		}
		
		$error = $this->session->userdata('error_message');
		
		if(!empty($error))
		{
			echo '<div class="alert alert-danger"> <strong>Oh snap!</strong> '.$error.' </div>';
			$this->session->unset_userdata('error_message');
		}
		
		//if users exist display them
		if ($query->num_rows() > 0)
		{
				?>
                <table class="table table-condensed table-striped table-hover">
                    <tr>
                    	<th>#</th>
                    	<th>Doctor</th>
                        <?php
                        if($branches->num_rows() > 0)
						{
							foreach($branches->result() as $res)
							{
								$branch_name = $res->branch_name;
								echo '<th>'.$branch_name.'</th>';
							}
						}
						?>
                    </tr>
                <?php
				$count = 0;
				foreach($query->result() as $cat)
				{
					$doctor_id = $cat->doctor_id;
					$doctor_status = $cat->doctor_status;
					$doctor_fname = $cat->doctor_fname;
					$doctor_onames = $cat->doctor_onames;
					$doctor_image_name = 'thumbnail_'.$cat->doctor_image_name;
					$count++;
					
					if($doctor_status == 1){
						$status = '<span class="label label-success">Active</span>';
					}
					else{
						$status = '<span class="label label-important">Deactivated</span>';
					}
					?>
                    <tr>
                    	<td><?php echo $count?></td>
                    	<td><?php echo $doctor_fname?> <?php echo $doctor_onames?></td>
                    	
                        <?php
                        if($branches->num_rows() > 0)
						{
							foreach($branches->result() as $res)
							{
								$branch_id = $res->branch_id;
								if($assigned_doctors->num_rows() > 0)
								{
									$checked = '';
									foreach($assigned_doctors->result() as $row)
									{
										$assigned_branch_id = $row->branch_id;
										$assigned_doctor_id = $row->doctor_id;
										$branch_doctor_id = $row->branch_doctor_id;
										
										if(($branch_id == $assigned_branch_id) && ($doctor_id == $assigned_doctor_id))
										{
											$checked = 'checked="checked"';
											break;
										}
									}
									
									if(!empty($checked))
									{
										echo '<td><input type="checkbox" class="form-control" onClick="remove_assigned_doctor('.$branch_doctor_id.')" checked="checked"></td>';
									}
									
									else
									{
										echo '<td><input type="checkbox" class="form-control" onClick="assign_doctor('.$branch_id.', '.$doctor_id.')"></td>';
									}
								}
								
								else
								{
									echo '<td><input type="checkbox" class="form-control" onClick="assign_doctor('.$branch_id.', '.$doctor_id.')"></td>';
								}
							}
						}
						?>
                    </tr>
                    <?php
				}
				?>
                </table>
                <?php
				if(isset($links)){echo $links;}
			}
			
			else{
				echo "There are no doctors to display :-(";
			}
		?>
    </div>
</section>

<script type="text/javascript">
	function remove_assigned_doctor(branch_doctor_id)
	{
		$.get( "<?php echo site_url();?>admin/doctors/remove_assigned_doctor/"+branch_doctor_id, function( data ) 
		{
			//$( "#loan_details" ).html( data );
		});
	}
	
	function assign_doctor(branch_id, doctor_id)
	{
		$.get( "<?php echo site_url();?>admin/doctors/assign_doctor2/"+branch_id+'/'+doctor_id, function( data ) 
		{
			//$( "#loan_details" ).html( data );
		});
	}
</script>