<?php
	$contacts = $this->site_model->get_contacts();
	
	if(count($contacts) > 0)
	{
		$email = $contacts['email'];
		$email2 = $contacts['email'];
		$facebook = $contacts['facebook'];
		$twitter = $contacts['twitter'];
		$linkedin = $contacts['linkedin'];
		$logo = $contacts['logo'];
		$company_name = $contacts['company_name'];
		$phone = $contacts['phone'];
		
		/*if(!empty($email))
		{
			$email = '<div class="top-number"><p><i class="fa fa-envelope-o"></i> '.$email.'</p></div>';
		}
		
		if(!empty($facebook))
		{
			$twitter = '<li class="pm_tip_static_bottom" title="Twitter"><a href="#" class="fa fa-twitter" target="_blank"></a></li>';
		}
		
		if(!empty($facebook))
		{
			$linkedin = '<li class="pm_tip_static_bottom" title="Linkedin"><a href="#" class="fa fa-linkedin" target="_blank"></a></li>';
		}
		
		if(!empty($facebook))
		{
			$google = '<li class="pm_tip_static_bottom" title="Google Plus"><a href="#" class="fa fa-google-plus" target="_blank"></a></li>';
		}
		
		if(!empty($facebook))
		{
			$facebook = '<li class="pm_tip_static_bottom" title="Facebook"><a href="#" class="fa fa-facebook" target="_blank"></a></li>';
		}*/
	}
	else
	{
		$email = '';
		$facebook = '';
		$twitter = '';
		$linkedin = '';
		$logo = '';
		$company_name = '';
		$google = '';
	}
?>
    
	<!-- Top bar -->
	<div class="container">
		<div class="row">
			<div class="col-md-2 noo-res"></div>
			<div class="col-md-10">
				<div class="top-bar">
					<div class="col-md-3">
						<ul class="social_icons">
							<li><a href="<?php echo $facebook?>" target="_blank"><i class="fa fa-facebook"></i></a></li>
							<li><a href="<?php echo $twitter?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
							<li><a href="<?php echo $linkedin?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>
						</ul>
					</div>

					<!-- Social Icon -->
					<div class="col-md-9">
						<ul class="some-info font-montserrat">
							<li><i class="fa fa-phone"></i> <a href="tel:<?php echo $phone?>"><?php echo $phone?></a></li>
							<li><i class="fa fa-envelope"></i> <a href="mailto:<?php echo $email?>"><?php echo $email?></a></li>
							<!--<li><i class="fa fa-weixin"></i> LiveChat</li>
							<li><i class="fa fa-question-circle"></i> Support</li>-->
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
    
    <!-- Header -->
	<header class="header coporate-header">
		<div class="sticky">
			<div class="container">
				<div class="logo"> <a href="index.html"><img src="<?php echo base_url().'assets/logo/'.$logo;?>" alt=<?php echo $company_name?>""></a> </div>

				<!-- Nav -->
				<nav>
					<ul id="ownmenu" class="ownmenu">
                    	<?php echo $this->site_model->get_navigation();?>
						<!--<li class="active"><a href="<?php echo site_url().'home';?>">HOME</a></li>
						<li><a href="<?php echo site_url().'about-us';?>"> ABOUT </a></li>
						<li><a href="services.html"> Trainings </a></li>
						<li><a href="case-studies.html"> CASESTUDIES</a></li>
						<li><a href="index.html">Pages</a>
							<ul class="dropdown">
								<li><a href="index.html">Index Defult</a></li>
								<li><a href="index-1.html">Index 2</a></li>
								<li><a href="about.html">About</a></li>
								<li><a href="services.html">Services</a></li>
								<li><a href="case-studies.html">Case Studies</a></li>
								<li><a href="case-studies-single.html">Case Studies Single</a></li>
								<li><a href="blog.html">Blog</a></li>
								<li><a href="blog-single.html">Blog Single</a></li>
								<li><a href="contact.html">Contact</a></li>
								<li><a href="404-page.html">404 Ppage</a></li>
							</ul>
						</li>
						<li><a href="blog.html"> BLOG </a></li>
						<li><a href="contact.html"> CONTACT</a></li>

						<li class="search-nav right"><a href="index-1.html#."><i class="fa fa-search"></i></a>
							<ul class="dropdown">
								<li>
									<form>
										<input type="search" class="form-control" placeholder="Enter Your Keywords..." required>
										<button type="submit"> SEARCH </button>
									</form>
								</li>
							</ul>
						</li>-->
					</ul>
				</nav>
			</div>
		</div>
	</header>
	<!-- End Header --> 
    