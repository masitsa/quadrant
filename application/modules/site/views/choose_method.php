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
				<li>Choose Registration</li>
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
				<h3 class="font-alegreya margin-top-50">Choose your registration method</h3>
				<div class="contact-form"> 
                	<p>Register for <?php echo $training_name;?> training on <?php echo $date;?></p>
					<a href="<?php echo site_url().'site/register_individual/'.$training_id; ?>" class="btn" id="btn_submit">Individual Registration</a>

					<a href="<?php echo site_url().'site/group_registration/'.$training_id; ?>" class="btn" id="btn_submit">Group Registration</a>
					
				</div>
				
			</div>
		</div>
		
	</div>

</section>

</div>
<!-- End Content --> 
  