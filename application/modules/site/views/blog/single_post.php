<?php

$post_id = $row->post_id;
$blog_category_name = $row->blog_category_name;
$blog_category_id = $row->blog_category_id;
$post_title = $row->post_title;
$post_status = $row->post_status;
$post_views = $row->post_views;
$image = base_url().'assets/images/posts/'.$row->post_image;
$created_by = $row->created_by;
$modified_by = $row->modified_by;
$comments = $this->users_model->count_items('post_comment', 'post_id = '.$post_id);
$categories_query = $this->blog_model->get_all_post_categories($blog_category_id);
$description = $row->post_content;
$mini_desc = implode(' ', array_slice(explode(' ', $description), 0, 50));
$created = $row->created;
$day = date('j',strtotime($created));
$month = date('M Y',strtotime($created));
$created_on = date('jS M Y',strtotime($row->created));
$web_name = $this->site_model->create_web_name($post_title);

$categories = '';
$count = 0;
//get all administrators
	$administrators = $this->users_model->get_all_administrators();
	if ($administrators->num_rows() > 0)
	{
		$admins = $administrators->result();
		
		if($admins != NULL)
		{
			foreach($admins as $adm)
			{
				$user_id = $adm->user_id;
				
				if($user_id == $created_by)
				{
					$created_by = $adm->first_name;
				}
			}
		}
	}
	
	else
	{
		$admins = NULL;
	}

	foreach($categories_query->result() as $res)
	{
		$count++;
		$category_name = $res->blog_category_name;
		$category_id = $res->blog_category_id;
		
		if($count == $categories_query->num_rows())
		{
			$categories .= '<a href="'.site_url().'blog/category/'.$category_id.'" title="View all posts in '.$category_name.'" rel="category tag">'.$category_name.'</a>';
		}
		
		else
		{
			$categories .= '<a href="'.site_url().'blog/category/'.$category_id.'" title="View all posts in '.$category_name.'" rel="category tag">'.$category_name.'</a>, ';
		}
	}
	$comments_query = $this->blog_model->get_post_comments($post_id);
	//comments
	$comments = 'No Comments';
	$total_comments = $comments_query->num_rows();
	if($total_comments == 1)
	{
		$title = 'comment';
	}
	else
	{
		$title = 'comments';
	}
	
	if($comments_query->num_rows() > 0)
	{
		$comments = '';
		foreach ($comments_query->result() as $row)
		{
			$post_comment_user = $row->post_comment_user;
			$post_comment_description = $row->post_comment_description;
			$date = date('jS M Y H:i a',strtotime($row->comment_created));
			
			$comments .= 
			'
				<!--=======  COMMENTS =========-->
				<li class="media">
					<div class="media-left"> <a href="#"> <img class="media-object" src="'.base_url().'assets/images/avatar.jpg" alt=""> </a> </div>
					<div class="media-body light-gray-bg">
						<h6 class="media-heading">'.$post_comment_user.'<span> '.$date.'</span></h6>
						<p>'.$post_comment_description.'</p>
					</div>
				</li>
			';
		}
	}
	



?>
<!--======= SUB BANNER =========-->
<section class="sub-banner">
    <div class="container">
        <div class="position-center-center">
            <h2>Blog</h2>
            <ul class="breadcrumb">
                <li><a href="<?php echo site_url();?>">Home</a></li>
                <li><a href="<?php echo site_url().'blog';?>">Blog</a></li>
                <li><?php echo $post_title;?></li>
            </ul>
        </div>
    </div>
</section>

<!-- Content -->
<div id="content"> 

	<!-- Latest News -->
	<section class="latest-news blog blog-single padding-top-100 padding-bottom-100">
		<div class="container"> 

			<!-- Blog Side -->
			<div class="row">
				<div class="col-md-9"> 

					<!-- News 1 -->
					<article class="margin-bottom-50"> <a href="#"> <img class="img-responsive" src="<?php echo $image;?>" alt="<?php echo $post_title;?>"> </a>
						<div class="news-detail">
							<div class="row">
								<div class="col-md-3 text-center">
									<p><?php echo $created_on;?> </p>
									<p><i class="fa fa-comment"></i><?php echo $total_comments;?> </p>
								</div>
								
								<div class="col-md-9"> 
									<a href="#"><?php echo $post_title;?></a>
									<?php echo $description;?>
								</div>
							</div>
						</div>
					</article>

					<!--=======  COMMENTS =========-->
					<div class="comments">
						<h4 class="text-uppercase"><?php echo $total_comments;?> <?php echo $title;?> </h4>
						<ul class="media-list">
							<?php echo $comments;?> 
						</ul>
                        
                        <?php
							$validation_errors = validation_errors();
							$errors = $this->session->userdata('error_message');
							$success = $this->session->userdata('success_message');
							
							if(!empty($validation_errors))
							{
								echo '<div style="color:red;">'.$validation_errors.'</div>';
							}
							
							if(!empty($errors))
							{
								echo '<div style="color:red;">'.$errors.'</div>';
								$this->session->unset_userdata('error_message');
							}
							
							if(!empty($success))
							{
								echo '<div style="color:green;">'.$success.'</div>';
								$this->session->unset_userdata('success_message');
							}
						?>
						<!--=======  LEAVE COMMENTS =========-->
						<h4 class="font-alegreya">leave a comment</h4>
						<form action="<?php echo site_url().'add_comment/'.$post_id.'/'.$web_name;?>">
							<ul class="row">
								<li class="col-sm-6">
									<label> Name
										<input type="text" class="form-control" name="name" placeholder="" >
									</label>
								</li>
								<li class="col-sm-6">
									<label> Email
										<input type="text" class="form-control" name="email" placeholder="" >
									</label>
								</li>

								<li class="col-sm-12">
									<label> COMMENTS
										<textarea class="form-control" name="post_comment_description"></textarea>
									</label>
								</li>
								<li class="col-sm-12">
									<button type="submit" class="btn">Add comment </button>
								</li>
							</ul>
						</form>
					</div>
				</div>
    
                <div class="col-md-3"> 
                    <!-- Sidebar area -->
                    <?php echo $this->load->view('blog/includes/sidebar', '', TRUE);?>
                    <!-- Sidebar area end -->
                </div>
			</div>
		</div>
	</section>

</div>
<!-- End Content --> 
