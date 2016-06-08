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
				<li>Group registration</li>
			</ul>
		</div>
	</div>
</section>
  
<!-- Content -->
<div id="content"> 

<!-- Contact  -->
<section class="contact-us light-gray-bg padding-top-100 padding-bottom-100">
	<div class="container">
        <div class="heading-block text-left margin-bottom-20">
            <h2>Register for <?php echo $training_name;?> training on <?php echo $date;?></h2>
        </div>
		<div class="row">
			<!-- Contact From -->
			<div class="col-md-4">
				<div class="contact-form">
                	<?php if(empty($trainee_parent)){?>
					<!-- FORM -->
					<form role="form" class="contact-form" method="post" action="<?php echo site_url().$this->uri->uri_string();?>">
						<ul class="row">
							<li class="col-sm-12">
								<label>*COMPANY NAME
									<input type="text" class="form-control" name="trainee_fname" id="trainee_fname" placeholder="">
								</label>
							</li>
							<li class="col-sm-12">
								<label>*CONTACT PERSON FIRST NAME
									<input type="text" class="form-control" name="trainee_mname" id="trainee_mname" placeholder="">
								</label>
							</li>
							<li class="col-sm-12">
								<label>*CONTACT PERSON LAST NAME
									<input type="text" class="form-control" name="trainee_lname" id="trainee_lname" placeholder="">
								</label>
							</li>
							<li class="col-sm-12">
								<label>*EMAIL
									<input type="text" class="form-control" name="trainee_email" id="trainee_email" placeholder="">
								</label>
							</li>
							<li class="col-sm-12">
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
                    <?php } else{ ?>
					<!-- FORM -->
					<form role="form" class="contact-form" method="post" action="<?php echo site_url().$this->uri->uri_string();?>">
						<ul class="row">
							<li class="col-sm-12">
								<label>*FIRST NAME 
									<input type="text" class="form-control" name="trainee_fname" id="trainee_fname" placeholder="">
								</label>
							</li>
							<li class="col-sm-12">
								<label>MIDDLE NAME
									<input type="text" class="form-control" name="trainee_mname" id="trainee_mname" placeholder="">
								</label>
							</li>
							<li class="col-sm-12">
								<label>*LAST NAME
									<input type="text" class="form-control" name="trainee_lname" id="trainee_lname" placeholder="">
								</label>
							</li>
							<li class="col-sm-12">
								<label>*COMPANY
									<input type="text" class="form-control" name="trainee_company" id="trainee_company" placeholder="">
								</label>
							</li>
							<li class="col-sm-12">
								<label>*POSITION
									<input type="text" class="form-control" name="trainee_role" id="trainee_role" placeholder="">
								</label>
							</li>
							<li class="col-sm-12">
								<label>*EMAIL
									<input type="text" class="form-control" name="trainee_email" id="trainee_email" placeholder="">
								</label>
							</li>
							<li class="col-sm-12">
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
                    <?php } ?>
					
				</div>
				
			</div>
            
			<div class="col-md-8">
                
                <h3 class="font-alegreya margin-top-50">Registered members</h3>

                <table class="table table-condensed table-striped table-bordered">
                	<tr>
                    	<th>#</th>
                    	<th>First Name</th>
                    	<th>Middle Name</th>
                    	<th>Last Name</th>
                    	<th>Company</th>
                    	<th>Position</th>
                    	<th>Email</th>
                    	<th>Phone</th>
                    </tr>
					<?php
					$count = 0;
                    if($registered_trainees->num_rows() > 0)
                    {
                        foreach($registered_trainees->result() as $res)
                        {
							$count++;
                            $trainee_fname = $res->trainee_fname;
                            $trainee_mname = $res->trainee_mname;
                            $trainee_lname = $res->trainee_lname;
                            $trainee_company = $res->trainee_company;
                            $trainee_role = $res->trainee_role;
                            $trainee_email = $res->trainee_email;
                            $trainee_phone = $res->trainee_phone;
                            ?>
                            <tr>
                                <td><?php echo $count;?></td>
                                <td><?php echo $trainee_fname;?></td>
                                <td><?php echo $trainee_mname;?></td>
                                <td><?php echo $trainee_lname;?></td>
                                <td><?php echo $trainee_company;?></td>
                                <td><?php echo $trainee_role;?></td>
                                <td><?php echo $trainee_email;?></td>
                                <td><?php echo $trainee_phone;?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                </table>
                <a href="<?php echo site_url().'site/profoma/'.$training_id;;?>" class="btn" id="btn_submit">Finish</a>
			</div>
		</div>
		
	</div>

</section>

</div>
<!-- End Content --> 