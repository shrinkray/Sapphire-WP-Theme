<?php 	
	
	global $ewf_modHeader, $post;
	
	
	if (!function_exists('ewf_get_sidebar_id')){
		return false;
	}
	
	if (!is_object($ewf_modHeader)){
		return false;
	}
	
	$ewf_page_id 				= ewf_get_page_relatedID(true);
	
	if (is_404()){
		$ewf_page_id 			= get_option(EWF_SETUP_THNAME."_page_404", 0);
	}
	
	$ewf_modHeader_meta 		= $ewf_modHeader->get_postSettings($ewf_page_id);
	$ewf_modHeader_meta_page	= $ewf_modHeader_meta;
	
	
	
	#	Get global settings
	#
	$ewf_modHeader_settings 	= $ewf_modHeader->get_mod_settings();
	// $ewf_modHeader_meta['debug'][] = '# Init';
	// $ewf_modHeader_meta['debug'][] = '# Related ID:'.$ewf_page_id;
	
	

	
	#	If page header is disabled
	#	
	if ($ewf_modHeader_meta['active'] == '0'){
		return false;
	}
	
	if (array_key_exists('master_use', $ewf_modHeader_meta) && $ewf_modHeader_meta['master_use']== 1 && $ewf_modHeader_meta['master_id'] > 0 ){
		$ewf_modHeader_meta 	= $ewf_modHeader->get_postSettings( $ewf_modHeader_meta['master_id'] );
		$ewf_modHeader_meta['debug'][] = '# Use Master';
	}

	
	
	#	In case we have an image added as page header
	#
	if ($ewf_modHeader_meta['image_id'] || $ewf_modHeader_meta['background_color']){
		
		$ewf_modHeader_class = null;
		$ewf_modHeader_BackgroundImage = null;
		$ewf_modHeader_BackgroundColor = null;
		$ewf_modHeader_size = 'ewf-modHeader-img-large';
		
		if (current_theme_supports('ewf-modHeader-background-color')){
			if (array_key_exists('background_color', $ewf_modHeader_meta) && $ewf_modHeader_meta['background_color']){
				$ewf_modHeader_BackgroundColor = 'background-color:'.$ewf_modHeader_meta['background_color'].';';
			}
		}
		
		if ($ewf_modHeader_meta['image_id']){
			$ewf_modHeader_image = wp_get_attachment_image_src($ewf_modHeader_meta['image_id'], $ewf_modHeader_size);  
			$ewf_modHeader_BackgroundImage = 'background-image:url('.$ewf_modHeader_image[0].');background-repeat:no-repeat;background-position:top center;';
		}	
		
		
		
		#	If parallax setting was activated on current page
		#
		if (current_theme_supports('ewf-modHeader-parallax')){
			if (array_key_exists('parallax', $ewf_modHeader_meta_page) && $ewf_modHeader_meta_page['parallax'] == 1){
				$ewf_modHeader_class = 'class="parallax" ';
				$ewf_modHeader_size = 'ewf-modHeader-img-parallax';
			}
		}
		
		
		if (array_key_exists('title', $ewf_modHeader_meta) && $ewf_modHeader_meta['title'] != null ){
			echo '<div id="page-header" '.$ewf_modHeader_class.'style="'.$ewf_modHeader_BackgroundImage.$ewf_modHeader_BackgroundColor.'">';
					echo '<div class="ewf-row">';
						echo '<div class="ewf-span12">';
							echo '<h2>'.$ewf_modHeader_meta['title'].'</h2>'; 
						echo '</div>';
					echo '</div>';
			echo '</div><!-- end #page-header -->';
		}
	}else{
		echo '<div id="no-page-header"></div>';
	}
	
	
	// 	DEBUG
		// echo '<pre>';
		// print_r($ewf_modHeader_meta);
		// echo '</pre>';
	
?>