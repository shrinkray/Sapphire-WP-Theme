<?php
	

	#	Register shortcode for Visual Composer component
	#
	add_shortcode( 'ewf-blog-posts', 'ewf_vc_blog_posts' );
	add_action( 'init', 'ewf_register_vc_blog_posts');
	
	
	function ewf_vc_blog_posts( $atts, $content ) {
		global $post;
		
	   extract( shortcode_atts( array(
			"items" 				=> 2,
			"order" 				=> "DESC",
			"categ" 				=> null,
			"title_more"			=> __('read more', EWF_SETUP_THEME_DOMAIN),
			"title_latest"			=> __('Read our latest posts', EWF_SETUP_THEME_DOMAIN),
			"url"					=> '#'
		), $atts));
		
		$query = array( 'post_type' => 'post',
						'order'=> $order, 
						'orderby' => 'date',  
						'posts_per_page'=>$items); 
		
		if ($categ != null){
			$query['tax_query'] = array(
				array(
					'taxonomy' => 'category',
					'field' => 'slug',
					'terms' => array( $categ )
				));
		}
		
		

		ob_start();
	
		echo '<div class="row">';
		
		$wp_query_blog_posts = new WP_Query($query);
		while ($wp_query_blog_posts->have_posts()) : $wp_query_blog_posts->the_post();
			global $post;
			
			
	
			# Get post featured image
			#
			$ewf_image_id = get_post_thumbnail_id($post->ID);  
			
			$ewf_image_url = wp_get_attachment_image_src($ewf_image_id,'blog-featured-image'); 
			$ewf_image_url = $ewf_image_url[0];
			
			echo '<div class="span6">';
			echo '<div class="blog-post ">';
			
				if ($ewf_image_id){
					echo  '<div class="blog-post-preview">';
						if ($ewf_image_id){
							echo  '<a href="'.get_permalink().'"><img class="blog-post-thumb" src="'.$ewf_image_url.'" alt="" /></a>';
						}
						
						echo  '<div class="blog-post-date">'.get_the_time('d').'<small>'.get_the_time('M').'</small></div>';
						echo  '<div class="blog-post-arrow"></div>';
					echo  '</div> <!-- .blog-post-preview -->';
				}
			
				echo  '<div class="blog-post-summary">';
				
					echo  '<h3 class="blog-post-title"><a href="' . get_permalink() . '">'.get_the_title($post->ID).'</a></h3>' ;
					
					global $more;
					$more = false; 
					echo  '<p>'.do_shortcode(get_the_content('&nbsp;')).'</p>';   
					$more = true;
					
					
					
					echo '<div class="fixed">';
						
						echo '<div class="blog-post-info">';
							echo  '<p>'.__('by', EWF_SETUP_THEME_DOMAIN).' <strong>'.get_the_author().'</strong> ';
						echo '</div>';
						
						echo '<div class="blog-post-readmore">';
							echo '<p class="last"><a href="'.get_permalink().'">'.$title_more.' <i class="fa fa-angle-right"></i></a></p>';
						echo '</div>';
						
					echo '</div><!-- end .fixed -->';
					
					
				echo  '</div> <!-- .blog-post-summary -->';
		

			echo '</div> <!-- .blog-post -->'; 
			echo '</div>';
			
 
		endwhile;

		echo '</div>';
		
		
		echo'
		<div class="row">
			<div class="span12 text-center">

				<br><br>
				<a class="btn btn-white btn-large text-uppercase" href="'.$url.'"><strong>'.$title_latest.'</strong></a>
				<br>
				
			</div><!-- end .span12 -->
		</div><!-- end .row -->';
		
		
		return ob_get_clean();
	 
	}
		
	
	function ewf_vc_blog_posts_categories(){
		global $ewf_portfolioStrip_services;
		
		$categs = array();
		$terms = get_terms ('category'); 
	
		if (is_array($terms)){
			foreach($terms as $key => $categ_item){

				$categs[] = $categ_item->slug;
			}
		}
  		
		return $categs;
	}
		
	
	
	function ewf_register_vc_blog_posts(){
	
		vc_map( array(
		   "name" => __("Blog Posts", EWF_SETUP_THEME_DOMAIN),
		   "base" => "ewf-blog-posts",
		   "class" => "",
		   "icon" => "icon-wpb-ewf-blog-posts",
		   "description" => __("Show 2 blog posts from a specified category", EWF_SETUP_THEME_DOMAIN), 
		   "category" => __('Content', EWF_SETUP_THEME_DOMAIN),
		   "params" => array(
			  // array(
				 // "type" => "textfield",
				 // "holder" => "div",
				 // "class" => "",
				 // "heading" => __("Number of posts", EWF_SETUP_THEME_DOMAIN),
				 // "param_name" => "items",
				 // "value" => 2,
				 // "description" => __("Specify the number of posts to load", EWF_SETUP_THEME_DOMAIN)
			  // ),
			  // array(
				 // "type" => "dropdown",
				 // "holder" => "div",
				 // "class" => "",
				 // "heading" => __("Category", EWF_SETUP_THEME_DOMAIN),
				 // "param_name" => "categ",
				 // "value" => ewf_vc_blog_posts_categories(),
				 // "description" => __("Load posts from a defined category", EWF_SETUP_THEME_DOMAIN),
			  // ),
			  array(
				 "type" => "textfield",
				 "holder" => "div",
				 "class" => "",
				 "heading" => __("Read more title", EWF_SETUP_THEME_DOMAIN),
				 "param_name" => "title_more",
				 "value" => __('read more', EWF_SETUP_THEME_DOMAIN),
				 "description" => __("Read more title from blog article", EWF_SETUP_THEME_DOMAIN)
			  ),
			  array(
				 "type" => "textfield",
				 "holder" => "div",
				 "class" => "",
				 "heading" => __("Button title", EWF_SETUP_THEME_DOMAIN),
				 "param_name" => "title_latest",
				 "value" => __('read our latest posts', EWF_SETUP_THEME_DOMAIN),
				 "description" => __("Read more title from the button", EWF_SETUP_THEME_DOMAIN)
			  ),
			  array(
				 "type" => "textfield",
				 "holder" => "div",
				 "class" => "",
				 "heading" => __("Button link", EWF_SETUP_THEME_DOMAIN),
				 "param_name" => "url",
				 "value" => "#",
				 "description" => __("Read more title from the button", EWF_SETUP_THEME_DOMAIN)
			  )
		   )
		));
	
	}


?>