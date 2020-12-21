<?php

	
	#	Get post classes
	#
	$post_class_array = get_post_class();
	$ewf_post_class = null;
	
	foreach($post_class_array as $key=> $class_item){
		$ewf_post_class.= ' '.$class_item;
	}
	
	
	
	# 	Get post categories
	#
	$ewf_post_tags = get_the_tags();
	
	
	
	# 	Get post categories
	#
	$ewf_post_categories = null;
	
	foreach((get_the_category( $post->ID )) as $category) { 
		if ($ewf_post_categories == null){
			$ewf_post_categories.= '<a href="'.get_category_link( $category->term_id ).'" >'.$category->cat_name.'</a>';
		}else{
			$ewf_post_categories.= ', <a href="'.get_category_link( $category->term_id ).'" >'.$category->cat_name.'</a>';
		}
	}
	
		
	
	# Get post featured image
	#
	$ewf_image_id = get_post_thumbnail_id($post->ID);  
	
	$ewf_image_url = wp_get_attachment_image_src($ewf_image_id,'blog-featured-image'); 
	$ewf_image_url = $ewf_image_url[0];
	
	
	
	# Conditional preloading
	#	
	
	$single_post = is_single();
	
	
	echo  '<div class="blog-post '.$ewf_post_class.'">';
	
		echo  '<h4><a href="' . get_permalink() . '">'.get_the_title($post->ID).'</a></h4>' ;
	
		echo  '<p>'.__('Posted by', EWF_SETUP_THEME_DOMAIN).' <strong>'.get_the_author().'</strong> ';
		if ($ewf_post_categories){
			echo  __('in', EWF_SETUP_THEME_DOMAIN).' '.$ewf_post_categories;
		}
		echo  ' | <a href="'.get_permalink().'#comments">'.get_comments_number().' '.__('comments', EWF_SETUP_THEME_DOMAIN).'</a></p>';
			
			
		if ($ewf_image_id && !$single_post){
			echo  '<div class="blog-post-preview fixed">';
				if ($ewf_image_id){
					echo  '<img src="'.$ewf_image_url.'" alt="" />';
				}
				echo  '<div class="date">'.get_the_time('d.m.y').'</div>';
			echo  '</div> <!-- .blog-post-preview -->';
		}
			

		if ($single_post){
			
			the_content();

			if ($ewf_post_tags){
				echo '<div class="tags">'.the_tags( '<strong>'.__('Tags', EWF_SETUP_THEME_DOMAIN).'</strong>: ', ', ').'</div>';
			}
			
		}else{
		
			global $more;
			$more = false; 
			echo  '<p>'.do_shortcode(get_the_content('&nbsp;')).'</p>';   
			$more = true;
			
			
			echo  '<div class="fixed">';				
					echo  '<p class="text-right">';
							echo '<a class="btn" href="' . get_permalink() . '">'.__('read more', EWF_SETUP_THEME_DOMAIN).'</a>';
					echo '</p>';
			echo  '</div>';
		}
	
	echo  '</div> <!-- .blog-post -->'; 
	
	
	echo '<div class="divider single-line"></div>';
	
	
	if ($single_post){
		comments_template( '', true );
	}
	
?>