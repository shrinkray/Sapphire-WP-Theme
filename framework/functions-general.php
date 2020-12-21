<?php

#	Functions:
#	
#	ewf_message ($message)
#	ewf_debug_log ($debug, $message)
#


	if ( ! isset( $content_width ) ) $content_width = 940;


#
#	Add and ID column to pages & taxonomy
#	
#	add_theme_support('ewf-editor-columnID');
#

	if (current_theme_supports('ewf-editor-columnID')){
				
			add_action('admin_init'		, 'ewf_add_id_column');

			function ewf_add_id_column() {
				add_action('admin_head', 'ewf_add_id_column_css');

				add_filter('manage_posts_columns', 'ewf_add_id_column_source');
				add_action('manage_posts_custom_column', 'ewf_add_id_column_value', 10, 2);

				add_filter('manage_pages_columns', 'ewf_add_id_column_source');
				add_action('manage_pages_custom_column', 'ewf_add_id_column_value', 10, 2);

				foreach ( get_taxonomies() as $taxonomy ) {
					add_action("manage_edit-${taxonomy}_columns", 'ewf_add_id_column_source');			
					add_filter("manage_${taxonomy}_custom_column", 'ewf_add_id_column_value_return', 10, 3);
				}
			}
			
			function ewf_add_id_column_source($cols) {
				$cols['item-id'] = '<span>ID</span>'; 
				return $cols;
			} 

			function ewf_add_id_column_value($column_name, $id) { 
				if ($column_name == 'item-id') echo $id;
			}

			function ewf_add_id_column_value_return($value, $column_name, $id) {
				if ($column_name == 'item-id') $value = $id;
				return $value;
			}

			function ewf_add_id_column_css() {
				echo ' <style type="text/css"> #item-id { width: 50px; }</style>';
			}

	}

	

	
#	
#	Output messages in the theme
#
	function ewf_message($msg, $reference = null){
		return '<div class="alert error">'.$msg.'</div>';
	}
	
	
	
#	
#	Used for debugging purpose	
#
	function ewf_debug_log($debug, $message){ 
		#
		# ewf_message($message);
		#
		apply_filters($debug, $message);
	}
	

	
	function ewf_load_socialProfiles(){
		$profiles = array();
		
		$profiles[] = array( 'class' => 'facebook'		, 'url' => get_option(EWF_SETUP_THNAME."_social_facebook"	, null ));
		$profiles[] = array( 'class' => 'twitter'		, 'url' => get_option(EWF_SETUP_THNAME."_social_twitter"	, null ));
		$profiles[] = array( 'class' => 'google-plus'	, 'url' => get_option(EWF_SETUP_THNAME."_social_plus"		, null ));
		$profiles[] = array( 'class' => 'pinterest'		, 'url' => get_option(EWF_SETUP_THNAME."_social_pinterest"	, null ));
		$profiles[] = array( 'class' => 'instagram'		, 'url' => get_option(EWF_SETUP_THNAME."_social_instagram"	, null ));	
		$profiles[] = array( 'class' => 'tumblr'		, 'url' => get_option(EWF_SETUP_THNAME."_social_tumblr"		, null ));	
		$profiles[] = array( 'class' => 'youtube'		, 'url' => get_option(EWF_SETUP_THNAME."_social_youtube"	, null ));	
		$profiles[] = array( 'class' => 'flickr'		, 'url' => get_option(EWF_SETUP_THNAME."_social_flickr"		, null ));	
		$profiles[] = array( 'class' => 'linkedin'		, 'url' => get_option(EWF_SETUP_THNAME."_social_linkedin"	, null ));	
		
		
		foreach($profiles as $key=>$value){
			if ($value['url'] == null){
				unset($profiles[$key]);
			}
		}
		
		
		#	if (count($profiles) > 1){
		#		$profiles[count($profiles)-1]['class'] = $profiles[count($profiles)-1]['class'].' last';
		#	}elseif(count($profiles) == 1){
		#		$profiles[count($profiles)-1]['class'] = $profiles[count($profiles)-1]['class'].' last';
		#	}
		
		
		return $profiles;
	}
		
		
	function ewf_excerpt_max_charlength($charlength) {
		$excerpt = get_the_excerpt();
		$charlength++;

		if ( mb_strlen( $excerpt ) > $charlength ) {
			$subex = mb_substr( $excerpt, 0, $charlength - 5 );
			$exwords = explode( ' ', $subex );
			$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
			if ( $excut < 0 ) {
				echo mb_substr( $subex, 0, $excut );
			} else {
				echo $subex;
			}
			echo '[...]';
		} else {
			echo $excerpt;
		}
	}
	
	## add woocommerce support 
	
	add_action( 'after_setup_theme', 'woocommerce_support' );
		function woocommerce_support() {
		    add_theme_support( 'woocommerce' );
		}

	/*
	if (!function_exists('is_post_type')){
	
		function is_post_type($type = null){
			global $post;
			
			if (get_post_type($post) == strtolower($type)){
				return true;
			}else{
				return false;
			}
		}
	}
	*/
	
	
	/*
	function efw_get_content_formatted ($more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
	
		$content = get_the_content($more_link_text, $stripteaser, $more_file);
		$content = apply_filters('the_content', $content);
		$content = str_replace(']]>', ']]&gt;', $content); 
		
		return $content;
	}
	*/

?>