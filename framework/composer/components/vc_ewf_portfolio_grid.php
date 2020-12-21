<?php
	
	
	#	Register image size for project
	#
	add_image_size( 'ewf-portfolio-grid', 300, 300, true);
	
	
	#	Register shortcode for Visual Composer component
	#
	add_shortcode( 'ewf-portfolio-grid', 'ewf_vc_portfolio_grid' );
	
	add_action('init', 'ewf_register_vc_portfolio_grid');
	
	
	function ewf_vc_portfolio_grid( $atts, $content ) {
		global $post;
		
		$options = shortcode_atts( array(
			"items" 				=> 9,
			"id" 					=> null,
			"exclude" 				=> null,
			"order" 				=> "DESC",
			"list" 					=> null,
			"service" 				=> null,
			"columns"				=> 3
		), $atts);
		
	   extract($options);
				
		if ($service == 'All Services'){
			$service = null;
		}
	 
		$query = array( 'post_type' => EWF_PROJECTS_SLUG,
						'order'=> $order, 
						'orderby' => 'date',  
						'posts_per_page'=>$items); 
						
	
		if ($list == 'latest'){
			$query['orderby'] = 'date';
			$query['order'] = 'DESC';
		}						
	
		if ($list == 'random'){
			$query['orderby'] = 'rand';
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
		
		if ($service != null && $list == 'service'){
			$query['tax_query'] = array(
				array(
					'taxonomy' => EWF_PROJECTS_TAX_SERVICES,
					'field' => 'slug',
					'terms' => array( $service )
				));
		}
		
		
		
					
		
		ob_start();
		
		
		$_ewf_rowItems = 0;
		$_ewf_span = 3;
		
		
		switch($columns){
			case '3': $_ewf_span = '4';break;
			case '4': $_ewf_span = '3';break;
		}
		
		
		// 	DEBUG
			// echo '<pre>';
				// print_r($atts);
				// print_r($options);
				// print_r($query);
			// echo '</pre>';
		
		
		$wp_query_portfolio_strip = new WP_Query($query);
		while ($wp_query_portfolio_strip->have_posts()) : $wp_query_portfolio_strip->the_post();
			global $post;
		
			$image_id = get_post_thumbnail_id();  
			$image_preview_small = wp_get_attachment_image_src( $image_id, 'ewf-portfolio-grid');						
			$image_preview_large = wp_get_attachment_image_src( $image_id, 'large');	
 
			
			if ($_ewf_rowItems == 0){
				echo '<div class="ewf-row">';
			}
			
			$_ewf_rowItems++;
			
			
			
					echo '<div class="ewf-span'.$_ewf_span.'">';
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
                    echo '</div><!-- end .ewf-span -->';

			if ($_ewf_rowItems == $columns){
				$_ewf_rowItems = 0;
				echo '</div>';
			}
			
		endwhile;
	
		
		return ob_get_clean();
	 
	}
		
	
	function ewf_vc_portfolio_grid_services(){
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
		
	
	
	function ewf_register_vc_portfolio_grid(){
	
		vc_map( array(
		   "name" => __("Portfolio Grid", EWF_SETUP_THEME_DOMAIN),
		   "base" => "ewf-portfolio-grid",
		   "class" => "",
		   "icon" => "icon-wpb-ewf-portfolio-grid",
		   "description" => __("Add a full width row with porftolio items", EWF_SETUP_THEME_DOMAIN), 
		   "category" => __('Portfolio', EWF_SETUP_THEME_DOMAIN),
		   "params" => array(
			  array(
				 "type" => "textfield",
				 "holder" => "div",
				 "class" => "",
				 "heading" => __("Number of portfolio items", EWF_SETUP_THEME_DOMAIN),
				 "param_name" => "items",
				 "value" => 9,
				 "description" => __("Select the number of items you want to load", EWF_SETUP_THEME_DOMAIN)
			  ),
			  array(
				 "type" => "dropdown",
				 "holder" => "div",
				 "class" => "",
				 "heading" => __("Prortfolio grid layout", EWF_SETUP_THEME_DOMAIN),
				 "param_name" => "columns",
				 "value" => array(
					__('3 Columns', EWF_SETUP_THEME_DOMAIN) => 3, 
					__('4 Columns', EWF_SETUP_THEME_DOMAIN) => 4, 
					// __('1 Column', EWF_SETUP_THEME_DOMAIN)
				),
			  ),
			  array(
				 "type" => "dropdown",
				 "holder" => "div",
				 "class" => "",
				 "heading" => __("How should the portfolio items to load, be chosen", EWF_SETUP_THEME_DOMAIN),
				 "param_name" => "list",
				 "value" => array( __('Random', EWF_SETUP_THEME_DOMAIN) => 'random', __('From a service', EWF_SETUP_THEME_DOMAIN)=>'service', __('Latest projects',EWF_SETUP_THEME_DOMAIN)=>'latest'),
			  ),
			  array(
				 "type" => "dropdown",
				 "holder" => "div",
				 "class" => "",
				 "heading" => __("Service", EWF_SETUP_THEME_DOMAIN),
				 "param_name" => "service",
				 "value" => ewf_vc_portfolio_grid_services(),
				 "description" => __("Specify projects from a defined category", EWF_SETUP_THEME_DOMAIN),
				 "dependency" => Array("element" => "list","value" => array("service"))
			  ),
			  array(
				 "type" => "dropdown",
				 "holder" => "div",
				 "class" => "",
				 "heading" => __("Projects order", EWF_SETUP_THEME_DOMAIN),
				 "param_name" => "order",
				 "value" => array('DESC', 'ASC'),
				 "dependency" => Array("element" => "list","value" => array("service")),
				 "description" => __("Load projects in a Ascendent(1,2,3) or Descendent (3,2,1) order", EWF_SETUP_THEME_DOMAIN)
			  )
		   )
		));
	
	}


?>