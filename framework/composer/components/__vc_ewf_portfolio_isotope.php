<?php


	add_action ( "wp_ajax_ewf_portfolio_isotope_loadmore"				, "ewf_portfolio_isotope_loadMore" );
	add_action ( "wp_ajax_nopriv_ewf_portfolio_isotope_loadmore"		, "ewf_portfolio_isotope_loadMore" );
	
	add_shortcode ( "portfolio-isotope" 								, "ewf_projects_isotope" );
	
	function ewf_portfolio_isotope_loadMore(){
		$filter = stripslashes($_POST['filter']);
		 
		$options = array( 
			'items' => -1,  
			'service' => null,
			'start' => 0,
			'unlimited' => true,
			'loaditems' => intval($_POST['items']),
			'exclude' => $_POST['exclude']
		);
		
		if ($filter != 'all'){
			$options['service'] = array($filter);
		}

		$result = ewf_projects_isotope( $options, null, false, false, true );
		
		wp_send_json_success(array('filter' => $filter, 'source' => $result['source'], 'builder'=>$options, 'query'=>$result['query'] ));
		exit;
	}

	function ewf_projects_isotope($atts, $content, $filters = true, $wrapper = true, $return_array = false){
		global $post;
		
		$options = shortcode_atts(array( 
			"unlimited" => true, 
			"items" => 6, 
			"start" => 0, 
			"service" => null, 
			"exclude" => null, 
			"loaditems" => 6
		), $atts ); 
		extract($options); 
		
		
		$src = null;
	
	
	
	#	Build WP Query
	#		
		$query_projects = ewf_hlp_queryBuilder($options);
		$wp_query_project = new WP_Query($query_projects);

		

	#	Load items using WP Query
	#			
		
		$count_items = 0; 
		while ($wp_query_project->have_posts()) : $wp_query_project->the_post();
			$image_large_preview = null;
			$image_extra_large_preview = null;

			$count_items++;
			
			
			#	Get project terms
			#				
			$project_terms = wp_get_post_terms ($post->ID, EWF_PROJECTS_TAX_SERVICES);
			$project_terms_src = null;
			foreach($project_terms as $key => $service){
				$project_terms_src .= $service->slug.' ';
			}

			
			
			$src .= '<li data-id="'.$post->ID.'" class="item '.$project_terms_src.'"><div class="portfolio-item"><div class="portfolio-item-preview">';
			
			
			#	Get the featured image
			#
			$image_id = get_post_thumbnail_id();  
			if ($image_id) {
				$image_large_preview = wp_get_attachment_image_src($image_id,'project-preview-medium');  
				$image_extra_large_preview = wp_get_attachment_image_src($image_id,'large');   
				
				$src .= '<a href="#"><img src="'.$image_large_preview[0].'" width="313" height="320" alt="" /></a>';  
			}
			
			$src .= '<div class="portfolio-item-overlay">';
			
				$src .= '<div class="portfolio-item-description">
							<h4>'.get_the_title().'<span></span></h4>
							<p>'.get_the_excerpt().'</p>
						</div>';
				
				$src .= '<div class="portfolio-item-overlay-actions">
							<a href="'.$image_extra_large_preview[0].'" class="portfolio-item-zoom magnificPopup-gallery"><i class="fa fa-search-plus"></i></a>
							<a href="'.get_permalink().'" class="portfolio-item-link"><i class="fa fa-angle-right"></i></a>
						</div>';
				
				$src .= '</div>';
			$src .= '</div></div></li>';
			
			
			if ($return_array){
				if ($count_items == $loaditems){
					break;
				}
			}else{
				if ($count_items == $items){ 
					break;
				}	
			}

			
		endwhile;	
		wp_reset_query();
		
		
		
		
		
		
		
		
		
	#	Display portfolio
	#
		if ($wrapper){
			$src = '<ul class="portfolio-items fixed">'.$src.'</ul>';
			$src .= '<a href="#" class="portfolio-load-more" data-load-items="'.$loaditems.'" ><i class="fa fa-repeat"></i> Load more</a>';
		}
		
		

		
	#	Attach filters 
	#
		
		if ($filters == true){
			$filter_terms 	= get_terms (EWF_PROJECTS_TAX_SERVICES);
			$filter_src 	= null;
			$filter_items 	= array('all'=>0);
			
			
			if (is_array($filter_terms)){
				$filter_src.= '<ul>';			
					$filter_src.= '<li><a class="active" href="#" data-items="'.$wp_query_project->found_posts.'" data-filter="*" data-term="all" >All</a></li>';			
					
					foreach($filter_terms as $key => $service){
						$filter_src.= '<li><a data-term="'.$service->slug.'" data-items="'.intval($service->count).'" data-filter=".'.$service->slug.'" href="#">'.$service->name.'</a></li>';
					}
				$filter_src.= '</ul>';		
				
				$src = '<div class="portfolio-filter">'.$filter_src.'</div><!-- end .portfolio-filter -->'.$src;
			}

		}
		
		
		if ($return_array){
			return array(
				'source' => $src, 
			);
		}
	
		return $src;
	}

	
	
	vc_map( array(
	   "name" => __("Portfolio Isotope", EWF_SETUP_THEME_DOMAIN),
	   "base" => "portfolio-isotope",
	   "class" => "",
	   "icon" => "icon-wpb-ewf-portfolio-isotope",
	   "description" => __("Add grid of portfolio items", EWF_SETUP_THEME_DOMAIN), 
	   "category" => __('Portfolio', EWF_SETUP_THEME_DOMAIN),
	   "params" => array(
		  array(
			 "type" => "textfield", 
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Load items", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "items",
			 "value" => 6,
			 "description" => __("The number of items visible initially.", EWF_SETUP_THEME_DOMAIN)
		  ),
		  
		  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Load More Items", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "loaditems",
			 "value" => 6,
			 "description" => __("Number of items to add when you press the 'Load More' button.", EWF_SETUP_THEME_DOMAIN)
		  ),
	   )
	));


?>