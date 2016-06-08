		<!-- TESTIMONIALS -->
		<section class="testimonial red-bg padding-top-100 padding-bottom-100">
			<div class="container"> 

				<!-- Tittle -->
				<div class="heading-block white-text text-center margin-bottom-80">
					<h2>Why Customer <i class="fa fa-heart white-text"></i> us! </h2>
					<span class="intro-style">We are fully committed and specialise in business readiness </span> 
				</div>

				<!-- Testi Slider -->
				<div class="testi-slides-flex">
					<ul class="slides">
                    	<?php
							if($reviews->num_rows() > 0)
							{
								$reviews_no = $reviews->num_rows();
								$count = -1;
								foreach($reviews->result() as $rev)
								{           
									$review_id = $rev->review_id;
									$review_status = $rev->review_status;
									$review_name = $rev->review_name;
								?>
                                	<li>
                                        <div class="avatar"> <img src="<?php echo base_url().'assets/images/avatar.jpg'?>" alt="" >
                                            <h6>Anonymous </span></h6>
                                            <p><?php echo $review_name;?></p>
                                        </div>
                                    </li>
						<?php
								}
							}
						?>
					</ul>
				</div>
			</div>
		</section>
		