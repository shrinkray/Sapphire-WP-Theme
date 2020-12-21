<?php 	
	
	global $ewf_modHeader, $post;
	
	
	if (!function_exists('ewf_get_sidebar_id')){
		return false;
	}
	
	if (!is_object($ewf_modHeader)){
		return false;
	}
	
	$ewf_page_id 				= ewf_get_page_relatedID(true);
	
	$ewf_modHeader_meta 		= $ewf_modHeader->get_postSettings($ewf_page_id);
	$ewf_modHeader_meta_page	= $ewf_modHeader_meta;
	
	
	
	#	Get global settings
	#
	$ewf_modHeader_settings 	= $ewf_modHeader->get_mod_settings();
	

	
	#	If page header is disabled
	#	
	if ($ewf_modHeader_meta['active'] == '0'){
		return false;
	}
	
	if (array_key_exists('master_use', $ewf_modHeader_meta) && $ewf_modHeader_meta['master_use']== 1 && $ewf_modHeader_meta['master_id'] > 0 ){
		$ewf_modHeader_meta 	= $ewf_modHeader->get_postSettings( $ewf_modHeader_meta['master_id'] );
	}

	
	
	#	In case we have an image added as page header
	#
	if ($ewf_modHeader_meta['image_id']){
		
		$ewf_modHeader_class = null;
		$ewf_modHeader_size = 'ewf-modHeader-img-large';
		
		
		#	If parallax setting was activated on current page
		#
		if (current_theme_supports('ewf-modHeader-parallax')){
			if (array_key_exists('parallax', $ewf_modHeader_meta_page) && $ewf_modHeader_meta_page['parallax'] == 1){
				$ewf_modHeader_class = 'parallax';
				$ewf_modHeader_size = 'ewf-modHeader-img-parallax';
			}
		}
		
		$ewf_headerMeta_image = wp_get_attachment_image_src($ewf_modHeader_meta['image_id'], $ewf_modHeader_size);  
		
		echo '<div id="page-header" class="'.$ewf_modHeader_class.'" style="background:url('.$ewf_headerMeta_image[0].') no-repeat top center;">';
			if (array_key_exists('title', $ewf_modHeader_meta) && $ewf_modHeader_meta['title'] != null ){
				echo '<div id="page-header-title">';
					echo $ewf_modHeader_meta['title']; 
				echo '</div>';
			}
		echo '</div><!-- end #page-header -->';
	}else{
		echo '<div id="no-page-header"></div>';
	}
	
	
	
	
	
	
	
?>