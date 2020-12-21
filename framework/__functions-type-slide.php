<?php
	
	#
	#	Fast theme support
	#	
	#	add_theme_support('ewf-slider-title');
	#	add_theme_support('ewf-slider-description');
	#	
	
	
	#	Change default slugs
	#
	define ('EWF_SLIDE_SLUG'					, 'slide'								);
	define ('EWF_SLIDE_TAX_CATEGORY'			, 'slide-category'						);
	
	

	add_action('init', 'ewf_register_type_slide');
	add_action('init', 'ewf_register_slide_taxonomies');
	
	add_action('admin_menu'	, 'ewf_slide_meta_install');
	add_action('save_post'	, 'ewf_slide_meta_update');
	
	add_image_size( 'slider-full', 9999, 700, true);
	
	function ewf_register_type_slide() {
		register_post_type( EWF_SLIDE_SLUG, 
		
			array(
			'labels' => array(
				'name' 					=> __( 'Slides'						,EWF_SETUP_THEME_DOMAIN ),
				'singular_name' 		=> __( 'Slide'						,EWF_SETUP_THEME_DOMAIN ),
				'add_new' 				=> __( 'Add New'					,EWF_SETUP_THEME_DOMAIN ),
				'add_new_item' 			=> __( 'Add New Slide'				,EWF_SETUP_THEME_DOMAIN ),
				'edit' 					=> __( 'Edit'						,EWF_SETUP_THEME_DOMAIN ),
				'edit_item' 			=> __( 'Edit Slide'					,EWF_SETUP_THEME_DOMAIN ),
				'new_item' 				=> __( 'New Slide'					,EWF_SETUP_THEME_DOMAIN ),
				'view' 					=> __( 'View Slide'					,EWF_SETUP_THEME_DOMAIN ),
				'view_item' 			=> __( 'View Slide'					,EWF_SETUP_THEME_DOMAIN ),
				'search_items' 			=> __( 'Search Slides'				,EWF_SETUP_THEME_DOMAIN ),
				'not_found' 			=> __( 'No slides found'			,EWF_SETUP_THEME_DOMAIN ),
				'not_found_in_trash' 	=> __( 'No slides found in Trash'	,EWF_SETUP_THEME_DOMAIN ),
				'parent' 				=> __( 'Parent slides'				,EWF_SETUP_THEME_DOMAIN ),
				),
			'public' 	=> true,
			'rewrite' 	=> false, 
			'slug'		=> EWF_SLIDE_SLUG,
			'menu_position' => 92,
			'show_ui' 	=> true,
			'supports' 	=> array('title', 'thumbnail', ) 
			));
	}
	
	function ewf_register_slide_taxonomies(){
		register_taxonomy( EWF_SLIDE_TAX_CATEGORY, EWF_SLIDE_SLUG, 
			array( 'hierarchical' => true, 
						   'slug' => EWF_SLIDE_TAX_CATEGORY,
						  'label' => __('Categories', EWF_SETUP_THEME_DOMAIN), 
					  'query_var' => true,
						'rewrite' => true ));  
	}
	
	function ewf_slide_meta_install() {
		 add_meta_box( 'ewf_slides_meta',__('Slide text', EWF_SETUP_THEME_DOMAIN), 'ewf_slide_meta_source', 'slide', 'normal', 'high' );
	}

	function ewf_slide_meta_update() {
		global $post;
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post->ID;
		}
		
		if (array_key_exists('slide_description', $_POST) ){
			update_post_meta($post->ID, "slide_description", esc_html($_POST["slide_description"]));
		}
	}
 
	function ewf_slide_meta_source() {
		global $post; 
		
		$slide_meta = get_post_custom($post->ID);
		$slide_title = null;
		$slide_description = null;

		if (array_key_exists('slide_title', $slide_meta)){
			$slide_title = $slide_meta["slide_title"][0]; 
		}
		
		if (array_key_exists('slide_description', $slide_meta)){
			$slide_description = $slide_meta["slide_description"][0];
		}
		

		echo '<div class="ewf-meta">';
			
			if (current_theme_supports('ewf-slider-title')){
				echo '<label>'.__( 'Title', EWF_SETUP_THEME_DOMAIN ).'</label>
				<input name="slide_title" value="'.$slide_title.'" >';
			}
			
			if (current_theme_supports('ewf-slider-description')){
				echo '<label>'.__( 'Description', EWF_SETUP_THEME_DOMAIN ).'</label>
				<textarea class="full" rows="6" name="slide_description" >'.$slide_description.'</textarea>';
			}
			
		echo '</div>';
	}


?>