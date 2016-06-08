		
		<section class="offer-services padding-top-100">
			<div class="container"> 
				<div class="heading-block text-center margin-bottom-20">
					<h2>Quadrant Training </h2>
					<p>The core of a business is making effective sound decisions in order to maximize on profits. Having understood this, it is time to raise the bar by providing solutions to organizations on how to use their business tools more effectively. As a result you will be able to amplify each solution to bring out great work efficiency  and streamline business operations.</p>
                    
                    <p>Data will not only be captured, summarized and stored but it will be analyzed and its accuracy assessed. In the long run a tremendous amount  of data will be converted into useful information. This can be used in managing , monitoring and communicating in the business.</p>
                    
                    <p>>At Quadrant Africa our aim is to change the way organizations view their day to day office tools. With our experienced expert trainers and our specialized Excel training solutions customized from a training need analysis, we can help you grow your business efficiently and make profits. </p>
				</div>
				<div class="text-center"> <img src="<?php echo base_url().'assets/themes/infinity/'?>images/services-img.jpg" alt=""> </div>
			</div>
		</section>
        
		<section class="bg-parallax text-center padding-top-60 padding-bottom-60" style="background:url(<?php echo base_url().'assets/themes/infinity/'?>images/bg/bg-parallax.jpg) no-repeat;">
			<div class="container">
				<div class="text-center margin-bottom-50">
					<p class="text-white intro-style font-14px">Grow Your Business</p>
				</div>
				<a href="<?php echo site_url().'excel';?>" class="btn btn-orange">Learn More</a> 
			</div>
		</section>
        
        		<!-- Case Studies -->
		<section class="case-studies light-gray-bg padding-top-40 padding-bottom-40">
			<div class="container"> 

				<!-- Tittle -->
				<div class="heading-block text-center margin-bottom-20">
					<h2>Training Calendar </h2>
					<span class="intro-style">We are currently offering a 2007 - 2013 Microsoft® Excel training for business professionals. You can register online for our upcoming trainings </span> 
				</div>

				<!-- Cases -->
				<div class="case">
					<ul class="row">
                    	
                        <?php if($trainings->num_rows() > 0){?>
                        	<?php foreach($trainings->result() as $res){?>
                            	<?php 
								$training_id = $res->training_id;
								$training_name = $res->training_name;
								$start_date = $res->start_date;
								$end_date = $res->end_date;
								$month = date('F Y',strtotime($start_date));
								$start = date('jS',strtotime($start_date));
								
								if(!empty($end_date))
								{
									$end = ' - '.date('jS',strtotime($end_date));
								}
								
								else
								{
									$end = '';
								}
								
								if($start_date == $end_date)
								{
									$end = '';
								}
								?>
                                <!-- Case 1 -->
                                <li class="col-md-4">
                                    <article> <a href="<?php echo site_url().'register/'.$training_id;?>"><?php echo $month;?><br /><span class="training"><?php echo $training_name;?></span></a>
                                        <div class="case-detail">
                                            <h5><?php echo $start.$end;?></h5>
                                        </div>
                                    </article>
                                </li>
                        	<?php }?>
                        <?php }?>
					</ul>

					<!-- Button -->
					<div class="text-center margin-top-50"> <a href="<?php echo site_url().'trainings';?>" class="btn btn-orange">View More</a> </div>
				</div>
			</div>
		</section>
        
        <!--
		<section class="front-page bg-parallax" style="background:url(<?php echo base_url().'assets/themes/infinity/'?>images/bg/report-bg.jpg) no-repeat;">
			<div class="container">
				<div class="row">
					<div class="col-md-5"> 
						<div class="heading-block text-left margin-bottom-20 margin-top-100">
							<h2>Scheduled Trainings</h2>
							<p class="font-14px line-height-30">We have 4 scheduled trainings every month. However we can organize corporate packages at your request</p>

							<a href="<?php echo site_url().'trainings';?>" class="btn btn-orange margin-top-20">VIEW MORE</a> 
						</div>

					</div>

					<div class="col-md-7"> <img src="<?php echo base_url().'assets/themes/infinity/'?>images/report-img.png" alt=" "> </div>

				</div>
			</div>
		</section>-->
        
		<?php
		/*if($services->num_rows() > 0)
		{
			foreach($services->result() as $serv)
			{
				$service_name = $serv->service_name;
				$description = $serv->service_description;
				$service_image = $serv->service_image_name;
				$description = implode(' ', array_slice(explode(' ', strip_tags($description)), 0, 6));
				
				?>
				<li class="span3">
					<figure>
						<a href="#" class="thumbnail">
							<img src="<?php echo $service_location.$service_image;?>" alt="<?php echo $service_name;?>">
						</a>
						<figcaption>
							<h3><a href="#"><?php echo $service_name;?></a></h3>
							<p><?php echo $description;?></p>
						</figcaption>
					</figure>
				</li>
				<?php
			}
		}*/
		?>