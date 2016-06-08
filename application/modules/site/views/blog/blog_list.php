<?php

		$result = '';
		
		//if users exist display them
	
		if ($query->num_rows() > 0)
		{	
			//get all administrators
			$administrators = $this->users_model->get_all_administrators();
			if ($administrators->num_rows() > 0)
			{
				$admins = $administrators->result();
			}
			
			else
			{
				$admins = NULL;
			}
			
			foreach ($query->result() as $row)
			{
				$post_id = $row->post_id;
				$blog_category_name = $row->blog_category_name;
				$blog_category_id = $row->blog_category_id;
				$post_title = $row->post_title;
				$web_name = $this->site_model->create_web_name($post_title);
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
								<div class="user_comment">
									<h5>'.$post_comment_user.' - '.$date.'</h5>
									<p>'.$post_comment_description.'</p>
								</div>
							';
						}
					}
				$result .= '
					<article class="margin-bottom-50"> <a href="'.site_url().'blog/'.$web_name.'"> <img class="img-responsive" src="'.$image.'" alt="'.$post_title.'"> </a>
						<div class="news-detail">
							<div class="row">
								<div class="col-md-3 text-center">
									<p>'.$created_on.' </p>
									<p><i class="fa fa-comment"></i>'.$total_comments.'  </p>
								</div>
								<div class="col-md-9"> <a href="'.site_url().'blog/'.$web_name.'">'.$post_title.'</a>
									<p>'.$mini_desc.'</p>
								</div>
							</div>
						</div>
					</article>
		            ';
		        }
			}
			else
			{
				$result .= "There are no posts :-(";
			}
           
          ?>       
<!--======= SUB BANNER =========-->
<section class="sub-banner">
    <div class="container">
        <div class="position-center-center">
            <h2>Blog</h2>
            <ul class="breadcrumb">
                <li><a href="<?php echo site_url();?>">Home</a></li>
                <li>Blog</li>
            </ul>
        </div>
    </div>
</section>   

  
<!-- Content -->
<div id="content"> 

    <!-- Latest News -->
    <section class="latest-news blog padding-top-100 padding-bottom-100">
    	<div class="container"> 
            <!-- Blog Side -->
            <div class="row">
                <div class="col-md-9"> 
                    
                    <?php echo $result;?>
                    
                    <ul class="pm-post-loaded-info news">
                        <li>
                            <p>Viewing <strong><?php echo $last;?></strong> of <strong><?php echo $total;?></strong> posts</p>
                        </li>
                    </ul>
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