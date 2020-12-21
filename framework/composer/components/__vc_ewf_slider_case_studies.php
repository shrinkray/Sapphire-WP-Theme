<?php
	
	
	#	Register shortcode for Visual Composer component
	#
	add_shortcode( 'ewf-slider-casestudy', 'ewf_vc_page_study' );
	add_action( 'init', 'ewf_register_vc_page_study');
	
	
	function ewf_vc_page_study( $atts, $content ) {
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
	 
		$query = array( 'post_type' => EWF_STUDY_SLUG,
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
					'taxonomy' => EWF_STUDY_TAX_CATEGORY,
					'field' => 'slug',
					'terms' => array( $categ )
				));
		}
		
		
		
					
		
		ob_start();
			
			echo '<div id="case-study-slider">';
					 echo '<ul class="slides">';
					 
				$wp_slider_query = new WP_Query($query);
				while ($wp_slider_query->have_posts()) : $wp_slider_query->the_post();
					global $post;
					
						$image_id = get_post_thumbnail_id();  
						$image_url = wp_get_attachment_image_src($image_id,'slider-full');  
						$slide_custom = get_post_custom($post->ID);
						
						$slide_link_title = null;
						$slide_link_url = null;
					
						if (array_key_exists('slide_link_title', $slide_custom) && trim($slide_custom['slide_link_title'][0]) != null){
							$slide_link_title = $slide_custom['slide_link_title'][0];
						}
						
						if (array_key_exists('slide_link_url', $slide_custom) && trim($slide_custom['slide_link_url'][0]) != null){
							$slide_link_url = $slide_custom['slide_link_url'][0];
						}

							
					
						echo '<li';
							if ($image_id){
								echo ' style="background: url('.$image_url[0].') no-repeat center center;"';
							}
						echo '>';
						
							echo '<div class="slidetext">';
								echo '<h3><strong>'.get_the_title().'</strong></h3>';
								echo '<p>'.get_the_excerpt().'</p>';
								
								if ($slide_link_title){
									echo '<a class="btn btn-white" href="'.$slide_link_url.'">'.$slide_link_title.'</a>';
								}
							echo '</div><!-- end .slidetext -->';

						echo '</li>'; 
					
				endwhile;	
				
				echo '</ul>';
			echo '</div>';

			wp_reset_query();
			
		return ob_get_clean();
	 
	}
		
	
	function ewf_vc_page_study_categories(){
		$categories = array();
		$terms = get_terms (EWF_STUDY_TAX_CATEGORY); 
	
		if (is_array($terms)){
			foreach($terms as $key => $category){

				$categories[] = $category->slug;
			}
		}
  		
		return $categories;
	}
		
	
	
	function ewf_register_vc_page_study(){
	
		vc_map( array(
		   "name" => __("Case Study Slider", EWF_SETUP_THEME_DOMAIN),
		   "base" => "ewf-slider-casestudy",
		   "class" => "",
		   "icon" => "icon-wpb-ewf-slider-case-studies",
		   "description" => __("Create a slider from Case Studies post type", EWF_SETUP_THEME_DOMAIN), 
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
				 "value" => ewf_vc_page_study_categories(),
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