<?php 
	if(count($contacts) > 0)
	{
		$email = $contacts['email'];
		$phone = $contacts['phone'];
		$facebook = $contacts['facebook'];
		$twitter = $contacts['twitter'];
		$linkedin = $contacts['linkedin'];
		$logo = $contacts['logo'];
		$company_name = $contacts['company_name'];
		$address = $contacts['address'];
		$city = $contacts['city'];
		$post_code = $contacts['post_code'];
		$building = $contacts['building'];
		$floor = $contacts['floor'];
		$location = $contacts['location'];
		$working_weekend = $contacts['working_weekend'];
		$working_weekday = $contacts['working_weekday'];
		
		if(!empty($email))
		{
			$mail = '<div class="top-number"><p><i class="fa fa-envelope-o"></i> '.$email.'</p></div>';
		}
		
		if(!empty($facebook))
		{
			$facebook = '<li><a href="'.$facebook.'" target="_blank"><i class="fa fa-facebook"></i></a></li>';
		}
		
		if(!empty($twitter))
		{
			$twitter = '<li><a href="'.$twitter.'" target="_blank"><i class="fa fa-twitter"></i></a></li>';
		}
		
		if(!empty($linkedin))
		{
			$linkedin = '<li><a href="'.$linkedin.'" target="_blank"><i class="fa fa-linkedin"></i></a></li>';
		}
	}
	else
	{
		$email = '';
		$facebook = '';
		$twitter = '';
		$linkedin = '';
		$logo = '';
		$company_name = '';
	}
?>

<!--======= SUB BANNER =========-->
<section class="sub-banner">
    <div class="container">
        <div class="position-center-center">
            <h2>CONTACT</h2>
            <ul class="breadcrumb">
                <li><a href="<?php echo site_url();?>">Home</a></li>
                <li>Contact</li>
            </ul>
        </div>
    </div>
</section>
  
<!-- Content -->
<div id="content"> 
    
	<!-- Contact  -->
	<section class="contact-us light-gray-bg">
		<div class="container-fluid">
			<div class="row">

			<!-- MAP -->
				<div class="col-md-4">
					<div id="map"></div>
				</div>

				<!-- Contact From -->
				<div class="col-md-8">
					<h3 class="font-alegreya margin-top-50">Get In Touch With Us</h3>
					<div class="contact-form"> 

						<!-- FORM -->
						<form role="form" id="contact-form" class="contact-form" method="post">
							<ul class="row">
								<li class="col-sm-6">
									<label>*FIRST NAME
										<input type="text" class="form-control" name="first_name" id="name" placeholder="">
									</label>
								</li>
								<li class="col-sm-6">
									<label>*LAST NAME
										<input type="text" class="form-control" name="last_name" id="name" placeholder="">
									</label>
								</li>
								<li class="col-sm-6">
									<label>*EMAIL
										<input type="text" class="form-control" name="email" id="email" placeholder="">
									</label>
								</li>
								<li class="col-sm-6">
									<label>PHONE
										<input type="text" class="form-control" name="phone" id="company" placeholder="">
									</label>
								</li>
								<li class="col-sm-12">
									<label>*MESSAGE
										<textarea class="form-control" name="message" id="message" rows="5" placeholder=""></textarea>
									</label>
								</li>
								<li class="col-sm-12 no-margin">
									<button type="submit" value="submit" class="btn" id="btn_submit">SEND NOW</button>
								</li>
							</ul>
							
						</form>
					</div>
					
				</div>
				
			</div>
			
		</div>
		
	</section>

    <!-- Contact Info -->
    <section class="contact-info padding-top-80 padding-bottom-80">
		<div class="container">
			<div class="row">
				<div class="col-md-4">
					<h3 class="font-alegreya margin-top-30">Contact Us</h3>
				</div>
				<div class="col-md-8">
					<ul class="row">
						<li class="col-sm-4"> <i class="fa fa-map-marker"></i>
							<h4 class="font-alegreya">Visit Us</h4>
							<p><?php echo $building;?>, <?php echo $location;?>, <?php echo $floor;?></p>
						</li>
						<li class="col-sm-4"> <i class="fa fa-clock-o"></i>
							<h4 class="font-alegreya">Working Hours</h4>
							<p>Mon - Fri : 8:00 AM - 5:00 PM</p>
							<p>Sat : 9:00 AM - 2:00 PM</p>
						</li>
						<li class="col-sm-4"> <i class="fa fa-phone"></i>
							<h4 class="font-alegreya">Contact</h4>
							<p><?php echo $phone;?></p>
							<p><?php echo $email;?></p>
						</li>
					</ul>
				</div>
			</div>
		</div>

	</section>

</div>
<!-- End Content --> 
  
<script type="text/javascript"   src="http://maps.google.com/maps/api/js?sensor=false"> </script>

<script type="text/javascript">
$(document).ready(function() {
	initialize()
});
  function initialize() {
    var position = new google.maps.LatLng(-1.290929, 36.782857);
	 <!-- var position = new google.maps.LatLng(latitude, longitude);-->
    var myOptions = {
      zoom: 18,
      center: position,
      mapTypeId: google.maps.MapTypeId.ROADMAP
		//mapTypeId: google.maps.MapTypeId.HYBRID
    };
    var map = new google.maps.Map(
        document.getElementById("map"),
        myOptions);
 
    var marker = new google.maps.Marker({
        position: position,
        map: map,
        title:"<?php echo $company_name;?>"
    });  
 
   var contentString = '<br/><span itemprop="streetAddress"><?php echo $building;?></span>, <span itemprop="addressLocality"><?php echo $location.', '.$floor;?></span>';
    //var contentString = '';
    var infowindow = new google.maps.InfoWindow({
        content: contentString
    });
       infowindow.open(map,marker);
    google.maps.event.addListener(marker, 'click', function() {
      infowindow.open(map,marker);
    });
 
  }
		
</script>
