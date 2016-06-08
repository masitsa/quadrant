<!--======= SUB BANNER =========-->
<section class="sub-banner">
	<div class="container">
		<div class="position-center-center">
			<h2>Feedback</h2>
			<ul class="breadcrumb">
				<li><a href="<?php echo site_url();?>">Home</a></li>
				<li>Feedback</li>
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
				<h3 class="font-alegreya margin-top-50">Training Feedback for 20th February 2016</h3>
                
                <?php
                $error = $this->session->userdata('error_message');
				
				if(!empty($error))
				{
					echo '
					<div class="alert alert-danger">
						'.$error.'
					</div>
					';
				}
				?>
                
				<div class="contact-form"> 

					<!-- FORM -->
					<form role="form" class="contact-form" id="contact_form" method="post" action="<?php echo site_url().$this->uri->uri_string();?>">
						<ul class="row">
							<li class="col-sm-6 col-sm-offset-3">
								<label>*EMAIL
									<input type="text" class="form-control" name="trainee_email" id="trainee_email" placeholder="">
								</label>
							</li>
							<li class="col-sm-6 col-sm-offset-3">
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
  