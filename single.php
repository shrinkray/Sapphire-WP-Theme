<?php get_header(); ?>

<?php 
	
	global $ewf_theme_settings;
	
	$page_blog = ewf_get_page_relatedID();
	$page_blog_sidebar = ewf_get_sidebar_id( $ewf_theme_settings['blog']['sidebar'] , $page_blog);
	$page_layout = ewf_get_sidebar_layout( $ewf_theme_settings['blog']['layout'], $page_blog );
	
	
	// echo '<br/>### Page blog ID:'.$page_blog;
	// echo '<br/>### Page Layout: '.$page_layout;
	// echo '<br/>### Page Sidebar: '.$page_blog_sidebar;
	
	switch ($page_layout) {
	
		case "layout-sidebar-single-left": 
			echo '<div class="ewf-row">';
				echo '<div class="ewf-span4">';
				
					dynamic_sidebar($page_blog_sidebar);
					
				echo '</div>';
				echo '<div class="ewf-span8">';
				
					if ( have_posts() ) while ( have_posts() ) : the_post(); 
						get_template_part('templates/blog-item-default');
					endwhile; 
					
				echo '</div>';
			echo '</div>';		
			break;
			
	
		case "layout-sidebar-single-right":
			echo '<div class="ewf-row">';
				echo '<div class="ewf-span8">';
					
					if ( have_posts() ) while ( have_posts() ) : the_post(); 
						get_template_part('templates/blog-item-default');
					endwhile; 
						
				echo '</div>';
				echo '<div class="ewf-span4">';
				
					dynamic_sidebar($page_blog_sidebar);
					
				echo '</div>';
			echo '</div>';	
			break;
	
		case "layout-full": 
			echo '<div class="ewf-row">';
				echo '<div class="ewf-span12">';
				
					if ( have_posts() ) while ( have_posts() ) : the_post(); 
						get_template_part('templates/blog-item-default');
					endwhile; 
					
				echo '</div>';
			echo '</div>';	
			break;
			
	}

?>
		
<?php get_footer(); ?>