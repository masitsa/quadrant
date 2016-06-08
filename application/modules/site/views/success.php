<!--======= SUB BANNER =========-->
<section class="sub-banner">
    <div class="container">
        <div class="position-center-center">
            <h2>Training Needs Analysis</h2>
            <ul class="breadcrumb">
                <li><a href="<?php echo site_url();?>">Home</a></li>
                <li>Training Needs Analysis</li>
            </ul>
        </div>
    </div>
</section>
<div id="content"> 
    
    <!-- What We do -->
    <section class="intro padding-top-100 padding-bottom-100">
        <div class="container"> 
            <!-- Tittle -->
            <div class="heading-block text-center margin-bottom-80">
                <h2><?php echo $title;?></h2>
                
                <?php if($page == 1){?>
                <span>You have successfully registered for the training on 20th February 2016. Kindly complete the Training Needs Analysis form below. For the following Excel tasks, please indicate Yes in the tasks you are able to complete or No in those that you are unable to complete.</span>
                
                <div class="row"><br />
                    <div class="col-md-12">
                        <div class="progress">
                            <div class="one primary-color"></div>
                            <div class="two no-color"></div>
                            <div class="three no-color"></div>
                            <div class="progress-bar" style="width: 27%;"></div>
                        </div>
                        <hr />
                    </div>
                </div>
                <?php }?>
                
                <?php if($page == 2){?>
                <span>You have successfully completed the introduction TNA. Please fill in the intermediate section as best you can</span>
                
                <div class="row"><br />
                    <div class="col-md-12">
                        <div class="progress">
                            <div class="one primary-color"></div>
                            <div class="two primary-color"></div>
                            <div class="three no-color"></div>
                            <div class="progress-bar" style="width: 53%;"></div>
                        </div>
                        <hr />
                    </div>
                </div>
                <?php }?>
                
                <?php if($page == 3){?>
                <span>You have successfully completed the intermediate TNA. This is the last page. Kindly submit your responses as best you can so that we can serve you better</span>
                
                <div class="row"><br />
                    <div class="col-md-12">
                        <div class="progress">
                            <div class="one primary-color"></div>
                            <div class="two primary-color"></div>
                            <div class="three primary-color"></div>
                            <div class="progress-bar" style="width: 76%;"></div>
                        </div>
                        <hr />
                    </div>
                </div>
                <?php }?>
                
            <!-- What We do -->
            <div class="row">
                <div class="col-md-12 col-md-offset-2">
                	<form role="form" class="contact-form" id="contact_form" method="post" action="<?php echo site_url().$this->uri->uri_string();?>"> 
                        <table class="table table-condensed table-striped table-hover">
                            <tr>
                                <th>#</th>
                                <th>Question</th>
                                <th>Yes</th>
                                <th>No</th>
                            </tr>
                        <?php
                        if($tna_questions->num_rows() > 0)
                        {
                            $count = 0;
                            foreach($tna_questions->result() as $res)
                            {
                                $count++;
                                $tna_id = $res->tna_id;
                                $tna_name = $res->tna_name;
								$tna_id2 = 0;
								$yes_checked = '';
								$no_checked = '';
								
								if($tna_results->num_rows() > 0)
								{
									foreach($tna_results->result() as $res2)
									{
										$tna_id2 = $res2->tna_id;
										$tna_result_status = $res2->tna_result_status;
								
										if($tna_id2 == $tna_id)
										{
											if($tna_result_status == 1)
											{
												$yes_checked = 'checked';
											}
											
											else if($tna_result_status == 2)
											{
												$no_checked = 'checked';
											}
										}
									}
								}
                                ?>
                                <tr>
                                    <td><?php echo $count;?></td>
                                    <td><?php echo $tna_name;?></td>
                                    <td><input type="radio" name="option<?php echo $tna_id;?>" id="option<?php echo $tna_id;?>" value="1" <?php echo $yes_checked;?>></td>
                                    <td><input type="radio" name="option<?php echo $tna_id;?>" id="option<?php echo $tna_id;?>" value="2" <?php echo $no_checked;?>></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                        </table>
                        <!-- Button -->
                        <div class="text-center margin-top-50"> 
                            
                            <?php 
							$tna_form = $this->session->userdata('tna_form'); 
							
                            if(($page == 2) && ($tna_form <= 3)){?>
                            <a href="<?php echo site_url().'success/'.$attendee_id?>" class="btn btn-gray">Back</a> 
                            <?php }?>
                            
                            <?php if(($page == 3) && ($tna_form <= 3)){?>
                            <a href="<?php echo site_url().'intermediate/'.$attendee_id?>" class="btn btn-gray">Back</a> 
                            <?php }?>
                            <button type="submit" class="btn btn-orange">Save</button> 
                            
                            <?php if(($page == 1) && ($tna_form >= 1)){?>
                            <a href="<?php echo site_url().'intermediate/'.$attendee_id?>" class="btn btn-gray">Forward</a> 
                            <?php }?>
                
                            <?php if(($page == 2) && ($tna_form >= 2)){?>
                            <a href="<?php echo site_url().'advanced/'.$attendee_id?>" class="btn btn-gray">Forward</a> 
                            <?php }?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    
  </div>