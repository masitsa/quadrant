<?php

$company_details = $this->site_model->get_contacts();

/*$popular_query = $this->blog_model->get_popular_posts();

if($popular_query->num_rows() > 0)
{
	$popular_posts = '';
	$count = 0;
	foreach ($popular_query->result() as $row)
	{
		$count++;
		
		if($count < 3)
		{
			$post_id = $row->post_id;
			$post_title = $row->post_title;
			$image = base_url().'assets/images/posts/thumbnail_'.$row->post_image;
			$comments = $this->users_model->count_items('post_comment', 'post_id = '.$post_id);
			$description = $row->post_content;
			$mini_desc = implode(' ', array_slice(explode(' ', $description), 0, 10));
			$created = date('jS M Y',strtotime($row->created));
			
			$popular_posts .= '
				<li>
					<div style="background-image:url('.$image.');" class="pm-recent-blog-post-thumb"></div>
					<div class="pm-recent-blog-post-details">
						<a href="'.site_url().'blog/view-single/'.$post_id.'">'.$mini_desc.'</a>
						<p class="pm-date">'.$created.'</p>
						<div class="pm-recent-blog-post-divider"></div>
					</div>
				</li>
			';
		}
	}
}

else
{
	$popular_posts = 'There are no posts yet';
}*/
?>
	
	<footer>
    <!--
		<div class="container">
			<div class="row">
				<div class="col-md-6 padding-top-50"> 

					<div class="news-letter">
						<h6>News Letter</h6>
						<form>
							<input type="email" placeholder="Enter your email..." >
							<button type="submit"><i class="fa fa-envelope-o"></i></button>
						</form>
					</div>
				</div>
				
				<div class="col-md-6 padding-top-50">
					<div class="news-letter">
						<h6>Follow us</h6>
						<ul class="social_icons pull-left margin-left-50 margin-top-10">
							<li><a href="<?php echo $company_details['facebook'];?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
							<li><a href="<?php echo $company_details['twitter'];?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
							<li><a href="<?php echo $company_details['linkedin'];?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>-->

		<!-- Footer Info -->
		<div class="footer-info">
			<div class="container">
				<div class="row"> 

					<!-- About -->
					<div class="col-md-4"> <img class="margin-bottom-30" src="<?php echo base_url().'assets/logo/'.$company_details['logo'];?>" alt="" >
						<p><?php echo $company_details['mission'];?></p>
						<ul class="personal-info">
							<li><i class="fa fa-map-marker"></i> <?php echo $company_details['floor'];?>, <?php echo $company_details['building'];?>, 
							<?php echo $company_details['location'];?>.</li>
							<li><i class="fa fa-envelope"></i> <?php echo $company_details['email'];?></li>
							<li><i class="fa fa-phone"></i> <?php echo $company_details['phone'];?> </li>
						</ul>
					</div>

					<!-- Service provided -->
					<div class="col-md-4">
						<h6>Quick Links</h6>
						<ul class="links">
							<li><a href="<?php echo site_url().'feedback';?>">Training feedback</a></li>
						</ul>
					</div>

					<!-- Quote -->
					<div class="col-md-4">
						<h6>Contact us</h6>
						<div class="quote">
							<form action="<?php echo site_url();?>site/contact_us/contact/2" method="post" id="contact-form">
								<input class="form-control" type="text" placeholder="First Name" name="first_name">
								<input class="form-control" type="text" placeholder="Last Name" name="last_name">
								<input class="form-control" type="text" placeholder="Email" name="email">
								<input class="form-control" type="text" placeholder="Phone No" name="phone">
								<textarea class="form-control" placeholder="Message" name="message"></textarea>
								<button type="submit" class="btn btn-orange">SEND NOW</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Rights -->
		<div class="rights">
			<div class="container">
				<p>Copyright © <?php echo date('Y');?> <?php echo $company_details['company_name'];?>. All Rights Reserved.</p>
			</div>
		</div>
	</footer>