<?php
	
	#	Register image size for project
	#
	add_image_size( 'ewf-portfolio-featured', 460, 300, true);
	
	
	#	Register shortcode for Visual Composer component
	#
	add_shortcode( 'ewf-portfolio-featured', 'ewf_vc_portfolio_featured' );
	
	add_action('init', 'ewf_register_vc_portfolio_featured');
	
	
	function ewf_vc_portfolio_featured( $atts, $content ) {
		global $post;
		
	   extract( shortcode_atts( array(
			"order" 				=> 'DESC',
			"id" 					=> null
		), $atts));
		

		$query = array( 'post_type' => EWF_PROJECTS_SLUG,
						'order'=> $order, 
						'orderby' => 'date',  
						'post__in' => array($id),  
						'posts_per_page'=>1); 

		ob_start();
		
		
		// echo '<pre>';
			// print_r($id);
		// echo '</pre>';
		
		$wp_query_portfolio_strip = new WP_Query($query);
		while ($wp_query_portfolio_strip->have_posts()) : $wp_query_portfolio_strip->the_post();
			global $post;
		
			$image_id = get_post_thumbnail_id();  
			$image_preview_small = wp_get_attachment_image_src( $image_id, 'ewf-portfolio-featured');						
			$image_preview_large = wp_get_attachment_image_src( $image_id, 'large');	
		
			echo '<div class="portfolio-item">';
	
				echo '<div class="portfolio-item-preview">';
					echo '<a href="#"><img src="'.$image_preview_small[0].'" alt=""></a>';
					
					echo '<div class="portfolio-item-overlay">';
						echo '<div class="portfolio-item-overlay-actions">';
							echo '<a class="magnificPopup-gallery portfolio-item-zoom" href="'.$image_preview_large[0].'" title="zoom"><i class="ifc-zoom_in"></i></a>';
							echo '<a class="portfolio-item-link" href="'.get_permalink().'" title="zoom"><i class="ifc-link"></i></a>';
						echo '</div><!-- end .portfolio-item-overlay-actions -->';
						
						
						echo '<div class="portfolio-item-description hidden-tablet">';
							echo '<h4 class="text-uppercase">'.get_the_title().'</h4>';
							echo '<p>'.get_the_excerpt().'</p>';
						echo '</div><!-- end .portfolio-item-description -->';
					echo '</div><!-- end .portfolio-item-overlay -->';
				
				echo '</div><!-- end .portfolio-item-preview -->';
				
			echo '</div><!-- end .portfolio-item -->';
			
		endwhile;
	
		
		return ob_get_clean();
	 
	}
		
	
	// function ewf_vc_portfolio_featured_services(){
		// global $ewf_portfolioStrip_services;
		
		// $services = array();	// array('All Services');
		// $terms = get_terms (EWF_PROJECTS_TAX_SERVICES); 
	
		// if (is_array($terms)){
			// foreach($terms as $key => $service){

				// $services[] = $service->slug;
			// }
		// }
  		
		// return $services;
	// }
		
	
	
	
	function ewf_vc_portfolio_items(){
		$result = array();
	
		$query = array( 'post_type' => EWF_PROJECTS_SLUG,
						'order'=> 'DESC', 
						'orderby' => 'date',  
						'posts_per_page' => -1); 
						
		$wp_query_portfolio_strip = new WP_Query($query);
		while ($wp_query_portfolio_strip->have_posts()) : $wp_query_portfolio_strip->the_post();
			global $post;
			
			$result[get_the_title()] = $post->ID;
		endwhile;
		
		return $result;
	}
	
	
	function ewf_register_vc_portfolio_featured(){
	
		vc_map( array(
		   "name" => __("Portfolio Item Featured", EWF_SETUP_THEME_DOMAIN),
		   "base" => "ewf-portfolio-featured",
		   "class" => "",
		   "icon" => "icon-wpb-ewf-portfolio-featured",
		   "description" => __("Add a full width row with portfolio items", EWF_SETUP_THEME_DOMAIN), 
		   "category" => __('Portfolio', EWF_SETUP_THEME_DOMAIN),
		   "params" => array(
			  // array(
				 // "type" => "textfield",
				 // "holder" => "div",
				 // "class" => "",
				 // "heading" => __("Portfolio items", EWF_SETUP_THEME_DOMAIN),
				 // "param_name" => "items",
				 // "value" => 9,
				 // "description" => __("Select the number of items you want to load", EWF_SETUP_THEME_DOMAIN)
			  // ),
			  array(
				 "type" => "dropdown",
				 "holder" => "div",
				 "class" => "",
				 "heading" => __("Choose a portfolio item from the list below", EWF_SETUP_THEME_DOMAIN),
				 "param_name" => "id",
				 "value" => ewf_vc_portfolio_items(),
			  ),

		   )
		));
	
	}


?>