<?php
	
	#
	#	Fast theme support
	#	
	#	add_theme_support('ewf-slider-title');
	#	add_theme_support('ewf-slider-description');
	#	
	
	
	#	Change default slugs
	#
	define ('EWF_STUDY_SLUG'					, 'study'								);
	define ('EWF_STUDY_TAX_CATEGORY'			, 'study-category'						);
	
	

	add_action('init', 'ewf_register_type_study');
	add_action('init', 'ewf_register_study_taxonomies');
	
	add_action('admin_menu'	, 'ewf_study_meta_install');
	add_action('save_post'	, 'ewf_study_meta_update');
	
	add_image_size( 'study-full', 9999, 700, true);
	
	function ewf_register_type_study() {
		register_post_type( EWF_STUDY_SLUG, 
		
			array(
			'labels' => array(
				'name' 					=> __( 'Case Studies'				,EWF_SETUP_THEME_DOMAIN ),
				'singular_name' 		=> __( 'Case Study'					,EWF_SETUP_THEME_DOMAIN ),
				'add_new' 				=> __( 'Add New'					,EWF_SETUP_THEME_DOMAIN ),
				'add_new_item' 			=> __( 'Add New Case Study'			,EWF_SETUP_THEME_DOMAIN ),
				'edit' 					=> __( 'Edit'						,EWF_SETUP_THEME_DOMAIN ),
				'edit_item' 			=> __( 'Edit Case Study'			,EWF_SETUP_THEME_DOMAIN ),
				'new_item' 				=> __( 'New Case Study'				,EWF_SETUP_THEME_DOMAIN ),
				'view' 					=> __( 'View Case Study'			,EWF_SETUP_THEME_DOMAIN ),
				'view_item' 			=> __( 'View Slide'					,EWF_SETUP_THEME_DOMAIN ),
				'search_items' 			=> __( 'Search Case Studies'		,EWF_SETUP_THEME_DOMAIN ),
				'not_found' 			=> __( 'No studies found'			,EWF_SETUP_THEME_DOMAIN ),
				'not_found_in_trash' 	=> __( 'No studies found in Trash'	,EWF_SETUP_THEME_DOMAIN ),
				'parent' 				=> __( 'Parent studies'				,EWF_SETUP_THEME_DOMAIN ),
				),
			'public' 	=> true,
			'rewrite' 	=> false, 
			'slug'		=> EWF_STUDY_SLUG,
			'menu_position' => 93,
			'show_ui' 	=> true,
			'supports' 	=> array('title', 'thumbnail', 'excerpt') 
			));
	}
	
	function ewf_register_study_taxonomies(){
		register_taxonomy( EWF_STUDY_TAX_CATEGORY, EWF_STUDY_SLUG, 
			array( 'hierarchical' => true, 
						   'slug' => EWF_STUDY_TAX_CATEGORY,
						  'label' => __('Categories', EWF_SETUP_THEME_DOMAIN), 
					  'query_var' => true,
				  'show_in_menu'  => false,
						'rewrite' => true ));  
	}
	
	function ewf_study_meta_install() {
		 add_meta_box( 'ewf_slides_meta',__('Slide details', EWF_SETUP_THEME_DOMAIN), 'ewf_study_meta_source', 'study', 'normal', 'high' );
	}

	function ewf_study_meta_update() {
		global $post;
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post->ID;
		}
		
		if (array_key_exists('slide_link_title', $_POST) ){
			update_post_meta($post->ID, "slide_link_title", esc_html($_POST["slide_link_title"]));
			update_post_meta($post->ID, "slide_link_url", esc_html($_POST["slide_link_url"]));
		}
	}
 
	function ewf_study_meta_source() {
		global $post; 
		
		$slide_meta = get_post_custom($post->ID);
		$slide_link_url = null;
		$slide_link_title = null;

		if (array_key_exists('slide_link_url', $slide_meta)){
			$slide_link_url = $slide_meta["slide_link_url"][0]; 
		}
		
		if (array_key_exists('slide_link_title', $slide_meta)){
			$slide_link_title = $slide_meta["slide_link_title"][0];
		}
		

		echo '<div class="ewf-meta">';
			
			echo '<label>'.__( 'Link title', EWF_SETUP_THEME_DOMAIN ).'</label>
			<input name="slide_link_title" value="'.$slide_link_title.'" >';
		
			echo '<label>'.__( 'Link URL', EWF_SETUP_THEME_DOMAIN ).'</label>
			<input name="slide_link_url" value="'.$slide_link_url.'" >';
			
		echo '</div>';
	}

	
	
	
	
	

?>