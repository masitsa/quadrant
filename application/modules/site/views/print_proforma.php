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
$v_data['print'] = 1;

$today = date('jS F Y H:i a',strtotime(date("Y:m:d h:i:s")));
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Pro Forma Invoice</title>
        <!-- For mobile content -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- IE Support -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Bootstrap -->
        <link rel="stylesheet" href="<?php echo base_url().'assets/themes/infinity/'?>css/bootstrap/bootstrap.min.css" media="all">
        <style type="text/css">
			.receipt_spacing{letter-spacing:0px; font-size: 12px;}
			.center-align{margin:0 auto; text-align:center;}
			
			.receipt_bottom_border{border-bottom: #888888 medium solid;}
			.row .col-md-12 table {
				border:solid #000 !important;
				border-width:1px 0 0 1px !important;
				font-size:10px;
			}
			.row .col-md-12 th, .row .col-md-12 td {
				border:solid #000 !important;
				border-width:0 1px 1px 0 !important;
			}
			.table thead > tr > th, .table tbody > tr > th, .table tfoot > tr > th, .table thead > tr > td, .table tbody > tr > td, .table tfoot > tr > td
			{
				 padding: 2px;
			}
			
			.row .col-md-12 .title-item{float:left;width: 130px; font-weight:bold; text-align:right; padding-right: 20px;}
			.title-img{float:left; padding-left:30px;}
			img.logo{max-height:70px; margin:0 auto;}
			.panel, .table{margin-bottom:0;}
		</style>
    </head>
    <body class="receipt_spacing">
    	<div class="row">
        	<div class="col-xs-12">
            	<img src="<?php echo base_url().'assets/logo/'.$contacts['logo'];?>" alt="<?php echo $contacts['company_name'];?>" class="img-responsive logo"/>
            </div>
        </div>
    	<div class="row">
        	<div class="col-md-12 center-align receipt_bottom_border">
            	<strong>
                	<?php echo $contacts['company_name'];?><br/>
                    P.O. Box <?php echo $contacts['address'];?> <?php echo $contacts['post_code'];?>, <?php echo $contacts['city'];?><br/>
                    E-mail: <?php echo $contacts['email'];?>. Tel : <?php echo $contacts['phone'];?><br/>
                    <?php echo $contacts['location'];?>, <?php echo $contacts['building'];?>, <?php echo $contacts['floor'];?><br/>
                </strong>
            </div>
        </div>
        
    	<div class="row receipt_bottom_border">
        	<div class="col-md-12 center-align">
            	<strong>Pro Forma Invoice</strong>
            </div>
        </div>
        
    	<div class="row">
        	<div class="col-md-12">
            	
                <table class="table table-condensed table-striped table-bordered">
                	<tr>
                    	<th>#</th>
                    	<th>Item</th>
                    	<th>Units</th>
                    	<th>@</th>
                    	<th>Total</th>
                    </tr>
					<?php
					$count = 0;
                    if($registered_trainees->num_rows() > 0)
                    {
                        foreach($registered_trainees->result() as $res)
                        {
							$count++;
                            $trainee_fname = $res->trainee_fname;
                            $trainee_mname = $res->trainee_mname;
                            $trainee_lname = $res->trainee_lname;
                            $trainee_company = $res->trainee_company;
                            $trainee_role = $res->trainee_role;
                            $trainee_email = $res->trainee_email;
                            $trainee_phone = $res->trainee_phone;
                            ?>
                            <tr>
                                <td><?php echo $count;?></td>
                                <td><?php echo $trainee_fname;?> <?php echo $trainee_mname;?></td> <?php echo $trainee_lname;?></td>
                                <td>1</td>
                                <td><?php echo number_format(55000, 0);?></td>
                                <td><?php echo number_format(55000, 0);?></td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    <tr>
                        <th colspan="4">Total</th>
                        <th><?php echo number_format((55000 * $count), 0);?></th>
                    </tr>
                </table>
                
            </div>
        </div>
        
    	<div class="row">
        	<div class="col-md-12">
            	<ul>
                	<li>0751506406</li>
                	<li>Barclays Bank</li>
                	<li>Moi Avenue</li>
                </ul>
            </div>
        </div>
        
    	<div class="row">
        	<div class="col-md-12">
                <?php echo $today; ?>
                
            </div>
        </div>
        
    </body>
    
</html>