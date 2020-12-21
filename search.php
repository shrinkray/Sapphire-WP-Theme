<?php get_header(); ?>

<?php

	global $wp_query, $more, $ewf_theme_settings;
	
	
	
	#	Display page results info box
	#
	$ewf_search_result_message = null;
	if ($wp_query->found_posts == 0){
		$ewf_search_result_message = '<div class="alert info">'.__('No posts were found!', EWF_SETUP_THEME_DOMAIN).'</div>';
	}else{
		$ewf_search_result_message = '<div class="alert info">'.__('Search results for', EWF_SETUP_THEME_DOMAIN).': <strong>'.$wp_query->query_vars['s'].'</strong></div>';
	} 
	

	
	#	Get page settings - layout, sidebar
	#
	$page_blog = ewf_get_page_relatedID();
	$page_sidebar = ewf_get_sidebar_id( $ewf_theme_settings['blog']['sidebar'] , $page_blog);
	$page_layout = ewf_get_sidebar_layout( $ewf_theme_settings['blog']['layout'], $page_blog );
		
	/* Scenario where search is made on full site or just on the blog
	 * 
	if (array_key_exists('post_type', $_GET)){
		$page_layout = ewf_get_sidebar_layout( $ewf_theme_settings['blog']['layout'], $page_blog );
	}else{
		$page_layout = "layout-full-site"; 
	}
	*/
	
	
	switch ($page_layout) {
	
		#	Seach on blog using right sidebar
		#			
		case "layout-sidebar-single-left": 
			echo '<div class="ewf-row">';
				echo '<div class="ewf-span4">';
				
					dynamic_sidebar($page_sidebar);
					
				echo '</div>';
				echo '<div class="ewf-span8">';
				
					echo $ewf_search_result_message;
					if ( have_posts() ) while ( have_posts() ) : the_post(); 
						get_template_part('templates/blog-item-default');
					endwhile; 
					
					echo ewf_sc_blog_navigation_pages(4, $wp_query);
						
				echo '</div>';
			echo '</div>';
			break;
		
		
		# 	Seach on blog using right sidebar
		#			
		case "layout-sidebar-single-right": 
			echo '<div class="ewf-row">';
				echo '<div class="ewf-span8">';
				
					echo $ewf_search_result_message;
					if ( have_posts() ) while ( have_posts() ) : the_post(); 
						get_template_part('templates/blog-item-default');
					endwhile; 
					
					echo ewf_sc_blog_navigation_pages(4, $wp_query);
						
				echo '</div>';
				echo '<div class="ewf-span4">';
				
					dynamic_sidebar($page_sidebar);
					
				echo '</div>';
			echo '</div>';
			break;
	
	
		#	Seach on blog using full content
		#
		case "layout-full": 
			echo '<div class="ewf-row">';
				echo '<div class="ewf-span12">';
				
					echo $ewf_search_result_message;
					if ( have_posts() ) while ( have_posts() ) : the_post(); 
						get_template_part('templates/blog-item-default');
					endwhile; 
					
					echo ewf_sc_blog_navigation_pages(4, $wp_query);
				
				echo '</div>';
			echo '</div>';
			break;
			
			
		# 	Seach on site using full content
		#
		case "layout-full-site": 
			echo '<div class="ewf-row">';
				echo '<div class="ewf-span8">';
				
					echo $ewf_search_result_message;
					if ( have_posts() ) while ( have_posts() ) : the_post(); 
						get_template_part('templates/blog-item-default');
					endwhile; 
					
					echo ewf_sc_blog_navigation_pages(4, $wp_query);
						
				echo '</div>';
				echo '<div class="ewf-span4">';
				
					dynamic_sidebar($page_sidebar);
					
				echo '</div>';
			echo '</div>';
			break;

	}

?>
	
<?php get_footer(); ?>