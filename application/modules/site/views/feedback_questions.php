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
                
                <span>Hi <?php echo $this->session->userdata('trainee_fname');?>. Thank you for attending the Excel Training. We appreciate your feedback. Please fill in the following two pages as best you can.</span>
                
                <?php if($page == 1){?>
                
                <div class="row"><br />
                    <div class="col-md-12">
                        <div class="progress">
                            <div class="one primary-color"></div>
                            <div class="two no-color"></div>
                            <div class="three no-color"></div>
                            <div class="progress-bar" style="width: 53%;"></div>
                        </div>
                        <hr />
                    </div>
                </div>
                <?php }?>
                
                <?php if($page == 2){?>
                
                <div class="row"><br />
                    <div class="col-md-12">
                        <div class="progress">
                            <div class="one primary-color"></div>
                            <div class="two primary-color"></div>
                            <div class="three no-color"></div>
                            <div class="progress-bar" style="width: 76%;"></div>
                        </div>
                        <hr />
                    </div>
                </div>
                <?php }?>
                
                <?php if($page == 3){?>
                
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
								
								if($tna_feedbacks->num_rows() > 0)
								{
									foreach($tna_feedbacks->result() as $res2)
									{
										$tna_id2 = $res2->tna_id;
										$tna_feedback_status = $res2->tna_feedback_status;
								
										if($tna_id2 == $tna_id)
										{
											if($tna_feedback_status == 1)
											{
												$yes_checked = 'checked';
											}
											
											else if($tna_feedback_status == 2)
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
                            <a href="<?php echo site_url().'feedback-introduction';?>" class="btn btn-gray">Back</a> 
                            <?php }?>
                            
                            <?php if(($page == 3) && ($tna_form <= 3)){?>
                            <a href="<?php echo site_url().'feedback-intermediate';?>" class="btn btn-gray">Back</a> 
                            <?php }?>
                            <button type="submit" class="btn btn-orange">Save</button> 
                            
                            <?php if(($page == 1) && ($tna_form >= 1)){?>
                            <a href="<?php echo site_url().'feedback-intermediate';?>" class="btn btn-gray">Forward</a> 
                            <?php }?>
                
                            <?php if(($page == 2) && ($tna_form >= 2)){?>
                            <!--<a href="<?php echo site_url().'advanced/'.$attendee_id?>" class="btn btn-gray">Forward</a> -->
                            <?php }?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    
  </div>