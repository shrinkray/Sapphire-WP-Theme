<?php get_header(); ?>

<?php 
	

	
	
	##	 Get page layout & sidebar
	##
	
	$page_sidebar = ewf_get_sidebar_id('sidebar-page');		
	$page_layout = ewf_get_sidebar_layout();
	
	
	
	switch ($page_layout) {
	
		case "layout-sidebar-single-left": 
			echo '<div class="ewf-row">';
				echo '<div class="ewf-span4">';
					dynamic_sidebar($page_sidebar);
				echo '</div>';
				echo '<div class="ewf-span8">';
				
					if ( have_posts() ) while ( have_posts() ) : the_post(); 										
						echo the_content();
						wp_link_pages();
					endwhile; 
						
				echo '</div>';
			echo '</div>';
			break;
	
		case "layout-sidebar-single-right": 
			echo '<div class="ewf-row">';
				echo '<div class="ewf-span8">';

					if ( have_posts() ) while ( have_posts() ) : the_post(); 
						echo the_content();
						wp_link_pages();
					endwhile; 

				echo '</div>';
				echo '<div class="ewf-span4">';
					dynamic_sidebar($page_sidebar);
				echo '</div>';
			echo '</div>';
			break; 
	
		case "layout-full": 
				if ( have_posts() ) while ( have_posts() ) : the_post(); 
					echo the_content();
					wp_link_pages();
				endwhile; 
	}

	
	
	
?>
		
<?php get_footer(); ?>
