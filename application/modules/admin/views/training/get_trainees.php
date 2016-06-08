<?php	
	$attendees = '<table class="table table-striped table-hover table-condenses">
		<tr>
			<td>#</td>
			<td>First Name</td>
			<td>Middle Name</td>
			<td>Last Name</td>
			<td>Company</td>
			<td>Role</td>
			<td>Email</td>
			<td>Phone</td>
			<td>Registration Date</td>
		</tr>
	';		
	//display results for individuals
	if($trainees->num_rows() > 0)
	{
		$count = 0;
		foreach($trainees->result() as $res)
		{
			$trainee_id = $res->trainee_id;
			$trainee_fname = $res->trainee_fname;
			$trainee_mname = $res->trainee_mname;
			$trainee_lname = $res->trainee_lname;
			$trainee_company = $res->trainee_company;
			$trainee_role = $res->trainee_role;
			$trainee_email = $res->trainee_email;
			$trainee_phone = $res->trainee_phone;
			$created = $res->created;
			$last_modified = $res->last_modified;
			$count++;
			$beginner = '';$intermediate = '';$advanced = '';
			$beginner_total = $intermediate_total = $advanced_total = 0;
			//tna results
			if($tna->num_rows() > 0)
			{
				foreach($tna->result() as $res2)
				{
					//question
					$tna_id = $res2->tna_id;
					$tna_name = $res2->tna_name;
					$tna_page = $res2->tna_page;
					$response = '<span class="label label-danger">Unanswered</span>';
					
					//response
					if($tna_results->num_rows() > 0)
					{
						foreach($tna_results->result() as $res3)
						{
							$trainee_id2 = $res3->trainee_id;
							
							if($trainee_id2 == $trainee_id)
							{
								$tna_id2 = $res3->tna_id;
								
								if($tna_id2 == $tna_id)
								{
									$tna_result_status = $res3->tna_result_status;
									if($tna_result_status == 1)
									{
										$response = '<span class="label label-success">Yes</span>';
									}
									else if($tna_result_status == 2)
									{
										$response = '<span class="label label-warning">No</span>';
									}
									else
									{
										$response = '<span class="label label-danger">Unanswered</span>';
									}
									
								}
							}
						}
					}
					
					if($tna_page == 1)
					{
						$beginner_total++;
						$beginner .= '
							<tr>
								<td>'.$tna_name.'</td>
								<td>'.$response.'</td>
							</tr>
						';
					}
					
					else if($tna_page == 2)
					{
						$intermediate_total++;
						$intermediate .= '
							<tr>
								<td>'.$tna_name.'</td>
								<td>'.$response.'</td>
							</tr>
						';
					}
					
					else if($tna_page == 3)
					{
						$advanced_total++;
						$advanced .= '
							<tr>
								<td>'.$tna_name.'</td>
								<td>'.$response.'</td>
							</tr>
						';
					}
				}
			}
			
			$attendees .= '
				<tr>
					<td>'.$count.'</td>
					<td>'.$trainee_fname.'</td>
					<td>'.$trainee_mname.'</td>
					<td>'.$trainee_lname.'</td>
					<td>'.$trainee_company.'</td>
					<td>'.$trainee_role.'</td>
					<td>'.$trainee_email.'</td>
					<td>'.$trainee_phone.'</td>
					<td>'.date('jS M Y H:i:a',strtotime($created)).'</td>
					<td>
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#results'.$trainee_id.'">
							Results
						</button>
						
						<!-- Modal -->
                        <div class="modal fade" id="results'.$trainee_id.'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">TNA Results</h4>
                                    </div>
                                    <div class="modal-body">
                                        
										<!-- Nav tabs -->
                                        <ul class="nav nav-tabs" role="tablist">
                                            <li role="presentation" class="active"><a href="#beginner'.$trainee_id.'" aria-controls="beginner" role="tab" data-toggle="tab">Beginner</a></li>
                                            <li role="presentation"><a href="#intermediate'.$trainee_id.'" aria-controls="intermediate" role="tab" data-toggle="tab">Intermediate</a></li>
                                            <li role="presentation"><a href="#advanced'.$trainee_id.'" aria-controls="advanced" role="tab" data-toggle="tab">Advanced</a></li>
                                        </ul>
                                        
                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane active" id="beginner'.$trainee_id.'">
                                            	<table class="table table-condensed table-striped table-bordered">
													'.$beginner.'
												</table>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="intermediate'.$trainee_id.'">
                                            	<table class="table table-condensed table-striped table-bordered">
													'.$intermediate.'
												</table>
                                            </div>
                                            <div role="tabpanel" class="tab-pane" id="advanced'.$trainee_id.'">
                                            	<table class="table table-condensed table-striped table-bordered">
													'.$advanced.'
												</table>
                                            </div>
                                        </div>
										
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
					</td>
				</tr>
			';
		}
	}
	$attendees .= '</table>';
?>

<div class="row statistics">
    <div class="col-md-4">
        <ul class="today-datas">
            <!-- List #1 -->
            <li class="overall-datas">
                <!-- Graph -->
                <div class="pull-left visual bred"><span id="patients_per_day" class="spark"></span></div>
                <!-- Text -->
                <div class="datas-text pull-right">Beginner <span class="bold"><?php echo $beginner_total;?></span></div>
                
                <div class="clearfix"></div>
            </li>
            <li class="more-stats">
                <a class="more" href="<?php echo base_url()."data/reports/patients.php";?>" target="_blank">
                View More
                <i class="pull-right icon-angle-right"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="col-md-4">
        <ul class="today-datas">
            <li class="overall-datas" style="height:77px;">
                <!-- Graph -->
                <!-- <div class="pull-left visual bgreen"><span id="payment_methods" class="spark"></span></div>-->
                <!-- Text -->
                <div class="datas-text pull-right">Intermediate <span class="bold"><?php echo $intermediate_total;?></span></div>
                
                <div class="clearfix"></div>
            </li>
            <li class="more-stats">
                <a class="more" href="<?php echo base_url()."data/reports/cash_reports.php";?>" target="_blank">
                    View More
                    <i class="pull-right icon-angle-right"></i>
                </a>
            </li>
        </ul>
    </div>
    <div class="col-md-4">
        <ul class="today-datas">
            <li class="overall-datas" style="height:77px;">
                <!-- Graph -->
                <!-- <div class="pull-left visual bgreen"><span id="payment_methods" class="spark"></span></div>-->
                <!-- Text -->
                <div class="datas-text pull-right">Advanced <span class="bold"><?php echo $advanced_total;?></span></div>
                
                <div class="clearfix"></div>
            </li>
            <li class="more-stats">
                <a class="more" href="<?php echo base_url()."data/reports/cash_reports.php";?>" target="_blank">
                    View More
                    <i class="pull-right icon-angle-right"></i>
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="row">
	<div class="col-md-12">
    	<?php echo $attendees;?>
    </div>
</div>