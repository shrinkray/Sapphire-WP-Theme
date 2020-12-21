<?php get_header(); ?>

<?php		


# 	Get sidebar ID
#
	$page_portfolio_sidebar = ewf_get_sidebar_id('sidebar-portfolio');		
	
	
	
# 	Load page layout depending on page settings
#
	$page_layout = ewf_get_sidebar_layout("layout-full");
	switch ($page_layout) {
	
		case "layout-sidebar-single-left": 
							
			echo '<div class="ewf-row">';
				echo '<div class="ewf-span3">';
			
				if ( !function_exists('dynamic_sidebar')  || !dynamic_sidebar( $page_portfolio_sidebar ));
				
				echo '</div>';
				echo '<div class="ewf-span9">';
					
					if ( have_posts() ) while ( have_posts() ) : the_post(); 																
						echo the_content();
					endwhile; 
					
				echo '</div>';
			echo '</div>';
			break;
	
		case "layout-sidebar-single-right": 
				
			echo '<div class="ewf-row">';
				echo '<div class="ewf-span9">';
					
					if ( have_posts() ) while ( have_posts() ) : the_post(); 																
						echo the_content();
					endwhile; 
					
				echo '</div>';
				echo '<div class="ewf-span3">';
			
				if ( !function_exists('dynamic_sidebar')  || !dynamic_sidebar( $page_portfolio_sidebar ));
				
				echo '</div>';
			echo '</div>';
			break; 
	
		case "layout-full":  
			if ( have_posts() ) while ( have_posts() ) : the_post(); 
				
				//echo '<div class="ewf-row">';
					//echo '<div class="ewf-span12">';
					
						echo the_content();
						
					//echo '</div>';
				//echo '</div>';
			 
			endwhile; 
			break;
	}
	
?>
	
<?php get_footer(); ?>