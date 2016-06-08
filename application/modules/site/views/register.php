<?php
$training_name = $start_date = $end_date = '';

if($training->num_rows() > 0)
{
	$row = $training->row();
	
	$training_name = $row->training_name;
	$start_date = $row->start_date;
	$end_date = $row->end_date;
	$date = date('jS F Y',strtotime($start_date));
}

?>
<!--======= SUB BANNER =========-->
<section class="sub-banner">
	<div class="container">
		<div class="position-center-center">
			<h2>Register</h2>
			<ul class="breadcrumb">
				<li><a href="<?php echo site_url();?>">Home</a></li>
				<li><a href="<?php echo site_url().'register/'.$training_id;?>">Register</a></li>
				<li>Individual registration</li>
			</ul>
		</div>
	</div>
</section>
  
<!-- Content -->
<div id="content"> 

<!-- Contact  -->
<section class="contact-us light-gray-bg padding-top-100 padding-bottom-100">
	<div class="container-fluid">
		<div class="row">

		<!-- Contact From -->
			<div class="col-md-12 col-md-offset-2">
				<h3 class="font-alegreya margin-top-50">Register for training on <?php echo $date;?></h3>
				<div class="contact-form"> 

					<!-- FORM -->
					<form role="form" class="contact-form" id="contact_form" method="post" action="<?php echo site_url().$this->uri->uri_string();?>">
						<ul class="row">
							<li class="col-sm-6">
								<label>*FIRST NAME
									<input type="text" class="form-control" name="trainee_fname" id="trainee_fname" placeholder="">
								</label>
							</li>
							<li class="col-sm-6">
								<label>MIDDLE NAME
									<input type="text" class="form-control" name="trainee_mname" id="trainee_mname" placeholder="">
								</label>
							</li>
							<li class="col-sm-6">
								<label>*LAST NAME
									<input type="text" class="form-control" name="trainee_lname" id="trainee_lname" placeholder="">
								</label>
							</li>
							<li class="col-sm-6">
								<label>*COMPANY
									<input type="text" class="form-control" name="trainee_company" id="trainee_company" placeholder="">
								</label>
							</li>
							<li class="col-sm-6">
								<label>*POSITION
									<input type="text" class="form-control" name="trainee_role" id="trainee_role" placeholder="">
								</label>
							</li>
							<li class="col-sm-6">
								<label>*EMAIL
									<input type="text" class="form-control" name="trainee_email" id="trainee_email" placeholder="">
								</label>
							</li>
							<li class="col-sm-6">
								<label>*PHONE
                            	<div class="input-group">
                                    <span class="input-group-addon">+254</span>
                                    <input type="text" class="form-control" name="trainee_phone" id="trainee_phone" placeholder="722149351">
								</label>
                                </div>
							</li>
							<li class="col-sm-12 no-margin">
								<button type="submit" value="submit" class="btn" id="btn_submit">REGISTER</button>
							</li>
						</ul>
						
					</form>
					
				</div>
				
			</div>
		</div>
		
	</div>

</section>

</div>
<!-- End Content --> 
  