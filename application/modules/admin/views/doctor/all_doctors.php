<section class="panel">
    <header class="panel-heading">
        <h2 class="panel-title">All doctors</h2>
    </header>
    <div class="panel-body">
        <div class="row" style="margin-bottom:20px;">
            <div class="col-lg-12">
                <a href="<?php echo site_url().'administration/add-doctor';?>" class="btn btn-sm btn-success pull-right">Add Doctor</a>
                <a href="<?php echo site_url().'admin/doctors/assign_doctor';?>" class="btn btn-sm btn-primary pull-right" style="margin-right:10px;">Assign Doctors</a>
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
                    	<th>Image</th>
                    	<th>Doctor</th>
                    	<th>Email</th>
                    	<th>Phone</th>
                    	<th>Status</th>
                    	<th>Actions</th>
                    </tr>
                <?php
				$count = $page;
				foreach($query->result() as $cat){
					
					$doctor_id = $cat->doctor_id;
					$doctor_fname = $cat->doctor_fname;
					$doctor_onames = $cat->doctor_onames;
					$doctor_email = $cat->doctor_email;
					$doctor_phone = $cat->doctor_phone;
					$doctor_status = $cat->doctor_status;
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
                    	<td>
                        	<img src="<?php echo $doctor_location.$doctor_image_name;?>" width="100" class="img-responsive img-thumbnail">
                        </td>
                    	<td><?php echo $doctor_fname?> <?php echo $doctor_onames?></td>
                    	<td><?php echo $doctor_email?></td>
                    	<td><?php echo $doctor_phone?></td>
                    	<td><?php echo $status?></td>
                    	<td>
                        	<a href="<?php echo site_url()."administration/edit-doctor/".$doctor_id.'/'.$page;?>" class="i_size" title="Edit">
                            <button class="btn btn-success btn-sm" type="button" ><i class="fa fa-pencil-square-o"></i> Edit</button>
                            	
                            </a>
                        	<a href="<?php echo site_url()."administration/delete-doctor/".$doctor_id.'/'.$page;?>" class="i_size" title="Delete" onclick="return confirm('Do you really want to delete this doctor?');">
                            	 <button class="btn btn-danger btn-sm" type="button" ><i class="fa fa-trash-o"></i> Delete</button>
                            </a>
                            <?php
								if($doctor_status == 1){
									?>
                                        <a href="<?php echo site_url()."administration/deactivate-doctor/".$doctor_id.'/'.$page;?>" class="i_size" title="Deactivate" onclick="return confirm('Do you really want to deactivate this doctor?');">
                            <button class="btn btn-warning btn-sm" type="button" ><i class="fa fa-thumbs-o-down"></i> Deactivate</button>
                                        </a>
                                    <?php
								}
								else{
									?>
                                        <a href="<?php echo site_url()."administration/activate-doctor/".$doctor_id.'/'.$page;?>" class="i_size" title="Activate" onclick="return confirm('Do you really want to activate this doctor?');">
                            <button class="btn btn-info btn-sm" type="button" ><i class="fa fa-thumbs-o-up"></i> Activate</button>
                                        </a>
                                    <?php
								}
							?>
                        </td>
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