<section class="panel">
    <header class="panel-heading">
        <h2 class="panel-title">Add doctor</h2>
    </header>
    <div class="panel-body">
        <div class="row" style="margin-bottom:20px;">
            <div class="col-lg-12">
                <a href="<?php echo site_url().'website/doctors';?>" class="btn btn-info btn-sm pull-right">Back to doctors</a>
            </div>
        </div>    
        <!-- Jasny -->
        <link href="<?php echo base_url();?>assets/jasny/jasny-bootstrap.css" rel="stylesheet">		
        <script type="text/javascript" src="<?php echo base_url();?>assets/jasny/jasny-bootstrap.js"></script> 
          <div class="padd">
            <?php
				$error2 = validation_errors(); 
				if(!empty($error2)){?>
					<div class="row">
						<div class="col-md-6 col-md-offset-2">
							<div class="alert alert-danger">
								<strong>Error!</strong> <?php echo validation_errors(); ?>
							</div>
						</div>
					</div>
				<?php }
			
				if(isset($_SESSION['error'])){?>
					<div class="row">
						<div class="col-md-6 col-md-offset-2">
							<div class="alert alert-danger">
								<strong>Error!</strong> <?php echo $_SESSION['error']; $_SESSION['error'] = NULL;?>
							</div>
						</div>
					</div>
				<?php }?>
			
				<?php
				$attributes = array('role' => 'form');
		
				echo form_open_multipart($this->uri->uri_string(), $attributes);
				
				if(!empty($error))
				{
					?>
					<div class="alert alert-danger">
						<?php echo $error;?>
					</div>
					<?php
				}
				?>
                <div class="row">
                	<div class="col-md-6">
                        <div class="form-group">
                            <label class="col-md-4" for="doctor_fname">First name</label>
                            <div class="col-md-8">
                            	<input type="text" class="form-control" name="doctor_fname" placeholder="First name" value="<?php echo set_value("doctor_fname");?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4" for="doctor_fname">Other names</label>
                            <div class="col-md-8">
                            <input type="text" class="form-control" name="doctor_onames" placeholder="Other names" value="<?php echo set_value("doctor_onames");?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4" for="doctor_fname">Email</label>
                            <div class="col-md-8">
                            <input type="text" class="form-control" name="doctor_email" placeholder="Email" value="<?php echo set_value("doctor_email");?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4" for="doctor_fname">Phone</label>
                            <div class="col-md-8">
                            <input type="text" class="form-control" name="doctor_phone" placeholder="Phone" value="<?php echo set_value("doctor_phone");?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4" for="doctor_fname">Designation</label>
                            <div class="col-md-8">
                            <input type="text" class="form-control" name="doctor_title" placeholder="Designation" value="<?php echo set_value("doctor_title");?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4" for="doctor_fname">Qualifications</label>
                            <div class="col-md-8">
                            <input type="text" class="form-control" name="doctor_qualifications" placeholder="Qualifications" value="<?php echo set_value("doctor_qualifications");?>">
                            </div>
                        </div>
					</div>
                	<div class="col-md-6">
                        <label class="control-label" for="image">Picture</label>
                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
                                <img src="<?php echo $doctor_location;?>" class="img-responsive"/>
                            </div>
                            <div>
                                <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="doctor_image"></span>
                                <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                            </div>
                        </div>
                	</div>
                </div>
                
                <div class="row">
                	<div class="col-md-12">
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="doctor_about">About</label>
                            <div class="col-md-10" style="height:500px; margin-bottom:20px;">
                            	<textarea class="cleditor" name="doctor_about"><?php echo set_value("doctor_about");?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
				
				<div class="form-group center-align">
					<input type="submit" value="Add Doctor" class="btn btn-success">
				</div>
				<?php
					echo form_close();
				?>
		</div>
	</div>
</section>