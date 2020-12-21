<?php get_header(); ?>

<?php 

	global $wp_query, $more, $ewf_theme_settings;
	$date = null;
	$page_title = null;
	
	
	
	#	If this page shows Categories
	#
	if ($wp_query->is_category == 1 && $wp_query->is_archive == 1) {
		$cat_ID = get_query_var('cat');
		$categ = get_category($cat_ID,false);
			
		$page_title = '<div class="alert info">'.__('Viewing posts categorised under', EWF_SETUP_THEME_DOMAIN).': <strong>'.ucfirst($categ->name).'</strong></div>';
	}

	
	#	If this page shows Tags
	#
	if ($wp_query->is_tag == 1 && $wp_query->is_archive == 1) {
		$tag_name = $wp_query->queried_object->name;
		$page_title = '<div class="alert info">'.__('Showing posts from tagged with', EWF_SETUP_THEME_DOMAIN).': <strong>'.$tag_name.'</strong></div>';
	}
	
	
	#	If this page shows Archives by date
	#
	if ($wp_query->is_category == null && $wp_query->is_archive == 1 && $wp_query->is_month = 1 && $wp_query->is_tag == 0 ) {
		
		if (get_query_var('monthnum').get_query_var('year') != null ){
			$tmp_date = '1'.'-'.get_query_var('monthnum').'-'.get_query_var('year');
			$date = date('F Y' ,strtotime($tmp_date));					
		}
		
		if (get_query_var('m') != null ){
			$tmp_year = substr(get_query_var('m'), 0, 4);
			$tmp_month = substr(get_query_var('m'), 5, 7);
			
			$tmp_date = '1'.'-'.$tmp_month.'-'.$tmp_year;
			$date = date('F Y' ,strtotime($tmp_date));					
		}
		
		$page_title = '<div class="alert info">'.__('Viewing posts from', EWF_SETUP_THEME_DOMAIN).': <strong>'.$date.'</strong></div>';
	} 

	
	
	$page_blog = ewf_get_page_relatedID();
	$sidebar_id = ewf_get_sidebar_id( $ewf_theme_settings['blog']['sidebar'] , $page_blog);
	$page_layout = ewf_get_sidebar_layout( $ewf_theme_settings['blog']['layout'], $page_blog );

	
	switch ($page_layout) {
	
		case "layout-sidebar-single-left": 
			echo '<div class="ewf-row">';
				echo '<div class="ewf-span4">';
					
					if ( !function_exists('dynamic_sidebar')  || !dynamic_sidebar( $sidebar_id ));
					
				echo '</div>';
				echo '<div class="ewf-span8">';
						
					if ($page_title != null){ echo $page_title; }
					
					if ( have_posts() ) while ( have_posts() ) : the_post(); 
						get_template_part('templates/blog-item-default');
					endwhile;
					
					echo ewf_sc_blog_navigation_pages(4, $wp_query);
						
				echo '</div>';
			echo '</div>'; 
			break;
	
		case "layout-sidebar-single-right": 
			echo '<div class="ewf-row">';
				echo '<div class="ewf-span8">';
				
					if ($page_title != null){ echo $page_title; }
					
					if ( have_posts() ) while ( have_posts() ) : the_post(); 
						get_template_part('templates/blog-item-default');
					endwhile; 
					
					echo ewf_sc_blog_navigation_pages(4, $wp_query);
					
				echo '</div>';
				echo '<div class="ewf-span4">';
			
					if ( !function_exists('dynamic_sidebar')  || !dynamic_sidebar( $sidebar_id ));
					
				echo '</div>';
			echo '</div>';
			break; 
	
		case "layout-full": 
			echo '<div class="ewf-row">';
				echo '<div class="ewf-span12">';
				
					if ($page_title != null){ echo $page_title; }
					
					if ( have_posts() ) while ( have_posts() ) : the_post(); 
						get_template_part('templates/blog-item-default');
					endwhile; 
					
					echo ewf_sc_blog_navigation_pages(4, $wp_query);
					
				echo '</div>';
			echo '</div>';
			break; 
	}	

?>
	
<?php get_footer(); ?>