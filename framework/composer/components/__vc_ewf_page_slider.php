<?php
	
	
	#	Register shortcode for Visual Composer component
	#
	add_shortcode( 'ewf-page-slider', 'ewf_vc_page_slider' );
	add_action( 'init', 'ewf_register_vc_page_slider');
	
	
	function ewf_vc_page_slider( $atts, $content ) {
		global $post;
		
	   extract( shortcode_atts( array(
			"items" 				=> 3,
			"id" 					=> null,
			"exclude" 				=> null,
			"order" 				=> "DESC",
			"categ" 				=> null
		), $atts));
		
		if ($categ == 'No Category'){
			$categ = null;
		}
	 
		$query = array( 'post_type' => EWF_SLIDE_SLUG,
						'order'=> $order, 
						'orderby' => 'date',  
						'posts_per_page'=>$items); 
						
	
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
		
		if ($categ != null){
			$query['tax_query'] = array(
				array(
					'taxonomy' => EWF_SLIDE_TAX_CATEGORY,
					'field' => 'slug',
					'terms' => array( $categ )
				));
		}
		
		
		
					
		
		ob_start();
			
			echo '<div id="main-slider">';
					 echo '<ul class="slides">';
					 
				$wp_slider_query = new WP_Query($query);
				while ($wp_slider_query->have_posts()) : $wp_slider_query->the_post();
					global $post;
					
						$image_id = get_post_thumbnail_id();  
						$image_url = wp_get_attachment_image_src($image_id,'slider-full');  
						$slide_custom = get_post_custom($post->ID);
						
						echo '<li';
							if ($image_id){
								echo ' style="background: url('.$image_url[0].') no-repeat center center;"';
							}
						echo '>';
							
							if (array_key_exists('slide_description', $slide_custom) && trim($slide_custom['slide_description'][0]) != null){
								$slide_description = $slide_custom['slide_description'][0];
							}else{
								$slide_description = null;
							}
							
							if ($slide_description != null ){
								echo '<div class="slidetext">';
									
									if ($slide_description != null ){
										echo html_entity_decode($slide_description);
									}
								echo '</div>';								
							}

						echo '</li>'; 
					
				endwhile;	
				
				echo '</ul>';
			echo '</div>';

			wp_reset_query();
			
		return ob_get_clean();
	 
	}
		
	
	function ewf_vc_page_slider_categories(){
		$categories = array();
		$terms = get_terms (EWF_SLIDE_TAX_CATEGORY); 
	
		if (is_array($terms)){
			foreach($terms as $key => $category){

				$categories[] = $category->slug;
			}
		}
  		
		return $categories;
	}
		
	
	
	function ewf_register_vc_page_slider(){
	
		vc_map( array(
		   "name" => __("Slider", EWF_SETUP_THEME_DOMAIN),
		   "base" => "ewf-page-slider",
		   "class" => "",
		   "icon" => "icon-wpb-ewf-slider",
		   "description" => __("Full width slider from Slider post type", EWF_SETUP_THEME_DOMAIN) ,  
		   "category" => __('Content', EWF_SETUP_THEME_DOMAIN),
		   "params" => array(
			  array(
				 "type" => "textfield",
				 "holder" => "div",
				 "class" => "",
				 "heading" => __("Slides", EWF_SETUP_THEME_DOMAIN),
				 "param_name" => "items",
				 "value" => 3,
				 "description" => __("The number of slides to load", EWF_SETUP_THEME_DOMAIN)
			  ),
			  array(
				 "type" => "dropdown",
				 "holder" => "div",
				 "class" => "",
				 "heading" => __("Category", EWF_SETUP_THEME_DOMAIN),
				 "param_name" => "categ",
				 "value" => ewf_vc_page_slider_categories(),
				 "description" => __("Specify slides from a defined category", EWF_SETUP_THEME_DOMAIN)
			  ),
			  array(
				 "type" => "dropdown",
				 "holder" => "div",
				 "class" => "",
				 "heading" => __("Slides order", EWF_SETUP_THEME_DOMAIN),
				 "param_name" => "order",
				 "value" => array('DESC', 'ASC'),
				 "description" => __("Load projects in a Ascendent(1,2,3) or Descendent (3,2,1) order", EWF_SETUP_THEME_DOMAIN)
			  )
		   )
		));
	
	}


?>