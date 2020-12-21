<?php

	

#	Visual Composer - Extenders
#
	include_once ('extender-vc_row.php');
	include_once ('params/ewf-param-icon/ewf-param-icon.php');  



#	Visual Composer - EWF Components
#
	// include_once ('components/vc_ewf_slider_case_studies.php');
	// include_once ('components/vc_ewf_portfolio_isotope.php');
	// include_once ('components/vc_ewf_our_process.php'); 
	// include_once ('components/vc_ewf_service_overview.php');
	// include_once ('components/vc_ewf_service.php');
	// include_once ('components/vc_ewf_blog_posts.php');
	// include_once ('components/vc_ewf_page_slider.php');
	
	include_once ('components/vc_ewf_divider.php'); 
	include_once ('components/vc_ewf_button.php'); 
	include_once ('components/vc_ewf_headline.php');
	include_once ('components/vc_ewf_message_box.php');
	include_once ('components/vc_ewf_milestone.php'); 
	include_once ('components/vc_ewf_pricing.php');
	include_once ('components/vc_ewf_map.php');
	include_once ('components/vc_ewf_portfolio_strip.php');
	include_once ('components/vc_ewf_portfolio_grid.php');
	include_once ('components/vc_ewf_portfolio_featured.php');
	include_once ('components/vc_ewf_process_vertical.php');
	include_once ('components/vc_ewf_process_horizontal.php');
	include_once ('components/vc_ewf_logo.php');
	include_once ('components/vc_ewf_progress.php');
	include_once ('components/vc_ewf_piechart.php');
	include_once ('components/vc_ewf_iconbox.php');
	include_once ('components/vc_ewf_team_member.php'); 
	include_once ('components/vc_ewf_slider_testimonials.php');
	include_once ('components/vc_ewf_testimonial.php');
	include_once ('components/vc_ewf_testimonial_adv.php');

	
	ewf_load_composer();
	
	
	function ewf_load_composer(){

		
		if(function_exists('vc_set_as_theme')) {
			vc_set_as_theme();
		}
		
		if (function_exists('vc_set_template_dir')){
			$dir = get_template_directory() . '/framework/composer/templates/';
			
			vc_set_template_dir($dir);
		}
		
		if (function_exists('vc_disable_frontend')){
			vc_disable_frontend();
		}
		
		add_filter('vc_shortcodes_css_class', 'ewf_composer_custom_classes', 10, 2);
		
	}
	
	
	function ewf_composer_custom_classes($class_string, $tag) {
	
		$class_string = str_replace( array(' vc_row-fluid', ' column_container', ' wpb_column', 'wpb_row') , array( null, null, null, 'ewf-row'), $class_string);
		$class_string = str_replace( 'wpb_wrapper', 'ewf-wrapper', $class_string); 
		$class_string = preg_replace('/vc_span(\d{1,2})/', 'ewf-span$1', $class_string);

		return $class_string;
	
	}
	

#	Remove unstyled components
#
	// vc_remove_element("vc_flickr");
	// vc_remove_element("vc_gallery");
	// vc_remove_element("vc_images_carousel");
	
	vc_remove_element("vc_wp_search");
	vc_remove_element("vc_wp_meta");
	vc_remove_element("vc_wp_calendar");
	vc_remove_element("vc_wp_pages");
	vc_remove_element("vc_wp_recentcomments");
	vc_remove_element("vc_wp_tagcloud");
	vc_remove_element("vc_wp_custommenu");
	vc_remove_element("vc_wp_text");
	vc_remove_element("vc_wp_posts");
	vc_remove_element("vc_wp_posts");
	vc_remove_element("vc_wp_links");
	vc_remove_element("vc_wp_categories");
	vc_remove_element("vc_wp_archives");
	vc_remove_element("vc_wp_rss");
	vc_remove_element("vc_tour"); 
	vc_remove_element("vc_gmaps");
	vc_remove_element("vc_message");
	vc_remove_element("vc_facebook");
	vc_remove_element("vc_tweetmeme");
	vc_remove_element("vc_googleplus");
	vc_remove_element("vc_pinterest");
	vc_remove_element("vc_text_separator");
	vc_remove_element("vc_separator");
	vc_remove_element("vc_progress_bar");
	vc_remove_element("vc_posts_slider");
	vc_remove_element("vc_carousel");
	vc_remove_element("vc_pie");
	vc_remove_element("vc_posts_grid");
	vc_remove_element("vc_button");
	vc_remove_element("vc_cta_button2");
	vc_remove_element("vc_button2");


	
?>