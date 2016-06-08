<?php
$recent_query = $this->blog_model->get_recent_posts();

if($recent_query->num_rows() > 0)
{
	$row = $recent_query->row();
	
	$post_id = $row->post_id;
	$post_title = $row->post_title;
	$web_name = $this->site_model->create_web_name($post_title);
	$image = base_url().'assets/images/posts/thumbnail_'.$row->post_image;
	$comments = $this->users_model->count_items('post_comment', 'post_id = '.$post_id);
	$description = $row->post_content;
	$mini_desc = implode(' ', array_slice(explode(' ', $description), 0, 10));
	$created = date('jS M Y',strtotime($row->created));
	
	$recent_posts = '
			<li class="media">
				<div class="media-left"> 
					<a href="'.site_url().'blog/'.$web_name.'"> <img class="media-object" src="'.$image.'" alt=""></a> 
				</div>
				<div class="media-body"> 
					<a class="media-heading" href="'.site_url().'blog/'.$web_name.'">
						'.$mini_desc.'
					</a> 
					<span>'.$created.'</span> 
				</div>
			</li>
	';

}

else
{
	$recent_posts = 'No posts yet';
}

$categories_query = $this->blog_model->get_all_active_category_parents();
if($categories_query->num_rows() > 0)
{
	$categories = '';
	foreach($categories_query->result() as $res)
	{
		$category_id = $res->blog_category_id;
		$category_name = $res->blog_category_name;
		$web_name = $this->site_model->create_web_name($category_name);
		
		$children_query = $this->blog_model->get_all_active_category_children($category_id);
		
		//if there are children
		$categories .= '<li><a href="'.site_url().'blog/category/'.$web_name.'" title="View all posts filed under '.$category_name.'">'.$category_name.'</span></a></li>';
	}
}

else
{
	$categories = 'No Categories';
}
$popular_query = $this->blog_model->get_popular_posts();

if($popular_query->num_rows() > 0)
{
	$popular_posts = '';
	
	foreach ($popular_query->result() as $row)
	{
		$post_id = $row->post_id;
		$post_title = $row->post_title;
		$web_name = $this->site_model->create_web_name($post_title);
		$image = base_url().'assets/images/posts/thumbnail_'.$row->post_image;
		$comments = $this->users_model->count_items('post_comment', 'post_id = '.$post_id);
		$description = $row->post_content;
		$mini_desc = implode(' ', array_slice(explode(' ', $description), 0, 10));
		$created = date('jS M Y',strtotime($row->created));
		
		$popular_posts .= '
			<li class="media">
				<div class="media-left"> 
					<a href="'.site_url().'blog/'.$web_name.'"> <img class="media-object" src="'.$image.'" alt=""></a> 
				</div>
				<div class="media-body"> 
					<a class="media-heading" href="'.site_url().'blog/'.$web_name.'">
						'.$mini_desc.'
					</a> 
					<span>'.$created.'</span> 
				</div>
			</li>
		';
	}
}

else
{
	$popular_posts = 'No posts views yet';
}
?>

<div class="side-bar"> 
              
	<!-- Categories -->
	<h5 class="font-alegreya ">Categories</h5>
	<ul class="cate bg-defult">
		<?php echo $categories;?>
		<li><a href="<?php echo site_url().'blog';?>"><span>View All <i class="fa fa-long-arrow-right"></i></span></a></li>
	</ul>

	<!-- Popular Post -->
	<h5 class="font-alegreya">Popular Post</h5>
	<div class="papu-post margin-t-40">
		<ul class="bg-defult">
			<?php echo $popular_posts;?>
		</ul>
	</div>

	<!-- Popular Post -->
	<h5 class="font-alegreya">Recent Post</h5>
	<div class="papu-post margin-t-40">
		<ul class="bg-defult">
			<?php echo $recent_posts;?>
		</ul>
	</div>
</div>