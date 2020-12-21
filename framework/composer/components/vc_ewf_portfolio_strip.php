<?php
	
	
	#	Register image size for project
	#
	add_image_size( 'ewf-portfolio-strip', 380, 380, true);
	
	
	#	Register shortcode for Visual Composer component
	#
	add_shortcode( 'ewf-portfolio-strip', 'ewf_vc_portfolio_strip' );
	
	add_action('init', 'ewf_register_vc_portfolio_strip');
	
	
	function ewf_vc_portfolio_strip( $atts, $content ) {
		global $post;
		
	   extract( shortcode_atts( array(
			"items" 				=> 5,
			"id" 					=> null,
			"exclude" 				=> null,
			"details" 				=> 'excerpt',
			"order" 				=> "DESC",
			"list" 					=> "latest",
			"service" 				=> null
		), $atts));
		
		if ($service == 'All Services'){
			$service = null;
		}
	 
	 
		$query = array( 'post_type' => EWF_PROJECTS_SLUG,
						'order'=> $order, 
						'orderby' => 'date',  
						'posts_per_page'=>$items); 
		
		

		
		
		#	Arrange depending on listing style  Latest / Random / Service
		switch($list ){
		
			case 'latest':
				$query['order'] = 'DESC';
				$query['orderby'] = 'date';
				break;
				
			case 'random':
				$query['order'] = 'DESC';
				$query['orderby'] = 'rand';
				break;
				
			case 'service':
				if ($order == 'rand'){
					$query['order'] = 'rand';
					$query['orderby'] = 'rand';
				}else{
					$query['order'] = 'DESC';
					$query['orderby'] = 'date';
				}
				break;
				
			default:
				$query['order'] = 'DESC';
				$query['orderby'] = 'date';
				break;
				
		}
		
		
		
		
		
	
		if ($exclude != null){
			if (is_numeric($exclude)){
				$exclude_items[] = $exclude ;
			}else{
				$tmp_id = explode(',', trim($exclude));
				foreach($tmp_id as $key => $item_id){
					if (is_numeric($item_id)){
						$exclude_items[] = $item_id ;
					}
				}
			}
			
			$query['post__not_in'] = $exclude_items;
		}
		
	
		if ($id != null){
			if (is_numeric($id)){
				$include_posts[] = $id ;
			}else{
				$tmp_id = explode(',', trim($id));
				foreach($tmp_id as $key => $item_id){
					if (is_numeric($item_id)){
						$include_posts[] = $item_id ;
					} 
				}
			}
			
			unset($query['post__not_in']);
			unset($query['tax_query']);
			
			$query['post__in'] = $include_posts;
			$query['posts_per_page'] = count($include_posts);
		}
		
		if ($service != null){
			$query['tax_query'] = array(
				array(
					'taxonomy' => EWF_PROJECTS_TAX_SERVICES,
					'field' => 'slug',
					'terms' => array( $service )
				));
		}
		
		
		
					
		
		ob_start();
		echo '<ul class="portfolio-strip fixed" data-list="'.$list.'">';
		
		$wp_query_portfolio_strip = new WP_Query($query);
		while ($wp_query_portfolio_strip->have_posts()) : $wp_query_portfolio_strip->the_post();
			global $post;
		
			$image_id = get_post_thumbnail_id();  
			$image_preview_small = wp_get_attachment_image_src( $image_id, 'ewf-portfolio-strip');						
			$image_preview_large = wp_get_attachment_image_src( $image_id, 'large');	
 
		
			echo ' <li>';
			echo '<div class="portfolio-item">';
						
				echo '<div class="portfolio-item-preview">';	
				
					if ($image_id) {
						echo '<a href="#"><img src="'.$image_preview_small[0].'" alt=""></a>';
					}
					
					echo '<div class="portfolio-item-overlay">';
						
						echo '<div class="portfolio-item-overlay-actions">';
							echo '<a class="magnificPopup-gallery portfolio-item-zoom" href="'.$image_preview_large[0].'" title="zoom">';
							echo '	<i class="ifc-zoom_in"></i>';
							echo '</a>';
							
							echo '<a class="portfolio-item-link" href="'.get_permalink().'" title="zoom">';
							echo '	<i class="ifc-link"></i>';
							echo '</a>';
						echo '</div><!-- end .portfolio-item-overlay-actions -->';
						
						echo '<div class="portfolio-item-description">';
							echo '<h4 class="text-uppercase">'.get_the_title().'</h4>';
							
							switch ($details){
								
								case 'excerpt':
									echo '<p>'.get_the_excerpt().'</p>';
									break;
									 
								case 'services':
									$ewf_project_services = null;
									$ewf_project_terms = get_the_terms ($post->ID, EWF_PROJECTS_TAX_SERVICES);

									if (is_array($ewf_project_terms)){
										foreach($ewf_project_terms as $key => $service){
										
											if ($ewf_project_services == null){
												// $ewf_project_services.= '<a href="'.get_term_link($service->slug, EWF_PROJECTS_TAX_SERVICES).'">'.$service->name.'</a>';
												$ewf_project_services.= '<span>'.$service->name.'</span>';
											}else{
												// $ewf_project_services.= ', <a href="'.get_term_link($service->slug, EWF_PROJECTS_TAX_SERVICES).'">'.$service->name.'</a>';
												$ewf_project_services.= ', <span>'.$service->name.'</span>';
											}
										}
										
										echo '<p>'.$ewf_project_services.'</p>';
									}
									break;
									 
								case 'none':
									break;
									 
								default:
									echo '<p>'.get_the_excerpt().'</p>';
									break;
							
							}
							
							
							
						echo '</div><!-- end .portfolio-item-description -->';
					
					echo '</div><!-- end .portfolio-item-overlay -->';
				echo '</div><!-- end .portfolio-item-preview -->';

			echo '</div><!-- end .portfolio-item -->';
			echo '</li>';
			
			
		endwhile;
		
		echo '</ul> <!-- end .strip-portfolio -->';
		
		
		
		return ob_get_clean();
	 
	}
		
	
	function ewf_vc_portfolio_strip_services(){
		global $ewf_portfolioStrip_services;
		
		$services = array();	// array('All Services');
		$terms = get_terms (EWF_PROJECTS_TAX_SERVICES); 
	
		if (is_array($terms)){
			foreach($terms as $key => $service){

				$services[] = $service->slug;
				
			}
		}
  		
		return $services;
	}
		
	
	
	function ewf_register_vc_portfolio_strip(){
	
		vc_map( array(
		   "name" => __("Portfolio Strip", EWF_SETUP_THEME_DOMAIN),
		   "base" => "ewf-portfolio-strip",
		   "class" => "",
		   "icon" => "icon-wpb-ewf-portfolio-strip",
		   "description" => __("Add a full width row with porftolio items", EWF_SETUP_THEME_DOMAIN), 
		   "category" => __('Portfolio', EWF_SETUP_THEME_DOMAIN),
		   "params" => array(
			  array(
				 "type" => "dropdown",
				 "holder" => "div",
				 "class" => "",
				 "heading" => __("Load 5 portfolio items", EWF_SETUP_THEME_DOMAIN),
				 "param_name" => "list",
				 "value" => array(
					__('Latest projects', EWF_SETUP_THEME_DOMAIN) => 'latest',
					__('From a service', EWF_SETUP_THEME_DOMAIN) => 'service', 
					__('Random', EWF_SETUP_THEME_DOMAIN) => 'random', 
				),
			  ),
			  array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __("Service", EWF_SETUP_THEME_DOMAIN),
				"param_name" => "service",
				"value" => ewf_vc_portfolio_strip_services(),
				"description" => __("Specify projects from a defined category", EWF_SETUP_THEME_DOMAIN),
				"dependency" => Array("element" => "list","value" => array('service'))
			  ),
			  array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __("Projects order", EWF_SETUP_THEME_DOMAIN),
				"param_name" => "order",
				"value" => array( 
					__("Descendent", EWF_SETUP_THEME_DOMAIN)  => 'DESC', 
					__("Ascendent", EWF_SETUP_THEME_DOMAIN) => 'ASC',
					__("Random", EWF_SETUP_THEME_DOMAIN) => 'rand',
				),
				 "dependency" => Array("element" => "list","value" => array('service')),
				 "description" => __("Load projects in a Ascendent(1,2,3), Descendent (3,2,1) order or random.", EWF_SETUP_THEME_DOMAIN)
			  ),
			  array(
				"type" => "dropdown",
				"holder" => "div",
				"class" => "",
				"heading" => __("Secondary info", EWF_SETUP_THEME_DOMAIN),
				"param_name" => "details",
				"value" => array(
					__('Project Excerpt', EWF_SETUP_THEME_DOMAIN) => 'excerpt',
					__('Project Services', EWF_SETUP_THEME_DOMAIN) => 'services', 
					__("Don't show", EWF_SETUP_THEME_DOMAIN) => 'none', 
				),
				"description" => __("Specify what to show below the project title", EWF_SETUP_THEME_DOMAIN),
			  ),
		   )
		));
	
	}


?>