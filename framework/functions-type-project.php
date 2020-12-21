<?php

	#	Change default slugs
	#
	define ('EWF_PROJECTS_SLUG'					, 'project'								);
	define ('EWF_PROJECTS_TAX_SERVICES'			, 'service'								);

	
	#	Register taxonomy and post type
	#
	add_action('init'							, 'ewf_register_type_project'			);
	add_action('init'							, 'ewf_register_project_taxonomies' 	);  
	
	
	
	#	Register shortcodes
	#
	add_shortcode("projects-overview"			, "ewf_projects_sc_overview"			); 
	add_shortcode("projects-slider"				, "ewf_projects_sc_slider"				);
	add_shortcode("projects-related"			, "ewf_projects_sc_related"				);
	add_shortcode("projects-nav"				, "ewf_projects_sc_nav"					);
	add_shortcode("services-offered"			, "ewf_projects_sc_services"			); 
	

	
	
	#	Register image size for project
	#
	add_image_size( 'project-preview-medium'	, 440, 450, true						);
	add_image_size( 'project-preview-large'		, 700, 300, true						);

	


	

	function ewf_projects_sc_viewlive($atts, $content){
		extract(shortcode_atts(array(
			"title" => "#",
			"url" => "#"
		), $atts)); 
		
		return '<a class="view-project" href="'.$url.'">'.$title.'</a>';
	}
	
	


	function ewf_projects_get_filters($activeTermSlug, $atts){
		global $post;

		extract($atts); 
		$terms = get_terms (EWF_PROJECTS_TAX_SERVICES);
		
		$src = null;
		
		if (is_array($terms)){
			$src.= '<ul id="portfolio-filter">';
			
				if ($activeTermSlug != null){
					$src.= '<li class="first"><a href="'.$filteroverviewurl.'">'.$filteroverviewtitle.'</a>';			
					
					foreach($terms as $key => $service){
						if ($activeTermSlug == $service->slug){
							$src.= '<li class="current"><a href="'.get_term_link($service->slug, EWF_PROJECTS_TAX_SERVICES).'">'.$service->name.'</a></li>';
						}else{
							$src.= '<li><a href="'.get_term_link($service->slug, EWF_PROJECTS_TAX_SERVICES).'">'.$service->name.'</a></li>';
						}
					}
				}else{
					$src.= '<li class="first current"><a href="'.$filteroverviewurl.'">'.$filteroverviewtitle.'</a>';			
					foreach($terms as $key => $service){
						$src.= '<li><a href="'.get_term_link($service->slug, EWF_PROJECTS_TAX_SERVICES).'">'.$service->name.'</a></li>';
					}
				}
			
			$src.= '</ul>'; 
		}
		
		return $src;
	}

	
	function ewf_projects_sc_services($atts, $content){
		global $paged, $post;
		
		$src = null;
		
		# Services
		$terms = get_the_terms ($post->ID, EWF_PROJECTS_TAX_SERVICES);
		if (is_array($terms)){
			$src.= '<ul class="side-nav">';
				foreach($terms as $key => $service){
					$src.= '<li><a href="'.get_term_link($service->slug, EWF_PROJECTS_TAX_SERVICES).'">'.$service->name.'</a></li>';
				}
			$src.= '</ul>';
		}
		
		return $src;
	}
	
	
	function ewf_projects_sc_slider($atts, $content){
		global $paged, $post;
		 
		$src = null;
		
		extract(shortcode_atts(array(
			"featuredimage" => "true"
		), $atts)); 
		
		$image_id = get_post_thumbnail_id();  
		$arrImages = get_children('post_type=attachment&post_mime_type=image&post_parent='. $post->ID.'&orderby=menu_order&order=ASC' ); 
		
		if (count($arrImages) > 0){
			$src .= '<div id="portfolio-item-slider">';
					if($arrImages) {					
						$src .= '<div class="flexslider"><ul class="slides">';
					
						foreach($arrImages as $oImage) {
							if ($featuredimage == 'false'){
								if ($oImage->ID != $image_id){
									$cr_image_large_preview = wp_get_attachment_image_src( $oImage->ID, 'project-preview-large');						
									$src .= '<li><img alt="" src="'.$cr_image_large_preview[0].'" style="opacity: 1;"></li>'; 
								}
							}else{
								$cr_image_large_preview = wp_get_attachment_image_src( $oImage->ID, 'project-preview-large');						
								$src .= '<li><img alt="" src="'.$cr_image_large_preview[0].'" style="opacity: 1;"></li>';  
							}
						}  
						
						$src .= '</ul></div>';
					}
			$src .= '</div> <div class="hr"></div>';
	
		}else{
			$src .= ewf_message(__('Please add a featured image and/or other images in the page gallery to show the slider!',EWF_SETUP_THEME_DOMAIN));
		}
		
		return $src;
	}

	
	
	function ewf_hlp_queryBuilder($options, $defaults = null){
		global $tax_query_projects, $post;
		
		if (!$defaults){
			$defaults = array(
				"items"					=> 0,
				"id" 					=> null,
				"exclude" 				=> null,
				"exclude" 				=> null,
				"order" 				=> "DESC",
				"unlimited" 			=> false,
				"service" 				=> null
			);
		} 
		

		// echo '<pre> Query Helper Settings Input <br/>';
			// print_r($options);
		// echo '</pre>';

		$options = shortcode_atts($defaults, $options);
		extract($options);
		
		// if (!$page){
			// $paged = get_query_var('paged') ? get_query_var('paged') : 1;
		// }
		
		
		if ($unlimited){
			$items = '-1'; 
		}
		

		
		$include_posts = array();
		$exclude_items = array();

		$order = strtoupper($order);
		$query = array( 'post_type' => EWF_PROJECTS_SLUG,
						'order'=> $order, 
						'orderby' => 'date',  
						'posts_per_page'=>$items, 
						// 'paged' => $paged
						); 
		
		
		
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
					'terms' => $service
				));
		}
		
		
		
		return $query;
	
	}
	
	
	function ewf_projects_sc_overview($atts, $content){ 
		global $tax_query_projects, $post;
		
		$page_portfolio_id = ewf_get_page_relatedID();
		
		$page_portfolio_sidebar = "false";
		if (ewf_get_sidebar_layout("layout-full", $page_portfolio_id) != "layout-full"){
			$page_portfolio_sidebar = "true";
		}

		$translation = array(
			'details-link' 	=> get_option(EWF_SETUP_THNAME."_portfolio_label_projectdetails", __('Project Details', EWF_SETUP_THEME_DOMAIN) ),
			'details-info' 	=> get_option( EWF_SETUP_THNAME."_portfolio_label_details", __('Click on project details for more info', EWF_SETUP_THEME_DOMAIN) ),
			'goto'			=> __('Go to project page'		, EWF_SETUP_THEME_DOMAIN),
			'larger'		=> __('View larger version'		, EWF_SETUP_THEME_DOMAIN),
			'all-work' 		=> get_option(EWF_SETUP_THNAME."_portfolio_filter_overview_title", __('All Work', EWF_SETUP_THEME_DOMAIN) ),
			'large' 		=> __('View large'				, EWF_SETUP_THEME_DOMAIN),
			'project' 		=> __('&#8212; View project'	, EWF_SETUP_THEME_DOMAIN),
			'zoom' 			=> __('Zoom'					, EWF_SETUP_THEME_DOMAIN),
			'more' 			=> __('Read More'				, EWF_SETUP_THEME_DOMAIN)
		);
		
		$options = shortcode_atts(array(
			"items" 				=> 0,
			"id" 					=> null,
			"exclude" 				=> null,
			"activeTerm" 			=> null,
			"nav" 					=> "true",

			"filter" 				=> "false",
			"filteroverviewurl" 	=> get_permalink($page_portfolio_id),
			"filteroverviewtitle" 	=> $translation['all-work'],
			
			"style" 				=> strtolower(get_option(EWF_SETUP_THNAME."_portfolio_layout","Multiple")) ,								# single/multiple
			
			"order" 				=> "DESC",
			"hassidebar" 			=> $page_portfolio_sidebar,
			"itemsperrow" 			=>  get_option(EWF_SETUP_THNAME."_portfolio_items_per_row","4") ,
			"service" 				=> null,
		), $atts);
		extract($options);
		
		
		if ($itemsperrow > 4){
			$itemsperrow = 4;
		}
		
		if ($items == 0){ 	
			$items = get_option(EWF_SETUP_THNAME."_portfolio_items_per_page");
			}
		
		if ($hassidebar == 'true' && $itemsperrow == '4'){ 
			$itemsperrow = intval($itemsperrow) -1;
		}
		
		
		$src = null;
		
		$paged = get_query_var('paged') ? get_query_var('paged') : 1;
		
		$include_posts = array();
		$exclude_items = array();
		
		$order = strtoupper($order);
		$nav = strtolower($nav);
		$filter = strtolower($filter);
		
		$count_rows = 1;
		$count_items = 0;
		$count_columns = 0;
		$count_items_column = 0;
		
		
		if (!isset($tax_query_projects)){ 
				$query = array( 'post_type' => EWF_PROJECTS_SLUG,
								'order'=> $order, 
								'orderby' => 'date',  
								'posts_per_page'=>$items, 
								'paged' => $paged); 
								
			
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
				
				$wp_query_project = new WP_Query($query);
		}else{
			$wp_query_project = $tax_query_projects; 
		} 
		

		if ($style == 'multiple'){
			$nr_spans = $itemsperrow * 3;
			$src.= '<div class="span'.$nr_spans.' row-gen"><div>';
		}elseif(($hassidebar == 'true' || $hassidebar == 'false') && $style == 'single'){
			$src.= '<div class="span9 row-gen"><div class="row">';
		}
			
		while ($wp_query_project->have_posts()) : $wp_query_project->the_post();
			global $post;
			
			$count_items++; 
			$count_columns++;
			$count_items_column++;
			
			
			
			if ($style == "single"){
					
					if ($count_items>1){
						$src .= '<div class="hr"></div>';
					}
					
					$src .= '<div class="row">';
						$src .= '<div class="portfolio-item">';
						
							#	Get the featured image
							#
							$src .= '<div class="span6">';
							$image_id = get_post_thumbnail_id();  
							if ($image_id) {
								$src .= '<div class="portfolio-item-thumb">';
									$image_large_preview = wp_get_attachment_image_src($image_id,'project-preview-large');  
									$image_extra_large_preview = wp_get_attachment_image_src($image_id,'large');   
									
									$src .= '<img src="'.$image_large_preview[0].'" alt="" />';  
									$src .= '<a href="'.$image_extra_large_preview[0].'" class="portfolio-item-overlay" rel="imagebox[portfolio]">'.$translation['zoom'].'</a>';
								$src .= '</div>';
							}
							$src .= '</div>';
								
							$src .= '<div class="span3">';
								$src .= '<h3><a href="'.get_permalink().'">'.get_the_title().'</a></h3>';
								$src .= '<p>'.get_the_excerpt().'</p>';
								$src .= '<a href="'.get_permalink().'">'.$translation['more'].'</a>';
							$src .= '</div>';
						 
						$src .= '</div>';
					$src.= '</div>';
					
			}else{
			
					if ($count_items_column == 1) { 
						$src .= '<div class="row items-row">';  
						}

					$src .= '<div class="span3">';
						$src .= '<div class="portfolio-item">';
						
							#	Get the featured image
							#
							$image_id = get_post_thumbnail_id();  
							if ($image_id) {
								$src .= '<div class="portfolio-item-thumb">';
									$image_large_preview = wp_get_attachment_image_src($image_id,'project-preview-medium');  
									$image_extra_large_preview = wp_get_attachment_image_src($image_id,'large');   
									
									$src .= '<img src="'.$image_large_preview[0].'" alt="" />';  
									$src .= '<a href="'.$image_extra_large_preview[0].'" class="portfolio-item-overlay" rel="imagebox[portfolio]">'.$translation['zoom'].'</a>';
								$src .= '</div>';
							}
								
							$src .= '<h3><a href="'.get_permalink().'">'.get_the_title().'</a></h3>';
							$src .= '<p>'.get_the_excerpt().'</p>';
							$src .= '<p><a href="'.get_permalink().'">'.$translation['more'].'</a></p>';
						 
						$src .= '</div>';
					$src.= '</div>';

					if ($count_items_column == $itemsperrow || $wp_query_project->post_count == $count_items) { 
						$count_items_column = 0; 
						$count_rows++;
						
						$src .= '</div>';
					}
			
			}
			

		endwhile;
		
		$src.= '</div>';
		
	
			#	Load navigation if there are more than items per page
			#
			if (($itemsperrow > 1) && ($nav == 'true') && $wp_query_project->max_num_pages > 1){
				$src .= '<div class="row nav-row">';
					$src .= ewf_projects_pagination(10, $wp_query_project);
				$src .= '</div>'; 
			}
			
		$src .= '</div>';

		wp_reset_query();
	
		return $src;
	}
	
	function ewf_projects_pagination($range = 10, $query, $position = ""){
		$src_nav = null; 

		$class_current = 'current';
		$current_page = $query->query_vars['paged'];
		$max_page = 0;
		$pages_array = null;
		$nav_start = null;

	  // How much pages do we have?
	  if ( !$max_page ) {
		$max_page = $query->max_num_pages;
	  }
	
	 if ($position != null ){
		$nav_start .= '<ul class="pagination fixed '.$position.'">';
	}else{
		$nav_start .= '<ul class="pagination fixed">';
	}
	
	  // We need the pagination only if there are more than 1 page
	  if($max_page > 1){
	  
	  
		if(!$current_page){
		  $current_page = 1;
		}
			
		// We need the sliding effect only if there are more pages than is the sliding range
		if($max_page > $range){
		  // When closer to the beginning
		  if($current_page < $range){
			for($i = 1; $i <= ($range + 1); $i++){
			  
			  $src_nav.= "<li ";
			  if($i==$current_page) $src_nav.= "class='".$class_current."'";
			  
			  $pages_array[$i] = get_pagenum_link($i);
			  
			  $src_nav.= "><a href='" . get_pagenum_link($i) ."'";
			  $src_nav.= ">$i</a></li>";
			}
		  }
		  // When closer to the end
		  elseif($current_page >= ($max_page - ceil(($range/2)))){
			for($i = $max_page - $range; $i <= $max_page; $i++){
			  $src_nav.= "<li ";
			  
			  if($i==$current_page) $src_nav.= "class='".$class_current."'";
			  
			  $pages_array[$i] = get_pagenum_link($i);
			  $src_nav.= "><a href='" . get_pagenum_link($i) ."'";
			  $src_nav.= ">$i</a></li>";
			}
		  }
		  // Somewhere in the middle
		  elseif($current_page >= $range && $current_page < ($max_page - ceil(($range/2)))){
			for($i = ($current_page - ceil($range/2)); $i <= ($current_page + ceil(($range/2))); $i++){
			  $src_nav.= "<li ";
			  
			  if($i==$current_page) $src_nav.= "class='".$class_current."'";
			  $pages_array[$i] = get_pagenum_link($i);
			  
			  $src_nav.= "><a href='" . get_pagenum_link($i) ."'";
			  $src_nav.= ">$i</a></li>";
			}
		  }
		}
		// Less pages than the range, no sliding effect needed
		else{
		  for($i = 1; $i <= $max_page; $i++){
			$src_nav.= "<li ";
			
			if($i==$current_page) $src_nav.= "class='".$class_current."'";
			$pages_array[$i] = get_pagenum_link($i);
			
			$src_nav.= "><a href='" . get_pagenum_link($i) ."'";
			$src_nav.= ">$i</a></li>";
		  } 
		}
	  }
	  
	  
	  
	  
		if ($current_page > 1 ){
			$src_nav = $nav_start.'<li><a href="'.$pages_array[$current_page-1].'">'.__('&laquo; Previous', EWF_SETUP_THEME_DOMAIN).'</a></li>'.$src_nav;
		}
		
		if ($current_page < $max_page ){
			$src_nav = $nav_start.$src_nav.'<li class="last"><a href="'.$pages_array[$current_page+1].'">'.__('Next &raquo;', EWF_SETUP_THEME_DOMAIN).'</a></li>';
		}
	  
	  $src_nav .= '</ul>';

	  return '<div class="hr"></div>'.$src_nav;
	}
	
	function ewf_projects_pagination_advanced($range = 10, $query, $position = ""){
		$src_nav = null; 

		$class_current = 'current';
		$current_page = $query->query_vars['paged'];
		$max_page = 0;
		$pages_array = null;

	  // How much pages do we have?
	  if ( !$max_page ) {
		$max_page = $query->max_num_pages;
	  }
	
	 if ($position != null ){
		$nav_start .= '<ul class="pagination fixed '.$position.'">';
	}else{
		$nav_start .= '<ul class="pagination fixed">';
	}
	
	  // We need the pagination only if there are more than 1 page
	  if($max_page > 1){
	  
	  
		if(!$current_page){
		  $current_page = 1;
		}
			
		// We need the sliding effect only if there are more pages than is the sliding range
		if($max_page > $range){
		  // When closer to the beginning
		  if($current_page < $range){
			for($i = 1; $i <= ($range + 1); $i++){
			  
			  $src_nav.= "<li ";
			  if($i==$current_page) $src_nav.= "class='".$class_current."'";
			  
			  $pages_array[$i] = get_pagenum_link($i);
			  
			  //$src_nav.= "><a href='" . get_pagenum_link($i) ."'";
			  //$src_nav.= ">$i</a></li>";
			}
		  }
		  // When closer to the end
		  elseif($current_page >= ($max_page - ceil(($range/2)))){
			for($i = $max_page - $range; $i <= $max_page; $i++){
			  $src_nav.= "<li ";
			  
			  if($i==$current_page) $src_nav.= "class='".$class_current."'";
			  
			  $pages_array[$i] = get_pagenum_link($i);
			  //$src_nav.= "><a href='" . get_pagenum_link($i) ."'";
			  //$src_nav.= ">$i</a></li>";
			}
		  }
		  // Somewhere in the middle
		  elseif($current_page >= $range && $current_page < ($max_page - ceil(($range/2)))){
			for($i = ($current_page - ceil($range/2)); $i <= ($current_page + ceil(($range/2))); $i++){
			  $src_nav.= "<li ";
			  
			  if($i==$current_page) $src_nav.= "class='".$class_current."'";
			  $pages_array[$i] = get_pagenum_link($i);
			  
			  //$src_nav.= "><a href='" . get_pagenum_link($i) ."'";
			 // $src_nav.= ">$i</a></li>";
			}
		  }
		}
		// Less pages than the range, no sliding effect needed
		else{
		  for($i = 1; $i <= $max_page; $i++){
			$src_nav.= "<li ";
			
			if($i==$current_page) $src_nav.= "class='".$class_current."'";
			$pages_array[$i] = get_pagenum_link($i);
			
			//$src_nav.= "><a href='" . get_pagenum_link($i) ."'";
			//$src_nav.= ">$i</a></li>";
		  } 
		}
	  }
	  
		if ($current_page > 1 ){
			$src_nav = $nav_start.'<li class="first"><a href="'.$pages_array[$current_page-1].'">'.__('&#8249; Previous', EWF_SETUP_THEME_DOMAIN).'</a></li>'.$src_nav;
		}else{
			$src_nav = $nav_start.'<li class="first"><span>'.__('&#8249; Previous', EWF_SETUP_THEME_DOMAIN).'</span></li>'.$src_nav;
		}
		
		$src_nav .= '<li>page '.$current_page.' / '.count($pages_array).'</li>';
		
		if ($current_page < $max_page ){
			$src_nav = $nav_start.$src_nav.'<li class="last"><a href="'.$pages_array[$current_page+1].'">'.__('Next &#8250;', EWF_SETUP_THEME_DOMAIN).'</a></li>';
		}else{
			$src_nav = $nav_start.$src_nav.'<li class="last"><span>'.__('Next &#8250;', EWF_SETUP_THEME_DOMAIN).'</span></li>';
		}
	  
	  $src_nav .= '</ul>';

	  return $src_nav;
	}
	
	

	
	
	
	function ewf_projects_sc_nav($atts, $content){
		extract(shortcode_atts(array(
			"portfoliourl" 	=> ewf_get_page_relatedID(),
			"prevtitle" 	=> __('&#8249; Previous', EWF_SETUP_THEME_DOMAIN),
			"nexttitle" 	=> __('Next &#8250;', EWF_SETUP_THEME_DOMAIN)
		), $atts));
		
		$nav_data = ewf_projects_get_nav();
		$src =	'<ul class="pagination fixed">
					<li class="first"><a href="'.$nav_data['project_next'].'">'.$prevtitle.'</a></li>
					<li><a href="'.get_permalink($portfoliourl).'"><img height="16" alt="" src="'.get_template_directory_uri().'/_layout/images/portfolio-icon.png"></a></li>
					<li class="last"><a href="'.$nav_data['project_previews'].'">'.$nexttitle.'</a></li> 
				</ul>';
				
		return $src;
	}
	
	
	function ewf_projects_get_nav(){
		global $post;
		
		$post_id =  $post-> ID;
		$data = array();
		$wp_query_project_custom = new WP_Query(array( 'post_type' => EWF_PROJECTS_SLUG,'order'=> 'DESC', 'orderby' => 'date', 'posts_per_page' => -1));
		
		$count_item = 0;
		
		while ($wp_query_project_custom->have_posts()) : $wp_query_project_custom->the_post();
			global $post;
			
			$data['list'][] = get_permalink(); 
			$count_item++;
			
			if ($post->ID == $post_id){
				$index = count($data['list']) -1;
				
				$data['project_curent'] = $index;
				$data['project_previews'] = $index -1;
				$data['project_next'] = $index + 1;
			}
			
		endwhile; 
		
		if ($data['project_previews'] >= 0){
			$data['project_previews'] = "".$data['list'][$data['project_previews']];
		}else{
			$data['project_previews'] = "".$data['list'][count($data['list'])-1];
		}

		$data['project_curent'] = $data['list'][$data['project_curent']];
		
		if ($data['project_next'] < count($data['list'])){
			$data['project_next'] = "".$data['list'][$data['project_next']];
		}else{
			$data['project_next'] = "".$data['list'][0];
		}
		
		wp_reset_query();
		
		return $data;
	}
	
		
	function ewf_projects_sc_related ($atts, $content){	
		global $post;
		
		$options = shortcode_atts(array(
			"items" => 2,
			"exclude" => $post->ID,
			"id" => null,
			"exclude" => null,
			"nav" => "false",
			"navposition" => "",
			"order" => "DESC",
			"hassidebar" => "false",
			"itemsperrow" => "2",
			"service" => null,
		), $atts);
	
		return ewf_projects_sc_overview($options, null);
	}
	

	function ewf_register_type_project(){
		register_post_type( EWF_PROJECTS_SLUG , 
		
			array(
			'labels' => array(
				'name' 					=> __( 'Projects'					,EWF_SETUP_THEME_DOMAIN ),
				'singular_name' 		=> __( 'Project'					,EWF_SETUP_THEME_DOMAIN ),
				'add_new' 				=> __( 'Add New'					,EWF_SETUP_THEME_DOMAIN ),
				'add_new_item' 			=> __( 'Add New Project'			,EWF_SETUP_THEME_DOMAIN ),
				'edit' 					=> __( 'Edit'						,EWF_SETUP_THEME_DOMAIN ),
				'edit_item' 			=> __( 'Edit Project'				,EWF_SETUP_THEME_DOMAIN ),
				'new_item' 				=> __( 'New Project'				,EWF_SETUP_THEME_DOMAIN ),
				'view' 					=> __( 'View Project'				,EWF_SETUP_THEME_DOMAIN ),
				'view_item' 			=> __( 'View Project'				,EWF_SETUP_THEME_DOMAIN ),
				'search_items' 			=> __( 'Search Projects'			,EWF_SETUP_THEME_DOMAIN ),
				'not_found' 			=> __( 'No projects found'			,EWF_SETUP_THEME_DOMAIN ),
				'not_found_in_trash' 	=> __( 'No projects found in Trash'	,EWF_SETUP_THEME_DOMAIN ),
				'parent' 				=> __( 'Parent project'				,EWF_SETUP_THEME_DOMAIN ),
				),
			'public' 		=> true,
			'rewrite' 		=> true, 
			'menu_position' => 91,
			'slug'			=> 'project',
			'show_ui' 		=> true,
			'show_in_menu'  => true,
			'supports' 		=> array('title', 'editor', 'thumbnail', 'excerpt')
			));
	} 
	
	
	function ewf_register_project_taxonomies(){
		register_taxonomy( EWF_PROJECTS_TAX_SERVICES, EWF_PROJECTS_SLUG, 
			array( 'hierarchical' => true, 
						   'slug' => 'service',
						  'label' => __('Services', EWF_SETUP_THEME_DOMAIN), 
					  'query_var' => true,
						'rewrite' => true ));  
	}

?>