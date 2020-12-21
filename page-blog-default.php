<?php

/*
Template Name: Blog - Single column
*/


get_header(); 


	#	Get page settings - layout, sidebar, blog page
	#
	$page_blog 		= ewf_get_page_relatedID();
	$page_blog_data = get_post($page_blog);
	
	$page_for_posts = get_option('page_for_posts');
	$page_on_front  = get_option('page_on_front');
	
	$page_sidebar 	= ewf_get_sidebar_id('sidebar-page', $page_blog);
	$page_layout 	= ewf_get_sidebar_layout("layout-sidebar-single-right", $page_blog );
	$ewf_blog_items = get_option('posts_per_page');

	
	
	#echo '<div class="ewf-row"><div class="alert alert-info"><strong>Page blog ID</strong>:'.$page_blog.' &nbsp;&nbsp;&nbsp;&nbsp; <strong>Sidebar Settings</strong>:'.$page_layout.'</div></div>';
	
	
	switch ($page_layout) {
	
		case "layout-sidebar-single-left": 
			echo '<div class="ewf-row">';
				echo '<div class="ewf-span4">';
					dynamic_sidebar($page_sidebar);
				echo '</div>';
				echo '<div class="ewf-span8">';
				
					if ($page_for_posts == $page_blog){ 
						echo apply_filters('the_content',$page_blog_data->post_content);
					}
					
					echo do_shortcode('[blog '.$ewf_blog_items.' sidebar="true" ]');
						
				echo '</div>';
			echo '</div>';
			break;
	
		case "layout-sidebar-single-right": 
			echo '<div class="ewf-row">';
				echo '<div class="ewf-span8">';

					if ($page_for_posts == $page_blog){ 
						echo apply_filters('the_content',$page_blog_data->post_content);
					}
					
					echo do_shortcode('[blog '.$ewf_blog_items.' sidebar="true" ]');
					
				echo '</div>';
				echo '<div class="ewf-span4">';
					dynamic_sidebar($page_sidebar);
				echo '</div>';
			echo '</div>';
			break; 
	
		case "layout-full": 
			echo '<div class="ewf-row">';
				echo '<div class="span12">';
			
					if ($page_for_posts == $page_blog){ 
						echo apply_filters('the_content',$page_blog_data->post_content);
					}
					
					echo do_shortcode('[blog '.$ewf_blog_items.']');

				echo '</div>';
			echo '</div>';
	}
	

?>
	
<?php	get_footer();  ?>