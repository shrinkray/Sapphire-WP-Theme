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
	
		if ($ewf_image_id && !$single_post){
			echo  '<div class="blog-post-preview">';
				if ($ewf_image_id){
					echo  '<a href="'.get_permalink().'"><img class="blog-post-thumb" src="'.$ewf_image_url.'" alt="" /></a>';
				}
				
				echo  '<div class="blog-post-date">'.get_the_time('d').'<small>'.get_the_time('M').'</small></div>';
				echo  '<div class="blog-post-arrow"></div>';
			echo  '</div> <!-- .blog-post-preview -->';
		}
			
		
		if (!$single_post){
			echo  '<div class="blog-post-summary">';
		}
		
			echo  '<h3 class="blog-post-title"><a href="' . get_permalink() . '">'.get_the_title($post->ID).'</a></h3>' ;
			
			if ($single_post){
				echo  '<p>'.__('by', EWF_SETUP_THEME_DOMAIN).' <strong>'.get_the_author().'</strong> ';
				if ($ewf_post_categories){
					echo  __('in', EWF_SETUP_THEME_DOMAIN).' '.$ewf_post_categories;
				}
				echo  ' | <a href="'.get_permalink().'#comments">'.get_comments_number().' '.__('comments', EWF_SETUP_THEME_DOMAIN).'</a></p>';
			
				
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
						echo  '<div class="blog-post-info">';
							echo  '<p class="last">'.__('by', EWF_SETUP_THEME_DOMAIN).' <strong>'.get_the_author().'</strong> ';
							
							if ($ewf_post_categories){
								echo  __('in', EWF_SETUP_THEME_DOMAIN).' '.$ewf_post_categories;
							}
							
							echo  ' | <a href="'.get_permalink().'#comments">'.get_comments_number().' '.__('comments', EWF_SETUP_THEME_DOMAIN).'</a></p>';
						echo  '</div> <!-- .blog-post-info -->';
					
						echo  '<div class="blog-post-readmore">';
								echo '<p class="last"><a href="'.get_permalink().'">read more <i class="fa fa-angle-right"></i></a></p>';
						echo '</div>';
					
				echo  '</div> <!-- .fixed -->';
			}
			
			
		
	if (!$single_post){
		echo  '</div> <!-- .blog-post-summary -->';
		}

	echo  '</div> <!-- .blog-post -->'; 
	
	
	if ($single_post){
		comments_template( '', true );
	}
	
?>