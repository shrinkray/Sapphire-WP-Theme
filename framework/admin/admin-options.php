<?php


#	Attach required css & js in admin scripts header
#	
	add_action('admin_enqueue_scripts'							, 'ewf_admin_load_includes');
	add_action('admin_menu'										, 'ewf_admin_options_update' );
		
	add_action('wp_head'										, 'ewf_append_analytics' );
	add_action('wp_head'										, 'ewf_append_css' );
	
	
	
#	Register actions for AJAX callback functions
#	
	add_action('wp_ajax_ewf_ui_setImage'						, 'ajax_ewf_admin_ui_image' );
	add_action('wp_ajax_ewf_ui_font_variants'					, 'ajax_ewf_admin_ui_font_variants' );
	add_action('wp_ajax_ewf_ui_setTab'							, 'ajax_ewf_admin_ui_selectTab' );
	

	
#	Register image sizes used by EWF Admin
#	
	add_image_size('ewf-logo-size'								, 195, 50, true);



#	Execute first theme install
#	
	add_action("after_switch_theme", "ewf_admin_theme_install"	,10 ,2);
	
	
	
	
	
	
	
#	Add extra body class for layout settings
#
	add_filter('body_class','ewf_admin_body_classes');
	function ewf_admin_body_classes($classes) {
		
		
		if (get_option(EWF_SETUP_THNAME."_page_layout", 'full-width') == 'boxed-in'){
			$classes[] = 'ewf-boxed-layout';
		}
		
		if (get_option(EWF_SETUP_THNAME."_header_sticky", 'false') == 'true'){
			$classes[] = 'ewf-sticky-header';
		}
		
		
		return $classes;
	}
	
	
	
	
	
	
	

	
	$ewf_admin_options = array (
		
		#	General Settings
		#
		array("type" => "panel", "name" => "Home page", "mode"=>"open", "id" => "ewf-panel-general"),					   
			  
				array(    "type" => "ewf-ui-section", "name" => '<strong>'.__("Favicon", EWF_SETUP_THEME_DOMAIN).'</strong>' ),
				
				array(    "type" => "ewf-ui-image", 
					"image-size" => "thumbnail",
					"image-height" => "32",
							"id" => EWF_SETUP_THNAME."_favicon",
				 "section-title" => __("Favicon", EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __("Upload your favicon", EWF_SETUP_THEME_DOMAIN),
						   "std" => get_template_directory_uri().'/favicon.png'),


				array(    "type" => "ewf-ui-section", "name" => '<strong>'.__("Layout", EWF_SETUP_THEME_DOMAIN).'</strong>'),
				
				array(    "type" => "ewf-ui-options", 
							"id" => EWF_SETUP_THNAME."_page_layout",
					   "options" => array(
							'boxed-in'=>array(
								'label' => __('Boxed in', EWF_SETUP_THEME_DOMAIN),
								'value' => 'boxed-in',
								'class' => 'ewf-layout-boxedin'
								
								), 
							'full-width' => array(
								'label' => __('Full Width', EWF_SETUP_THEME_DOMAIN),
								'value' => 'full-width',
								'class' => 'ewf-layout-fullwidth'
								)
						),
				 "section-title" => __("Layout style", EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __("Select the layout", EWF_SETUP_THEME_DOMAIN),
						   "std" => 'full-width'),			
						   
						   
						   
				array(    "type" => "ewf-ui-select", 
							"id" => EWF_SETUP_THNAME."_page_404",
				 "section-title" => __("Page not found", EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __("Select the 404 page from your existing pages", EWF_SETUP_THEME_DOMAIN),
					   "options" => ewf_load_site_pages(),		
						   "std" => 0),		
						   
				array(    "type" => "ewf-ui-slider", 
							"id" => EWF_SETUP_THNAME."_content_width",
						   "min" => '1120',
						   "max" => '1400',
						  "step" => '5',
				 "section-title" => __("Content width", EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __("Select the content width", EWF_SETUP_THEME_DOMAIN),
						   "std" => '1170px'),		
					
					
					
				array(    "type" => "ewf-ui-background", 
					"image-size" => "thumbnail",
					"image-height" => "50",
							"id" => EWF_SETUP_THNAME."_background",
				 "section-title" => __("Background", EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __("Adjust background settings", EWF_SETUP_THEME_DOMAIN),
						   "std" => json_encode(array(  
										array('name' => 'background-color'			, 'value' => '#fff'			),
										array('name' => 'background-pattern'		, 'value' => ''				),
										array('name' => 'background-repeat'			, 'value' => 'repeat-all'	),
										array('name' => 'background-position'		, 'value' => 'center center'),
										array('name' => 'background-image'			, 'value' => ''				),
										array('name' => 'background-image-preview'	, 'value' => ''				),
										array('name' => 'background-attachment'		, 'value' => 'scroll'		),
										array('name' => 'background-stretch'		, 'value' => 'true'			),
									))
								),
				
				
						   
			  
				// array(    "type" => "ewf-ui-section", "name" => __("<strong>Background</strong>", EWF_SETUP_THEME_DOMAIN)),
						   
				// array(    "type" => "ewf-ui-image", 
							// "id" => EWF_SETUP_THNAME."_favicon_retina",
				  // "image-height" => "50",
					// "image-size" => "thumbnail",
				 // "section-title" => __("Favicon for retina", EWF_SETUP_THEME_DOMAIN),
		   // "section-description" => __("Upload your hight quality favoicon", EWF_SETUP_THEME_DOMAIN),
						   // "std" => get_template_directory_uri().'/apple-touch-icon-144-precomposed.png'),
						   
				
				array(    "type" => "ewf-ui-section", "name" => '<strong>'.__("Includes", EWF_SETUP_THEME_DOMAIN).'</strong>'),
						  
				array(    "type" => "textarea", 
							"id" => EWF_SETUP_THNAME."_include_analytics",
				 "section-title" => __('Google Analytics', EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __('Paste the analytics code', EWF_SETUP_THEME_DOMAIN),
						   "std" => null ,
						  ),
						  
				array(    "type" => "textarea", 
							"id" => EWF_SETUP_THNAME."_include_css",
				 "section-title" => __('Extra CSS Code', EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __('Paste extra css code here', EWF_SETUP_THEME_DOMAIN),
						   "std" => null,
						  ),
						  
		array("type" => "panel", "mode"=>"close"),	
	
	
		#	Typography settings
		#
		array("type" => "panel", "name" => "Typography settings", "mode"=>"open", "id" => "ewf-panel-typography"),

				array(    "type" => "ewf-ui-toggle", 
							"id" => EWF_SETUP_THNAME."_fonts_custom",
				 "section-title" => __("Use custom typography", EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __("You can overwrite custom fonts", EWF_SETUP_THEME_DOMAIN),
					"dependency" => '.group-fonts-custom',
						   "std" => false),	
		
				array(    "type" => "ewf-ui-section", 
						  "name" => '<strong>'.__("Font - Body", EWF_SETUP_THEME_DOMAIN).'</strong>',
						 "group" => 'fonts-custom'),
		
		
				array(    "type" => "ewf-ui-font", 
							"id" => EWF_SETUP_THNAME."_body_font",
				 "section-title" => __("Font family", EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __("Set the font of the body", EWF_SETUP_THEME_DOMAIN),
						 "group" => 'fonts-custom',
						   "std" => json_encode(array(
										array('name' => 'font-family', 'value' => 'Open sans'),
										array('name' => 'font-weight', 'value' => 'Regular'),
										array('name' => 'font-italic', 'value' => '')
									))
							),
		
		
				array(    "type" => "ewf-ui-slider", 
							"id" => EWF_SETUP_THNAME."_body_font_size",
						   "max" => '60',
				 "section-title" => __("Font size", EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __("Set fize of the font", EWF_SETUP_THEME_DOMAIN),
						 "group" => 'fonts-custom',
						   "std" => '13px'),
						  
		
				array(    "type" => "ewf-ui-slider", 
							"id" => EWF_SETUP_THNAME."_body_font_lineheight",
						   "max" => '60',
				 "section-title" => __("Line height", EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __("Set the font line height", EWF_SETUP_THEME_DOMAIN),
						 "group" => 'fonts-custom',
						   "std" => '21px'),
						   
						   
				array(    "type" => "ewf-ui-slider", 
							"id" => EWF_SETUP_THNAME."_body_font_margin",
						   "max" => '60',
				 "section-title" => __("Margin bottom", EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __("Set the bottom spacing", EWF_SETUP_THEME_DOMAIN),
						 "group" => 'fonts-custom',
						   "std" => '20px'),
													
						  
				array(    "type" => "ewf-ui-section", 
						  "name" => __("<strong>Font</strong> - Headings", EWF_SETUP_THEME_DOMAIN),
						 "group" => 'fonts-custom'),
				
				
				array(    "type" => "ewf-ui-section", 
						  "name" => __("<strong>Font</strong> - Navigation", EWF_SETUP_THEME_DOMAIN),
						 "group" => 'fonts-custom'),
		
		array("type" => "panel", "mode"=>"close"),
				
				
	
		#	Header settings
		#
		array("type" => "panel", "name" => "Header settings", "mode"=>"open", "id" => "ewf-panel-header"),
		
				array(    "type" => "ewf-ui-image", 
					"image-size" => "ewf-logo-size",
				  "image-height" => "50",
							"id" => EWF_SETUP_THNAME."_logo_url",
				 "section-title" => __("Header logo", EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __("Upload logo in the header", EWF_SETUP_THEME_DOMAIN),
						   "std" => get_template_directory_uri().'/layout/images/logo.png'),
						   
						   
				array(    "type" => "ewf-ui-toggle", 
							"id" => EWF_SETUP_THNAME."_header_sticky",
				 "section-title" => __("Sticky header", EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __("Keep the header visible after scrolling", EWF_SETUP_THEME_DOMAIN),
						   "std" => false),	

		array("type" => "panel", "mode"=>"close"),
		
		
		
		#	Footer settings
		#
		array("type" => "panel", "name" => "Footer settings", "mode"=>"open", "id" => "ewf-panel-footer"),
		
				array(    "type" => "ewf-ui-toggle", 
							"id" => EWF_SETUP_THNAME."_footer_section",
				 "section-title" => __("Footer section", EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __("Show footer section at the bottom", EWF_SETUP_THEME_DOMAIN),
				    "dependency" => '.group-footer-custom',
						   "std" => 'true'),	
						   
			   array(     "type" => "ewf-ui-columns", 
							"id" => EWF_SETUP_THNAME."_footer_columns",
					   "columns" => '3',
				 "section-title" => __("Footer columns", EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __("Select the number of columns", EWF_SETUP_THEME_DOMAIN),
						 "group" => 'footer-custom',
						   "std" => '4,4,4'),
						   
				array(    "type" => "ewf-ui-toggle", 
							"id" => EWF_SETUP_THNAME."_footer_sub",
				 "section-title" => __("Footer sub", EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __("Show sub footer section at the bottom", EWF_SETUP_THEME_DOMAIN),
						   "std" => 'true'),	
					
		array("type" => "panel", "mode"=>"close"),
		
		
	 
		#	Color schemes
		#
		array("type" => "panel", "name" => "Colors schemes", "mode"=>"open", "id" => "ewf-panel-colors"),
			
				array(    "type" => "ewf-ui-toggle", 
							"id" => EWF_SETUP_THNAME."_colors_custom",
				 "section-title" => __("Use custom colors", EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __("You can overwrite the default color scheme", EWF_SETUP_THEME_DOMAIN),
					"dependency" => '.group-colors-custom',
						   "std" => false),	
		
				array(    "type" => "ewf-ui-color", 
							"id" => EWF_SETUP_THNAME."_colors_accent_01",
				 "section-title" => __('Accent color #1', EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __('Specify the color you want to use.', EWF_SETUP_THEME_DOMAIN),
						 "group" => 'colors-custom',
						   "std" => '#08ab89',
						   ),
		
				array(    "type" => "ewf-ui-color", 
							"id" => EWF_SETUP_THNAME."_colors_accent_02",
				 "section-title" => __('Accent color #2', EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __('Specify the color you want to use.', EWF_SETUP_THEME_DOMAIN),
						 "group" => 'colors-custom',
						   "std" => '#474E5D',
						  ),
						  
				array(    "type" => "ewf-ui-color", 
							"id" => EWF_SETUP_THNAME."_colors_accent_02_hover",
				 "section-title" => __('Accent Color #2 Hover', EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __('Specify the color you want to use.', EWF_SETUP_THEME_DOMAIN),
						 "group" => 'colors-custom',
						   "std" => '#8BD99F',
						  ),
		
		
				array(    "type" => "ewf-ui-color", 
							"id" => EWF_SETUP_THNAME."_colors_accent_03",
				 "section-title" => __('Accent color #3', EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __('Specify the color you want to use.', EWF_SETUP_THEME_DOMAIN),
						 "group" => 'colors-custom',
						   "std" => '#EEE5DD',
						  ),
						  
				array(    "type" => "ewf-ui-color", 
							"id" => EWF_SETUP_THNAME."_colors_accent_03_hover",
				 "section-title" => __('Accent color #3 Hover', EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __('Specify the color you want to use.', EWF_SETUP_THEME_DOMAIN),
						 "group" => 'colors-custom',
						   "std" => '#96E0A9',
						  ),
						  
				array(    "type" => "ewf-ui-color", 
							"id" => EWF_SETUP_THNAME."_color_header_top",
				 "section-title" => __('Header top color', EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __('Specify the color you want to use.', EWF_SETUP_THEME_DOMAIN),
						 "group" => 'colors-custom',
						   "std" => '#484F5E',
						  ),
						  
				array(    "type" => "ewf-ui-color", 
							"id" => EWF_SETUP_THNAME."_color_header_top_border",
				 "section-title" => __('Header top border color', EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __('Specify the color you want to use.', EWF_SETUP_THEME_DOMAIN),
						 "group" => 'colors-custom',
						   "std" => '#62D4D8',
						  ),
		
				array(    "type" => "ewf-ui-color", 
							"id" => EWF_SETUP_THNAME."_color_header_top_font",
				 "section-title" => __('Header top font color', EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __('Specify the color you want to use.', EWF_SETUP_THEME_DOMAIN),
						 "group" => 'colors-custom',
						   "std" => '#ffffff',
						  ),
						  
				array(    "type" => "ewf-ui-color", 
							"id" => EWF_SETUP_THNAME."_color_content",
				 "section-title" => __('Content font color', EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __('Specify the color you want to use.', EWF_SETUP_THEME_DOMAIN),
						 "group" => 'colors-custom',
						   "std" => '#474D5D',
						  ),
						  
				array(    "type" => "ewf-ui-color", 
							"id" => EWF_SETUP_THNAME."_color_footer_top",
				 "section-title" => __('Footer top color', EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __('Specify the color you want to use.', EWF_SETUP_THEME_DOMAIN),
						 "group" => 'colors-custom',
						   "std" => '#79849B',
						  ),
						  
				array(    "type" => "ewf-ui-color", 
							"id" => EWF_SETUP_THNAME."_color_footer_top_font",
				 "section-title" => __('Footer top font color', EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __('Specify the color you want to use.', EWF_SETUP_THEME_DOMAIN),
						 "group" => 'colors-custom',
						   "std" => '#FFFFFF',
						  ),
						  
				array(    "type" => "ewf-ui-color", 
							"id" => EWF_SETUP_THNAME."_color_footer_middle",
				 "section-title" => __('Footer middle color', EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __('Specify the color you want to use.', EWF_SETUP_THEME_DOMAIN),
						 "group" => 'colors-custom',
						   "std" => '#484F5E',
						  ),
						  
				array(    "type" => "ewf-ui-color", 
							"id" => EWF_SETUP_THNAME."_color_footer_middle_font",
				 "section-title" => __('Footer middle font color', EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __('Specify the color you want to use.', EWF_SETUP_THEME_DOMAIN),
						 "group" => 'colors-custom',
						   "std" => '#D1D1D1',
						  ),
						  
				array(    "type" => "ewf-ui-color", 
							"id" => EWF_SETUP_THNAME."_color_footer_bottom",
				 "section-title" => __('Footer bottom color', EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __('Specify the color you want to use.', EWF_SETUP_THEME_DOMAIN),
						 "group" => 'colors-custom',
						   "std" => '#303745',
						  ),
						  
				array(    "type" => "ewf-ui-color", 
							"id" => EWF_SETUP_THNAME."_color_footer_bottom_font",
				 "section-title" => __('Footer bottom font color', EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __('Specify the color you want to use.', EWF_SETUP_THEME_DOMAIN),
						 "group" => 'colors-custom',
						   "std" => '#D1D1D1',
						  ),
		
		
		array("type" => "panel", "mode"=>"close"),

	 
	 
		#	Social Profiles
		#
		array("type" => "panel", "name" => "Social Profiles", "mode"=>"open", "id" => "ewf-panel-social"),

				array(    "type" => "text", 
							"id" => EWF_SETUP_THNAME."_social_facebook",
				 "section-title" => __('Facebook', EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __('Specify the link to your Facebook account.', EWF_SETUP_THEME_DOMAIN),
						   "std" => null,
						  ),
						  
				array(    "type" => "text", 
							"id" => EWF_SETUP_THNAME."_social_twitter",
				 "section-title" => __('Twitter', EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __('Specify the link to your Twitter account.', EWF_SETUP_THEME_DOMAIN),
						   "std" => null,
						  ),
						  
				array(    "type" => "text", 
							"id" => EWF_SETUP_THNAME."_social_plus",
				 "section-title" => __('Google Plus', EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __('Specify the link to your Goolge Plus account.', EWF_SETUP_THEME_DOMAIN),
						   "std" => null,
						  ),
						  
				array(    "type" => "text", 
							"id" => EWF_SETUP_THNAME."_social_pinterest",
				 "section-title" => __('Pinterest', EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __('Specify the link to your Pinterest account.', EWF_SETUP_THEME_DOMAIN),
						   "std" => null,
						  ),
						  
				array(    "type" => "text", 
							"id" => EWF_SETUP_THNAME."_social_instagram",
				 "section-title" => __('Instagram', EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __('Specify the link to your Instagram account.', EWF_SETUP_THEME_DOMAIN),
						   "std" => null,
						  ),
		
				array(    "type" => "text", 
							"id" => EWF_SETUP_THNAME."_social_tumblr",
				 "section-title" => __('Tumblr', EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __('Specify the link to your Tumblr account.', EWF_SETUP_THEME_DOMAIN),
						   "std" => null,
						  ),
						  
				array(    "type" => "text", 
							"id" => EWF_SETUP_THNAME."_social_youtube",
				 "section-title" => __('YouTube', EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __('Specify the link to your YouTube account.', EWF_SETUP_THEME_DOMAIN),
						   "std" => null,
						  ),
		
				array(    "type" => "text", 
							"id" => EWF_SETUP_THNAME."_social_flickr",
				 "section-title" => __('Flickr', EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __('Specify the link to your Flickr account.', EWF_SETUP_THEME_DOMAIN),
						   "std" => null,
						  ),
						  
				array(    "type" => "text", 
							"id" => EWF_SETUP_THNAME."_social_linkedin",
				 "section-title" => __('LinkedIn', EWF_SETUP_THEME_DOMAIN),
		   "section-description" => __('Specify the link to your LinkedIn account.', EWF_SETUP_THEME_DOMAIN),
						   "std" => null,
						  ),
		
		array("type" => "panel", "mode"=>"close"),

	);




	function ewf_admin_renderOptions($ewf_admin_options){
		
		ob_start();
		
		$panel_active = get_option(EWF_SETUP_THNAME."_admin_tab_active", 'ewf-panel-general');
		
		foreach ($ewf_admin_options as $value) {
			switch ( $value['type'] ) {
					
					
				// case 'upload':
					// $textVal = '';
					
					// if ( get_option( $value['id'] ) != "") {  
						// $textVal = stripslashes(get_option( $value['id'] ));  
					// } else {  
						// $textVal = $value['std']; 
					// }
					
					// echo '<div class="bordered clfixed ewf-upload-input">
							// <div class="col-220">
								// <h4>'.$value['section-title'].'</h4>
								// <p><em>'.$value['section-description'].'</em></p>
							// </div>
							// <div class="col-340 last">
								// <input type="button" class="button upload-button" value="Upload" /><input class="upload-path" style="width:220px;display:inline-block;margin-left:4px;border-radius:3px;border:1px solid #CCCCCC;padding:4px;" name="'.$value['id'].'" id="'.$value['id'].'" type="'.$value['type'].'" value="'.$textVal.'"/>							
							// </div>
						  // </div>';
					// break;
					
				case "panel": 
					if ($value['mode']=="open"){
						$extra = null;
						if (array_key_exists('active', $value)){
							$extra = ' active ';
						}
					
						if ($value['id'] == $panel_active) {
							$extra = ' active ';
						}
					
						echo '<div class="ewf-panel '.$extra.$value['id'].' fixed">
								<div class="ewf-panel-content">';
					}
					
					if ($value['mode']=="close"){
						echo '</div></div>';
					}
					break;

				case "open": 
					echo '<div class="section">';
					break;


				case "close":
					echo '</div>';
					break;

					
				case "label":
					echo '<label>'.$value['name'].'</label>';
					break;

					
				case "title":
					echo '<h2>'.$value['name'].'</h2>';
					break;
				
				
				case "ewf-ui ewf-ui-section":
			   echo '<div class="ewf-ui-section">
						<h2>'.$value['name'].'</h2>
						
						<div class="ewf-disabled"></div>
					</div>';
					break;
				
				
				
				
				case 'ewf-ui-options':
					$ewf_ui_options_value = get_option($value['id'], $value['std']);
					
					$group_class = null;
					if (array_key_exists('group', $value)){ 
						$group_class = ' group-'.$value['group'];
					}
					
					echo '<div class="ewf-ui ewf-ui-options '.$group_class.' fixed">
							<div class="ewf-col-description">
								<h4>'.$value['section-title'].'</h4>
								<span>'.$value['section-description'].'</span>
							</div>
							<div class="ewf-col-action">
								<div class="ewf-ui-control-options">';
								
								if ( is_array($value['options']) ){
									foreach($value['options'] as $index => $item_option){
										
										$class_active_option = null;
										
										if ($item_option['value'] == $ewf_ui_options_value) {
											$class_active_option = ' ewf-state-active';
										}
										
										echo '<div class="ewf-ui-options-item'.$class_active_option.' '.$item_option['class'].'" data-value="'.$item_option['value'].'">';
											echo '<div><span></span></div>';
											echo '<span>'.$item_option['label'].'</span>';
										echo '</div>';
									}
								}
								
						   echo '</div>';

 						  echo '<input class="ewf-ui-input-option" name="'.$value['id'].'" id="'.$value['id'].'" type="hidden" value="'.$ewf_ui_options_value.'" />							
							</div>';

						echo '<div class="ewf-disabled"></div>
						</div>';
						break;
				
				
				case 'ewf-ui-background':
					// $textVal = '';
					// if ( get_option( $value['id'] ) != "") {  
						// $textVal = stripslashes(get_option( $value['id'] ));  
						// $ewf_ui_image_class = ' active';
					// } else {  
						// $textVal = $value['std']; 
					
					// }
					
					$default_patterns_url = get_template_directory_uri().'/framework/admin/includes/images/patterns/';
					$default_patterns = array( 'bg-body.png', 'bg-body2.png', 'bg-body3.png', 'bg-body4.png', 'bg-body4.png', 'bg-body5.png', 'bg-body6.png', 'bg-body7.png', 'bg-body8.png', 'bg-body9.png', 'bg-body10.png', 'bg-body11.png', 'bg-body12.png', 'bg-body13.png', 'bg-body14.png', 'bg-body15.png', 'bg-body16.png', 'bg-body17.png', 'bg-body18.png', 'bg-body19.png', 'bg-body20.png', 'bg-body21.png', 'bg-body22.png', 'bg-body23.png' );
					
					$background_data_raw = stripslashes(get_option($value['id'], $value['std']));
					$background_data = json_decode( $background_data_raw, true);
					$background_properties = array(); 
					
					foreach($background_data as $key => $item_properties){
						$background_properties[$item_properties['name']] = $item_properties['value'];
					}
					
					
					
					// 	Debug
					// 	echo '<pre>';
					// 		print_r($background_properties);
					// 	echo '</pre>';
					
					
					
					echo '<div class="ewf-ui ewf-ui-background fixed">
							<div class="ewf-col-description">
								<h4>'.$value['section-title'].'</h4>
								<span>'.$value['section-description'].'</span>
							</div>
							
							<div class="ewf-col-action">
								<div class="ewf-ui-control-background" data-image-size="'.$value['image-size'].'">
									
								
								
									<div class="ewf-ui-background-setting ewf-ui-hlp-property">
										<div class="fixed">
											<span>'.__('Background color', EWF_SETUP_THEME_DOMAIN).'</span>
											<input class="active ewf-ui-input-background-color" data-value="'.$background_properties['background-color'].'" data-property="background-color" type="text" value="'.$background_properties['background-color'].'" />
										</div>
									</div>
									
									<div class="ewf-ui-background-separator"></div>
									
									<div class="ewf-ui-background-image">
										
										<span>'.__('Background image', EWF_SETUP_THEME_DOMAIN).'</span>';
										

										$background_preview_class = 'image-none';
										if (trim($background_properties['background-image']) != null) { $background_preview_class = 'image-selected'; }
																			
										echo '<div class="ewf-ui-background-setting ewf-ui-background-image-property ewf-ui-hlp-property '.$background_preview_class.'">
												<div class="ewf-ui-background-image-preview active fixed" data-value="'.$background_properties['background-image'].'" >
													<div class="no-image"></div>
													<img src="'.$background_properties['background-image-preview'].'" alt="" />
													
													<div class="image-patterns">
														<ul class="ewf-ui-background-presets fixed">';
														
															foreach($default_patterns as $index => $item_pattern){
																echo '<li data-preview="'.$default_patterns_url.'preview-'.$item_pattern.'" data-value="'.$default_patterns_url.$item_pattern.'" ><img src="'.$default_patterns_url.'thumb-'.$item_pattern.'"></li>';
															}
															
												   echo '</ul>
													</div>
												</div>
												
												<a class="button button-primary button-large ewf-ui-background-image-upload" href="#">'.__('Upload image', EWF_SETUP_THEME_DOMAIN).'</a>
												<a class="button button-primary button-large ewf-ui-background-image-remove" href="#">'.__('Remove image', EWF_SETUP_THEME_DOMAIN).'</a>
												<a class="button button-primary button-large ewf-ui-background-image-pattern" href="#">'.__('Choose pattern', EWF_SETUP_THEME_DOMAIN).'</a>
												<a class="button button-primary button-large ewf-ui-background-image-cancel" href="#">'.__('Cancel', EWF_SETUP_THEME_DOMAIN).'</a>
												
												<input class="ewf-ui-input-background-image" data-property="background-image" type="hidden" value="'.$background_properties['background-image'].'" />
											</div>
											
											
											
											<div class="ewf-ui-background-setting ewf-ui-background-image-preview-property ewf-ui-hlp-property">
												<div class="active"  data-value="'.$background_properties['background-image-preview'].'" ></div>
												<input class="ewf-ui-input-background-image-preview" data-property="background-image-preview" type="hidden" value="'.$background_properties['background-image-preview'].'" />
											</div>
										
										<div class="ewf-ui-background-separator"></div>
										
										<div class="ewf-ui-background-setting ewf-ui-hlp-property">
											<div class="fixed">
												<span>'.__('Background repeat', EWF_SETUP_THEME_DOMAIN).'</span>';
												
												$background_repeat = array('repeat-all'=>null, 'repeat-x'=>null, 'repeat-y'=>null, 'no-repeat'=> null);
												$background_repeat[$background_properties['background-repeat']] = ' active';
												
										   echo '<ul class="fixed">
													<li title="" class="ewf-tooltip ewf-ui-icon-bg-repeatall'.$background_repeat['repeat-all'].'" data-value="repeat-all"></li>
													<li title="'.__('Repeat Horizontal', EWF_SETUP_THEME_DOMAIN).'" class="ewf-tooltip ewf-ui-icon-bg-repeatx'.$background_repeat['repeat-x'].'" data-value="repeat-x"></li>
													<li title="'.__('Repeat Vertical', EWF_SETUP_THEME_DOMAIN).'" class="ewf-tooltip ewf-ui-icon-bg-repeaty'.$background_repeat['repeat-y'].'" data-value="repeat-y"></li>
													<li title="'.__('No Repeat', EWF_SETUP_THEME_DOMAIN).'" class="ewf-tooltip ewf-ui-icon-bg-norepeat'.$background_repeat['no-repeat'].'" data-value="no-repeat"></li>
												</ul>
												
												<input class="ewf-ui-input-background-repeat" data-property="background-repeat" type="hidden" value="'.$background_properties['background-repeat'].'" />
											</div>
										</div>
										
										
										<div class="ewf-ui-background-separator"></div>
										
										
										<div class="ewf-ui-background-setting ewf-ui-hlp-property">
											<div class="fixed">
												<span>'.__('Background position', EWF_SETUP_THEME_DOMAIN).'</span>';
												
												$background_position = array('right top'=>null, 'center top'=>null, 'left top'=>null, 'right center'=>null, 'center center'=>null, 'left center'=>null, 'left bottom'=>null, 'center bottom'=>null, 'right bottom'=>null);
												$background_position[$background_properties['background-position']] = ' active';
												
										   echo '<ul class="background-position fixed">
													<li title="'.__('Align Right Top', EWF_SETUP_THEME_DOMAIN).'" class="ewf-tooltip ewf-ui-icon-bg-pos-rt'.$background_position['right top'].'" data-value="right top"></li>
													<li title="'.__('Align Center Top', EWF_SETUP_THEME_DOMAIN).'" class="ewf-tooltip ewf-ui-icon-bg-pos-ct'.$background_position['center top'].'" data-value="center top"></li>
													<li title="'.__('Align Left Top', EWF_SETUP_THEME_DOMAIN).'" class="ewf-tooltip ewf-ui-icon-bg-pos-lt'.$background_position['left top'].'" data-value="left top"></li>
													<li title="'.__('Align Right Center', EWF_SETUP_THEME_DOMAIN).'" class="ewf-tooltip ewf-ui-icon-bg-pos-rc'.$background_position['right center'].'" data-value="right center"></li>
													<li title="'.__('Align Center Center', EWF_SETUP_THEME_DOMAIN).'" class="ewf-tooltip ewf-ui-icon-bg-pos-cc'.$background_position['center center'].'" data-value="center center"></li>
													<li title="'.__('Align Left Center', EWF_SETUP_THEME_DOMAIN).'" class="ewf-tooltip ewf-ui-icon-bg-pos-lc'.$background_position['left center'].'" data-value="left center"></li>
													<li title="'.__('Align Right Bottom', EWF_SETUP_THEME_DOMAIN).'" class="ewf-tooltip ewf-ui-icon-bg-pos-rb'.$background_position['right bottom'].'" data-value="right bottom"></li>
													<li title="'.__('Align Center Bottom', EWF_SETUP_THEME_DOMAIN).'" class="ewf-tooltip ewf-ui-icon-bg-pos-cb'.$background_position['center bottom'].'" data-value="center bottom"></li>
													<li title="'.__('Align Left Bottom', EWF_SETUP_THEME_DOMAIN).'" class="ewf-tooltip ewf-ui-icon-bg-pos-lb'.$background_position['left bottom'].'" data-value="left bottom"></li>
												</ul>
												
												<input class="ewf-ui-input-background-position" data-property="background-position" type="hidden" value="'.$background_properties['background-position'].'" />
											</div>
										</div>
										
										
										<div class="ewf-ui-background-separator"></div>
										
										
										<div class="ewf-ui-background-setting ewf-ui-hlp-property">
											<div class="fixed">
												<span>'.__('Background attachment', EWF_SETUP_THEME_DOMAIN).'</span>
												
												<ul class="fixed">';

													$background_attachment = array('fixed' => null, 'scroll' => null);
													$background_attachment[$background_properties['background-attachment']] = ' active';
													
													echo '<li title="'.__('Background Fixed', EWF_SETUP_THEME_DOMAIN).'" class="ewf-tooltip ewf-ui-icon-bg-attach-fixed'.$background_attachment['fixed'].'" data-value="fixed"></li>';
													echo '<li title="'.__('Background Scroll', EWF_SETUP_THEME_DOMAIN).'" class="ewf-tooltip ewf-ui-icon-bg-attach-scroll'.$background_attachment['scroll'].'" data-value="scroll"></li>';
													
										   echo '</ul>
												
												<input class="ewf-ui-input-background-attachment" data-property="background-attachment" type="hidden" value="'.$background_properties['background-attachment'].'" />
											</div>
										</div>
										
										
										<div class="ewf-ui-background-separator"></div>
										
										
										<div class="ewf-ui-background-setting ewf-ui-hlp-property">
											<div class="fixed">
												<span>'.__('Background stretch & fit', EWF_SETUP_THEME_DOMAIN).'</span>
												<div class="toggle active" data-value="'.$background_properties['background-stretch'].'" ></div>
												
												<input class="ewf-ui-input-background-stretch" data-property="background-stretch" type="hidden" value="'.$background_properties['background-stretch'].'" />
											</div>
										</div>
										
									</div>';
									
								
								#	<div class="ewf-ui-image-wrapper'.$ewf_ui_image_class.'"><div></div><img src="'.get_option($value['id'], $value['std']).'" class="ewf-ui-image-preview" height="'.$value['image-height'].'" ></div>
								#	<a href="#" class="button button-primary button-large ewf-ui-image-upload">'.__('Upload Image', EWF_SETUP_THEME_DOMAIN).'</a> 
								#	<input class="ewf-ui-input-image" name="'.$value['id'].'" id="'.$value['id'].'" type="text" value="'.$textVal.'" />							
									
									
								echo '<textarea class="ewf-ui-input-background" style="width:394px;height:200px;" name="'.$value['id'].'" id="'.$value['id'].'" type="text" >'.$background_data_raw.'</textarea>
									
								</div>
								
								
							</div>
						
							<div class="ewf-disabled"></div>
						  </div>';
					break;				
					
					
				case 'ewf-ui-image':
					$textVal = '';
					if ( get_option( $value['id'] ) != "") {  
						$textVal = stripslashes(get_option( $value['id'] ));  
						$ewf_ui_image_class = ' active';
					} else {  
						$textVal = $value['std']; 
					
					}
					
					echo '<div class="ewf-ui ewf-ui-image fixed">
							<div class="ewf-col-description">
								<h4>'.$value['section-title'].'</h4>
								<span>'.$value['section-description'].'</span>
							</div>
							<div class="ewf-col-action">
								<div class="ewf-ui-control-image" data-image-size="'.$value['image-size'].'">
									<div class="ewf-ui-image-wrapper'.$ewf_ui_image_class.'"><div></div><img src="'.get_option($value['id'], $value['std']).'" class="ewf-ui-image-preview" height="'.$value['image-height'].'" ></div>
									<a href="#" class="button button-primary button-large ewf-ui-image-upload">'.__('Change Image', EWF_SETUP_THEME_DOMAIN).'</a> 
								</div>
								
								<input class="ewf-ui-input-image" name="'.$value['id'].'" id="'.$value['id'].'" type="text" value="'.$textVal.'" />							
							</div>
						
							<div class="ewf-disabled"></div>
						  </div>';
					break;
					
					
				case 'ewf-ui-columns':			
				
					$columns_size = get_option( $value['id'], $value['std']);
					$columns_number = count(explode(',',$columns_size));				
					$columns_class = array( '1'=>null, '2'=>null, '3'=>null, '4'=>null );
					$columns_class[$columns_number] = ' active';
					
					$group_class = null;
					if (array_key_exists('group', $value)){ 
						$group_class = ' group-'.$value['group'];
					}
					
					echo '<div class="ewf-ui ewf-ui-columns'.$group_class.' fixed">
							<div class="ewf-col-description">
								<h4>'.$value['section-title'].'</h4>
								<span>'.$value['section-description'].'</span>
							</div>
							<div class="ewf-col-action">
							
								<div class="ewf-ui-control-columns expanded" data-columns="'.$columns_number.'">';
								
									#	Tabs section
									#
									echo '<div class="ewf-ui-columns-tabs">';
										echo '<div class="ewf-ui-columns-tab-columns active" data-related="ewf-ui-columns-setcol-wrapper"><span>'.$columns_number.'</span> '.__('Columns', EWF_SETUP_THEME_DOMAIN).'</div>';
										echo '<div class="ewf-ui-columns-tab-editor" data-related="ewf-ui-columns-editor-wrapper">'.__('Edit Size', EWF_SETUP_THEME_DOMAIN).'</div>';
									echo '</div>';
									
									
									#	Tab - Set columns
									#									
									echo '<div class="ewf-ui-columns-setcol-wrapper ewf-ui-columns-tab-content active">';
										echo '<span>'.__('Layout', EWF_SETUP_THEME_DOMAIN).'</span>';
										
										echo '<ul class="ewf-ui-controls-setnumbers ewf-ui-columns-tab-content">';
											echo '<li><a class="ft-col1'.$columns_class[1].'" data-columns="1" data-size="12" href="#"></a></li>';
											echo '<li><a class="ft-col2'.$columns_class[2].'" data-columns="2" data-size="6,6" href="#"></a></li>';
											echo '<li><a class="ft-col3'.$columns_class[3].'" data-columns="3" data-size="4,4,4" href="#"></a></li>';
											echo '<li><a class="ft-col4'.$columns_class[4].'" data-columns="4" data-size="3,3,3,3" href="#"></a></li>';
										echo '</ul>';
									echo '</div>';
									
									
									#	Tab - Edit columns
									#
									echo '<div class="ewf-ui-columns-editor-wrapper ewf-ui-columns-tab-content">';
										echo '<p>'.__('Press the plus button to increase column size', EWF_SETUP_THEME_DOMAIN).'</p>';
										echo '<div class="ewf-ui-column-editor"></div>';
									echo '</div>';
									
									echo '<input type="hidden" autocomplete="off" id="'.$value['id'].'" name="'.$value['id'].'" class="ewf-ui-input-columns" value="'.$columns_size.'" readonly />'; 							
							
						  echo '</div> <!-- .ewf-ui-control-columns -->
						  
							</div>
							
							<div class="ewf-disabled"></div>
						</div>';
					break;
				
				
				
				case 'ewf-ui-slider':
					$textVal = '';
					if ( get_option( $value['id'] ) != "") {  $textVal = stripslashes(get_option( $value['id'] ));  } else {  $textVal = $value['std']; }
					
					$ui_slider_min = 0;
					$ui_slider_max = 100;
					$ui_slider_step = 1;
					
					if (array_key_exists('min', $value)){  $ui_slider_min = intval($value['min']);  }
					if (array_key_exists('max', $value)){  $ui_slider_max = intval($value['max']);  }
					if (array_key_exists('step', $value)){  $ui_slider_step = intval($value['step']);  }

					$group_class = null;
					if (array_key_exists('group', $value)){ 
						$group_class = ' group-'.$value['group'];
					}
					
				   echo '<div class="ewf-ui ewf-ui-slider'.$group_class.' fixed" >
							<div class="ewf-col-description">
								<h4>'.$value['section-title'].'</h4>
								<span>'.$value['section-description'].'</span>
							</div>
							<div class="ewf-col-action">
								<input class="ewf-ui-input-slider" name="'.$value['id'].'" id="'.$value['id'].'" type="text" value="'.$textVal.'" readonly/>							
								<div class="ewf-ui-control-slider" data-step="'.$ui_slider_step.'" data-max="'.$ui_slider_max.'" data-min="'.$ui_slider_min.'" ></div>
							</div>
							
							<div class="ewf-disabled"></div>
						</div>';
					break;
				
				
				
				case 'ewf-ui-toggle':
					$toggle_value = get_option($value['id'], $value['std']);
					$toggle_class = null;
					$toggle_dependency = null;
					$group_class = null;
					
					if (array_key_exists('group', $value)){ 
						$group_class = ' group-'.$value['group'];
					}
					
					if (array_key_exists('dependency', $value) && $value['dependency']){
						$toggle_dependency = 'data-dependency="'.$value['dependency'].'"';
					}
					
					if ($toggle_value){
						if ($toggle_value == 1){ $toggle_value = 'true'; }
						
						$toggle_class = ' data-enabled="'.$toggle_value.'"';
					}
					
				   echo '<div class="ewf-ui ewf-ui-toggle '.$group_class.' fixed"'.$toggle_dependency.'>
							<div class="ewf-col-description">
								<h4>'.$value['section-title'].'</h4>
								<span>'.$value['section-description'].'</span>
							</div>
							<div class="ewf-col-action">
								<div class="ewf-ui-control-toggle"'.$toggle_class.'>
									<div class="toggle"></div>
									<input class="ewf-ui-input-toggle" name="'.$value['id'].'" id="'.$value['id'].'" type="hidden" value="'.$toggle_value.'" />
								</div>
							</div>
							
							<div class="ewf-disabled"></div>
						</div>';
					break;

					
				case 'ewf-ui-font':
					$group_class = null;
					
					$font_data_row = stripslashes(get_option($value['id'], $value['std']));
					$font_data = json_decode($font_data_row,true);
					$font_properties = array(); 
					
					
					foreach($font_data as $key => $item_properties){
						$font_properties[$item_properties['name']] = $item_properties['value'];
					}
					
					$font_properties['font-family'] = ucwords($font_properties['font-family']);
					$font_variants = ewf_admin_ui_font_getVariants($font_properties['font-family']);
					$font_variants = $font_variants['variants'];
					
					// $font_properties['font-italic-class'] = null;
					// if ($font_properties['font-italic'] == 'true'){
						// $font_properties['font-italic-class'] = 'ewf-state-active';
					// }
					
					if ($font_properties['font-weight'] == null){
						$font_properties['font-weight'] = 'regular';
					}
					
					
					// DEBUG
					// echo '<pre>';
						// echo '<br/>Value:';
						// print_r($value);
						
						// echo '<br/>Data:';
						// print_r($font_data);
						
						// echo '<br/>Properties:';
						// print_r($font_properties);
						
						// echo '<br/>Font Family:'.$font_properties['font-family'];

						// echo '<br/>Variants:';
						// print_r($font_variants);
					// echo '</pre>';
					
					
					if (array_key_exists('group', $value)){ 
						$group_class = ' group-'.$value['group'];
					}
					
					echo '<div class="ewf-ui ewf-ui-font'.$group_class.' fixed">
							<div class="ewf-col-description">
								<h4>'.$value['section-title'].'</h4>
								<span>'.$value['section-description'].'</span>
							</div>
							<div class="ewf-col-action">
								
								<div class="ewf-ui-control-font">
									<div class="ewf-ui-font-preview">
										<h3>'.__('Title Sample', EWF_SETUP_THEME_DOMAIN).'</h3>
										<p>'.__('paragraph sample here', EWF_SETUP_THEME_DOMAIN).'</p>
									</div>
									<div class="ewf-font-ui-options ewf-ui-hlp-property-set">
									
											<div class="ewf-font-ui-selector ewf-ui-hlp-property">
												<span class="ewf-ui-font-current active" data-value="'.$font_properties['font-family'].'">'.$font_properties['font-family'].'</span> 
												
												<div class="ewf-ui-font-search hidden">
													<div class="ewf-ui-font-dropdown">
															<input class="ewf-ui-input-font-search" type="text" value="" />
														<ul>'.ewf_admin_ui_font_generateList().'</ul>
													</div>
												</div>
												
												<input class="ewf-ui-input-font-family" data-property="font-family" type="hidden" value="" />
											</div>
											
											<div class="ewf-ui-font-variant ewf-ui-hlp-property">
												<div class="ewf-ui-cp-dropdown">
													<span class="ewf-cp-dropdown-current active" data-value="'.$font_properties['font-weight'].'">'.$font_properties['font-weight'].'</span> 
													<ul>';

														if (is_array($font_variants)){
															foreach($font_variants as $key => $weight){
																echo '<li data-value="'.$weight.'">'.$weight.'</li>';
															}
														}
														
													echo '</ul>
												</div> 
												
												<input class="ewf-ui-input-font-variant" data-property="font-weight" type="hidden" value="" />
											</div>';
											
											
											
											// <div class="ewf-ui-font-italic ewf-ui-hlp-property">
												// <div class="ewf-ui-cp-button-toggle '.$font_properties['font-italic-class'].' -ewf-state-disabled active" data-value="'.$font_properties['font-italic'].'"><span></span></div>
												
												// <input class="ewf-ui-input-font-italic" data-property="font-italic" type="hidden" value="" />
											// </div>
											
											
											echo '
											<textarea class="ewf-ui-input-font-set ewf-ui-hlp-property-set-input" name="'.$value['id'].'" id="'.$value['id'].'" >'.$font_data_row.'</textarea>
									</div>									
									
								</div>
								
							</div>
							
							<div class="ewf-disabled"></div>
						</div>';
					break;
					
					
				
				case 'ewf-ui-color':
					$color_value = get_option($value['id'], $value['std']);
					$group_class = null;
					
					if (array_key_exists('group', $value)){ 
						$group_class = ' group-'.$value['group'];
					}
					
					echo '<div class="ewf-ui ewf-ui-color'.$group_class.' fixed">
							<div class="ewf-col-description">
								<h4>'.$value['section-title'].'</h4>
								<span>'.$value['section-description'].'</span>
							</div>
							<div class="ewf-col-action">
								<input class="ewf-ui-input-color" name="'.$value['id'].'" id="'.$value['id'].'" type="'.$value['type'].'" value="'.$color_value.'"/>
							</div>
							
							<div class="ewf-disabled"></div>
						</div>';
					break;

					
				case 'textarea':
					$group_class = null;
					
					if (array_key_exists('group', $value)){ 
						$group_class = ' group-'.$value['group'];
					}
					
					echo '<div class="ewf-ui ewf-ui-textarea'.$group_class.' fixed">
							<div class="ewf-col-description">
								<h4>'.$value['section-title'].'</h4>
								<span>'.$value['section-description'].'</span>
							</div>
							<div class="ewf-col-action">
							<textarea name="'.$value['id'].'" type="'.$value['type'].'" cols="" rows="6">';
								if ( get_option( $value['id'] ) != "") { 
									echo stripslashes(get_option($value['id']) ); 
								} else { 
									echo $value['std']; 
								}
				 	  echo '</textarea>
						   </div>
						   
						   <div class="ewf-disabled"></div>
						</div>';
					break;

					
				// case 'select':
					// echo '<div class="bordered clfixed">
							// <div class="col-220">
							// <h4>'.$value['section-title'].'</h4>
							// <p><em>'.$value['section-description'].'</em></p>
						  // </div>';
						
					// echo '<div class="col-340 last">';
						// echo '<select name="'.$value['id'].'" id="'.$value['id'].'">';
							// foreach ($value['options'] as $key => $option) {
								// if ( get_option( $value['id'] ) == $option) { 
									// echo '<option selected="selected" >'.$option.'</option>';
								// }else{
									// echo '<option >'.$option.'</option>';
								// }
							// }
						// echo '</select>';
					// echo '</div></div>';
					// break;

				case 'text':
					$textVal = '';
					$group_class = null;
					
					if (array_key_exists('group', $value)){ 
						$group_class = ' group-'.$value['group'];
					}
					
					if ( get_option( $value['id'] ) != "") {  $textVal = stripslashes(get_option( $value['id'] ));  } else {  $textVal = $value['std']; }
					
					echo '<div class="ewf-ui ewf-ui-text'.$group_class.' fixed">
							<div class="ewf-col-description">
								<h4>'.$value['section-title'].'</h4>
								<span>'.$value['section-description'].'</span>
							</div>
							<div class="ewf-col-action">
								<input name="'.$value['id'].'" id="'.$value['id'].'" type="'.$value['type'].'" value="'.$textVal.'"/>
							</div>
							
							<div class="ewf-disabled"></div>
						  </div>';
					break;
					
					
				case 'ewf-ui-select':
					$select_value = get_option($value['id'], $value['std']);
					$group_class = null;
					
					if (array_key_exists('group', $value)){ 
						$group_class = ' group-'.$value['group'];
					}
					
					echo '<div class="ewf-ui ewf-ui-select'.$group_class.' fixed">
							<div class="ewf-col-description">
								<h4>'.$value['section-title'].'</h4>
								<span>'.$value['section-description'].'</span>
							</div>
							<div class="ewf-col-action">';
								echo '<select name="'.$value['id'].'" id="'.$value['id'].'">';
									foreach ($value['options'] as $key => $option) {
										if ($option['id'] == $select_value){ 
											echo '<option value="'.$option['id'].'" selected="selected" >'.$option['title'].'</option>';
										}else{
											echo '<option value="'.$option['id'].'" >'.$option['title'].'</option>';
										}
									}
								echo '</select>';
							echo '</div>
							
							<div class="ewf-disabled"></div>
						</div>';
					break;
					


			}
		}
	
		
		return ob_get_clean();
	}
	
	
	function ewf_admin_options_update() {
		global $ewf_admin_options;
		
		$currentSession = $ewf_admin_options;
		
		if ( array_key_exists('page', $_GET) && $_GET['page'] == EWF_SETUP_PAGE) {
			if ( array_key_exists('save', $_REQUEST) ) {		
			
				foreach ($ewf_admin_options as $value) {
				
					if (($value['type']=='textarea' || $value['type']=='text' || $value['type']=='ewf-ui-options' || $value['type']=='ewf-ui-select' || $value['type']=='ewf-ui-font' || $value['type']=='ewf-ui-background' || $value['type']=='ewf-ui-columns' || $value['type']=='ewf-ui-toggle' || $value['type']=='ewf-ui-color' || $value['type']=='ewf-ui-slider' || $value['type']=='ewf-ui-image' || $value['type']=='color' || $value['type']=='upload' || $value['type']=='input-skins' || $value['type']=='checkbox' || $value['type']=='select') && array_key_exists($value['id'], $_REQUEST) ) {
						if ($value['type']=='checkbox' && $_REQUEST[ $value['id'] ]=='on') { $_REQUEST[ $value['id'] ]='true'; }
						 
						 update_option( $value['id'], $_REQUEST[ $value['id'] ] );
						 // echo '<br/>Update: '.$value['id'].' - ['.update_option( $value['id'], $_REQUEST[ $value['id'] ] ).']['.$_REQUEST[ $value['id'] ].']'; 					
						
					}else{
						if ($value['type']=='checkbox' ){
							update_option( $value['id'], 'false' ); 
						}
					}
				}
				
			} else if( array_key_exists('action', $_REQUEST) && ($_REQUEST['action']=='reset')) {
				
				foreach ($ewf_admin_options as $value) {
					if (($value['type']=='textarea' || $value['type']=='upload'|| $value['type']=='ewf-ui-select' || $value['type']=='ewf-ui-options' || $value['type']=='ewf-ui-background' || $value['type']=='ewf-ui-font' || $value['type']=='ewf-ui-toggle' ||  $value['type']=='ewf-ui-color' ||  $value['type']=='ewf-ui-slider' ||  $value['type']=='ewf-ui-columns' ||  $value['type']=='ewf-ui-image' || $value['type']=='text' || $value['type']=='checkbox' || $value['type']=='select' || $value['type']=='color')) {
						update_option( $value['id'], $value['std'] ); 
						
						// echo '<br/>Updated: '.$value['id'].' - '.$value['std'];
					}
				} 				
				
				
				//	Force ModLayout to reset sidebars
				//
				do_action('ewf_modLayout_resetSidebars');
				
				
				header("Location: themes.php?page=functions.php&action=defaults"); 
				
			}else if(array_key_exists('install', $_REQUEST)){
				foreach ($ewf_admin_options as $value) {
					if (($value['type']=='textarea' || $value['type']=='text' || $value['type']=='ewf-ui-select' || $value['type']=='ewf-ui-options' || $value['type']=='ewf-ui-background' ||  $value['type']=='checkbox'  ||  $value['type']=='ewf-ui-font' ||  $value['type']=='ewf-ui-toggle' ||  $value['type']=='ewf-ui-color' ||  $value['type']=='ewf-ui-slider' ||  $value['type']=='ewf-ui-columns' ||  $value['type']=='ewf-ui-image' || $value['type']=='select' || $value['type']=='color' )) {
						update_option( $value['id'], $value['std'] ); 
					}
				}	
				
				
				//	Force ModLayout to reset sidebars
				//
				do_action('ewf_modLayout_resetSidebars');
			}
		} 

		
		$icon_path = null;		
		add_menu_page('EWF Admin'	, __('Theme Options', EWF_SETUP_THEME_DOMAIN)	, 'edit_theme_options' , EWF_SETUP_PAGE	, 'ewf_admin_options'	, $icon_path, 90);
	}
	
	
	function ewf_admin_theme_install(){
		global $ewf_admin_options;
		
		foreach ($ewf_admin_options as $value) {
			if (($value['type']=='textarea' || $value['type']=='text' || $value['type']=='ewf-ui-options' || $value['type']=='ewf-ui-background' ||  $value['type']=='checkbox'  ||  $value['type']=='ewf-ui-font' ||  $value['type']=='ewf-ui-toggle' ||  $value['type']=='ewf-ui-color' ||  $value['type']=='ewf-ui-slider' ||  $value['type']=='ewf-ui-columns' ||  $value['type']=='ewf-ui-image' || $value['type']=='select' || $value['type']=='color' )) {
				update_option( $value['id'], $value['std'] ); 
			}
		}	
		
		
		//	Force ModLayout to reset sidebars
		//
		do_action('ewf_modLayout_resetSidebars');
	
	}
	
	function ewf_admin_options() {
		global $ewf_admin_options;
		global $_wp_admin_css_colors;
		
		$color_scheme = get_user_option( 'admin_color' ); 
		
			
		$theme_colors = $_wp_admin_css_colors[$color_scheme]->colors;
		
		echo '<style class="ewf-admin-dynamic-style">';
			echo '#ewf-admin-header { background-color:'.$theme_colors[1].'; }';
			echo '#ewf-admin-sidebar li a:hover { color:'.$theme_colors[3].'; }';
			echo '#ewf-admin-sidebar li.active a { color:'.$theme_colors[3].'; }';
			echo '.ewf-ui.ewf-ui-slider .ui-slider-range { background:'.$theme_colors[3].'; }';
			echo '.ewf-ui-background-setting .ewf-ui-background-presets .active { border-color:'.$theme_colors[3].'; }';
		echo '</style>';
		
		// foreach($_wp_admin_css_colors[$color_scheme]->colors as $color){
			// echo '<div style="background-color:'.$color.';width:20px;height:20px;"></div>';
		// }
			
	?>
		
		<div class="ewf-admin-options">
		<form method="post" autocomplete="off">
		

			<div class="ewf-admin-options-wrapper fixed">

				<div id="ewf-admin-header">
					<h3><?php echo EWF_SETUP_THEME_NAME ?></h3>
					<p>Version <?php echo EWF_SETUP_THEME_VERSION ?></p>

					<div class="header-settings">
						<input class="button button-primary button-large" name="save" type="submit" style="cursor:pointer" value="<?php echo __('Save changes', EWF_SETUP_THEME_DOMAIN);  ?>" />
						<input type="hidden" class="ewf-admin-action" name="action" value="save" />
						&nbsp;
						<input class="button button-primary button-large ewf-admin-option-restore" name="reset" type="submit" style="cursor:pointer" value="<?php echo __('Restore Defaults', EWF_SETUP_THEME_DOMAIN);  ?>" />
					</div>
				</div>	
				
				
				<div class="fixed"> 
				<?php
				
					if ( array_key_exists('save', $_REQUEST)){ 
						echo '<div class="ewf-admin-notice">'.__('The settings have been successfully saved!', EWF_SETUP_THEME_DOMAIN).'</div>';
					}
						
					if ( array_key_exists('action', $_REQUEST) && ($_REQUEST['action'] == 'defaults')){ 
						echo '<div class="ewf-admin-notice">'.__('Default settings have been restored!', EWF_SETUP_THEME_DOMAIN).'</div>';
					}

					if ( array_key_exists('install', $_REQUEST)){ 
						echo '<div class="ewf-admin-notice">'.__('The theme settings have been restored to default, install triggered!', EWF_SETUP_THEME_DOMAIN).'</div>';
					}

				?>
				</div>
				
				
				<div class="ewf-admin-content-wrapper fixed">
					<div id="ewf-admin-sidebar">					
						<?php
						
						
							$panel_active = get_option(EWF_SETUP_THNAME."_admin_tab_active", 'ewf-panel-general');
							
							$panel_array = array( 
								'ewf-panel-general' 		=> array('icon' => 'ewf-icon-general'		, 'class'=> null 	, 'title' => __('General', EWF_SETUP_THEME_DOMAIN)),
								'ewf-panel-typography'		=> array('icon' => 'ewf-icon-typography'	, 'class'=> null 	, 'title' => __('Typography', EWF_SETUP_THEME_DOMAIN)),
								'ewf-panel-colors'			=> array('icon' => 'ewf-icon-colors'		, 'class'=> null 	, 'title' => __('Colors', EWF_SETUP_THEME_DOMAIN)),
								'ewf-panel-header'			=> array('icon' => 'ewf-icon-header'		, 'class'=> null 	, 'title' => __('Header', EWF_SETUP_THEME_DOMAIN)),
								'ewf-panel-footer'			=> array('icon' => 'ewf-icon-footer'		, 'class'=> null 	, 'title' => __('Footer', EWF_SETUP_THEME_DOMAIN)),
								// 'ewf-panel-social'			=> array('icon' => 'ewf-icon-social'		, 'class'=> null 	, 'title' => __('Social Profiles', EWF_SETUP_THEME_DOMAIN)),
							 	// 'ewf-panel-import-export'	=> array('icon' => 'ewf-icon-export'		, 'class'=> null 	, 'title' => __('Import / Export', EWF_SETUP_THEME_DOMAIN)),
							);
						
							$panel_array[$panel_active]['class'] = "active";
							
							
							echo '<ul class="ewf-admin-vertical-nav">';
							
							foreach($panel_array as $panel_index => $panel_item){
								$data_class = null;
								if ($panel_item['class']){
									$data_class = 'class="'.$panel_item['class'].'" ';
								}
								
								echo '<li '.$data_class.'data-panel="'.$panel_index.'"><a class="'.$panel_item['icon'].'" href="#">'.$panel_item['title'].'</a></li>';
							
							}
							
							echo '</ul>';
							
						?>
					</div>	<!-- .ewf-admin-sidebar -->
					
					<div id="ewf-admin-content">
						<?php  echo ewf_admin_renderOptions($ewf_admin_options);  ?>
					</div>
					
				</div>	<!-- .ewf-admin-content-wrapper	-->
				
				
			</div>	<!--  .ewf-admin-options-wrapper  -->

		</form>	
		</div>	<!--  .ewf-admin-options -->
		


	<?php
		
	}

	
	function ewf_append_analytics (){
		$analytics_code = stripslashes_deep(get_option(EWF_SETUP_THNAME."_include_analytics",null));
		
		if ( $analytics_code != null){ 
			echo $analytics_code;
		}
	}
	
	function ewf_append_css (){
		$css_code = stripslashes_deep(get_option(EWF_SETUP_THNAME."_include_css",null));
		
		if ( $css_code != null){ 
			echo '<style>';
				echo $css_code;
			echo '</style>';
		}
	}
	
	
	// function ewf_current_skin(){
		// global $_ewf_skins;
		
		// $css_title = get_option( EWF_SETUP_THNAME."_theme_skin", 'Default' );
		// $css_file = $_ewf_skins['full'][$css_title];
		
		// return $css_file;
	// }
	
	
	function ewf_load_site_pages($exclude = null){
		$pages_list = get_pages();
		$pages_return = array(); 
		
		$pages_return[] = array('id' => 0, 'title' => __('Select page', EWF_SETUP_THEME_DOMAIN));
		
		if (is_array($exclude)){
			foreach($pages_list as $current_page){
				if (!array_key_exists($current_page->post_title, $exclude)){
					$pages_return[] = $current_page->post_title;
				}
			}
		}else{
			foreach($pages_list as $current_page){
				$pages_return[] = array( 'id' => $current_page->ID, 'title'=> $current_page->post_title );
			} 
		}
		
		return $pages_return;
	}
	
	function ewf_load_skins(){
		$themeSkins_full = array();
		$themeSkins_opt = array();
		
		$dir = opendir($themePath);
		while ($dir && ($file = readdir($dir)) !== false) {
			if (strtolower(pathinfo($file, PATHINFO_EXTENSION))== "css"){
				$skinName = str_replace(array('-', '_', '#'), ' ', pathinfo($file, PATHINFO_FILENAME));
				$skinName = ucwords(strtolower($skinName));
				
				$themeSkins_full[$skinName] = $file;
				$themeSkins_opt[] = $skinName;
		  }
		}
		
		foreach($themeSkins_full as $key=>$value){
			apply_filters("debug", "Skin: $key - ".$value);
		} 
		
		return array('full'=>$themeSkins_full, 'options'=>$themeSkins_opt);
	}
	
	function ewf_admin_load_includes() {
	   wp_enqueue_script('media-upload');
	   
	   wp_enqueue_script('jquery-ui-slider');
	   wp_enqueue_style('jquery-ui-slider'); 
	   // wp_enqueue_style('jquery-ui-tooltip'); 
	   
		wp_enqueue_style('ewf-admin-ui-css', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/themes/ui-lightness/jquery-ui.css');
				
	   
	   wp_enqueue_script('thickbox');
	   wp_enqueue_style('thickbox'); 

	   wp_enqueue_media(); 
	   
	   wp_enqueue_script ('wp-color-picker');
	   wp_enqueue_style ('wp-color-picker');
	}
	
	function ewf_hlp_font_googleurl($font){
		$font = ucwords($font);
		$_body_font_variants = ewf_admin_ui_font_getVariants($font);
		
		$fnt = str_replace(' ', '+', $font);
		$url = 'https://fonts.googleapis.com/css?family='.$fnt.':';
		$var = null;
		
		if (array_key_exists('variants', $_body_font_variants)){
			foreach($_body_font_variants['variants'] as $key => $variant){
				if ($var){
					$var .= ','.$variant;
				}else{
					$var .= $variant;
				}
			}
		}
		
		#	<link href="//fonts.googleapis.com/css?family=+:300,300italic,regular,italic,600,600italic,700,700italic,800,800italic" rel="stylesheet" type="text/css" >
		#	<link href='//fonts.googleapis.com/css?family=Open+Sans:300italic,600italic,700italic,800italic,400,700,800' rel='stylesheet' type='text/css'>
		
		return $url.$var;
	}
	
	function ewf_hlp_font_decode($admin_option, $properties_show = false){
		$result = array();

		$option_raw = stripslashes(get_option($admin_option, null));
		$options_data = json_decode($option_raw, true);
		$options_prop = array();
		
		

		
		foreach($options_data as $key => $item_properties){
			if (trim($item_properties['value'])){
				$options_prop[$item_properties['name']] = $item_properties['value'];			
			}
		}
		
		
		unset($options_prop['background-image-preview']);
		unset($options_prop['background-stretch']);
		// unset($options_prop['background-stretch']);
		
		// if (array_key_exists('background-image', $options_prop) && $options_prop['background-image'] == null){
			// unset($options_prop['background-stretch']);
		// }
		
		
		// echo '<pre>';
			// print_r($options_prop);
		// echo '</pre>';
		
		
		
		$result_css = null;
		foreach($options_prop as $item_property => $item_value){
			if ($properties_show){
				$result[$item_property] = $item_value;
			}
			
			switch($item_property){
				case 'font-family':
						$result_css .= "\nfont-family:'".$item_value."', Arial, sans-serif;";
					break;
			
				case 'font-weight':
				
					$italic_array = explode('italic', $item_value);
					
					if (count($italic_array) == 2){
						if ($italic_array[0] != null){
							$result_css .= "\nfont-weight:".$item_value.";";
						}

						$result_css .= "\nfont-style:italic;";
					}else{
						$item_value = str_ireplace('regular', '400', $item_value);
						$result_css .= "\nfont-weight:".$item_value.";";
					}
					break;
					
				case 'background-color':
						$result_css .= "\nbackground-color:".$item_value.";";
					break;
					
				case 'background-repeat':
						$result_css .= "\nbackground-repeat:".$item_value.";";
					break;			
					
				case 'background-position':
						$result_css .= "\nbackground-position:".$item_value.";";
					break;
					
				case 'background-attachment':
						$result_css .= "\nbackground-attachment:".$item_value.";";
					break;					
					
				case 'background-image':
						$result_css .= "\nbackground-image:url('".$item_value."');";
					break;					
					
				case 'background-pattern':
						$result_css .= "\nbackground-image:url('".$item_value."');";
					break;		
					
				case 'font-italic':
						$result_css .= "\nfont-style:italic;";
					break;
					
			}
		}
		
		if ($properties_show){
			$result['css'] = $result_css;
		}else{
			$result = $result_css;
		}
		
		return $result;
	}
	
	function ewf_admin_load_dynamicStyles(){

		$colors_accent_01 = get_option(EWF_SETUP_THNAME."_colors_accent_01"					, '#08ab89');
		$colors_accent_02 = get_option(EWF_SETUP_THNAME."_colors_accent_02"					, '#474E5D');
		$colors_accent_02_hover = get_option(EWF_SETUP_THNAME."_colors_accent_02_hover"		, '#8BD99F');
		$colors_accent_03 = get_option(EWF_SETUP_THNAME."_colors_accent_03"					, '#EEE5DD');
		$colors_accent_03_hover = get_option(EWF_SETUP_THNAME."_colors_accent_03_hover"		, '#96E0A9');
		$color_header_top = get_option(EWF_SETUP_THNAME."_color_header_top"					, '#484F5E');
		$color_header_top_border = get_option(EWF_SETUP_THNAME."_color_header_top_border"	, '#62D4D8');
		$color_header_top_font = get_option(EWF_SETUP_THNAME."_color_header_top_font"		, '#FFFFFF');
		$color_content = get_option(EWF_SETUP_THNAME."_color_content"						, '#474D5D');
		$color_footer_top = get_option(EWF_SETUP_THNAME."_color_footer_top"					, '#79849B');
		$color_footer_top_font = get_option(EWF_SETUP_THNAME."_color_footer_top_font"		, '#FFFFFF');
		$color_footer_middle = get_option(EWF_SETUP_THNAME."_color_footer_middle"			, '#484F5E');
		$color_footer_middle_font = get_option(EWF_SETUP_THNAME."_color_footer_middle_font"	, '#D1D1D1');
		$color_footer_bottom = get_option(EWF_SETUP_THNAME."_color_footer_bottom"			, '#303745');
		$color_footer_bottom_font = get_option(EWF_SETUP_THNAME."_color_footer_bottom_font"	, '#D1D1D1');
		
		
		$content_width = get_option(EWF_SETUP_THNAME."_content_width", '1170px');
	
		ob_start();

		?>

			.ewf-boxed-layout #wrap,
			.ewf-boxed-layout #header { max-width: <?php echo $content_width; ?>; }

		
		<?php	if (get_option(EWF_SETUP_THNAME."_colors_custom", "false") == 'true'){  ?>
		
			/*	###	EWF Custom Colors 	
				
				$colors_accent_01 - <?php echo $colors_accent_01."\n"; ?>
				$colors_accent_02 - <?php echo $colors_accent_02."\n"; ?>
				$colors_accent_02_hover - <?php echo $colors_accent_02_hover."\n"; ?>
				$colors_accent_03 - <?php echo $colors_accent_03."\n"; ?>
				$colors_accent_03_hover - <?php echo $colors_accent_03_hover."\n"; ?>
				$color_header_top - <?php echo $color_header_top."\n"; ?>
				$color_header_top_border - <?php echo $color_header_top_border."\n"; ?>
				$color_header_top_font - <?php echo $color_header_top_font."\n"; ?>
				$color_content - <?php echo $color_content."\n"; ?>
				$color_footer_top - <?php echo $color_footer_top."\n"; ?>
				$color_footer_top_font - <?php echo $color_footer_top_font."\n"; ?>
				$color_footer_middle - <?php echo $color_footer_middle."\n"; ?>
				$color_footer_middle_font - <?php echo $color_footer_middle_font."\n"; ?>
				$color_footer_bottom - <?php echo $color_footer_bottom."\n"; ?>
				$color_footer_bottom_font - <?php echo $color_footer_bottom_font."\n"; ?>
			
			
			*/
			
						
			a, 
			a:visited { 
				color: <?php echo $colors_accent_01; ?>; 
			}

			.btn-green-dark {
				background-color: <?php echo $colors_accent_01; ?>;
			}
				
			.headline span {
				border-bottom: 6px solid  <?php echo $colors_accent_01; ?>;
			}

			.headline-2 span {
				border-bottom: 6px solid  <?php echo $colors_accent_01; ?>;
			}

			a.facebook-icon:hover, 
			a.twitter-icon:hover, 
			a.vimeo-icon:hover, 
			a.flickr-icon:hover, 
			a.github-icon:hover, 
			a.googleplus-icon:hover, 
			a.pinterest-icon:hover, 
			a.tumblr-icon:hover, 
			a.linkedin-icon:hover, 
			a.dribble-icon:hover, 
			a.stumbleupon-icon:hover, 
			a.lastfm-icon:hover, 
			a.instagram-icon:hover, 
			a.evernote-icon:hover, 
			a.skype-icon:hover,
			a.paypal-icon:hover, 
			a.soundcloud-icon:hover, 
			a.behance-icon:hover, 
			a.youtube-icon:hover {
				border-color: <?php echo $colors_accent_01; ?>;
				color: <?php echo $colors_accent_01; ?> !important;
			}	

			#footer .widget-title span {
				border-bottom: 2px solid <?php echo $colors_accent_01; ?>;
			}

			.ewf_widget_latest_posts ul li p { 
				color: <?php echo $colors_accent_01; ?>;
			}

			#footer .ewf_widget_latest_posts  p a { color:<?php echo $colors_accent_01; ?>; }

			.ewf_widget_latest_posts ul p span { color: <?php echo $colors_accent_01; ?>; }

			#footer .ewf_widget_social_media a.social-icon:hover i { color: <?php echo $colors_accent_01; ?>; }

			.wpcf7-form input[type="submit"] {
				background-color: <?php echo $colors_accent_01; ?>;
			}	

			.tp-bullets.simplebullets.round .bullet:hover,.tp-bullets.simplebullets.round .bullet.selected {
				background: <?php echo $colors_accent_01; ?>;
			}
			
			.sf-menu li.current, 
			.sf-menu > li.current-menu-parent, 
			.sf-menu > li.current_page_parent, 
			.sf-menu > li.current-menu-item > a {
				background-color: <?php echo $colors_accent_01; ?>;
				border-top: 2px solid <?php echo $colors_accent_01; ?>;
			}	

			.widget_pages ul li:before {
				color:  <?php echo $colors_accent_01; ?>;
			}	
			
			
			.blog-post-preview {
				border-left: 5px solid <?php echo $colors_accent_01; ?>;
			}

			.blog-post-preview .date {
				background-color: <?php echo $colors_accent_01; ?>;
				border-bottom: 10px solid <?php echo $colors_accent_02_hover; ?>;
			}	

			.pagination li a:hover, .pagination li.current a {
				border-color: <?php echo $colors_accent_01; ?>;
				color: <?php echo $colors_accent_01; ?>;
			}

			.icon-box-1 > i,
			.icon-box-2 > i,
			.icon-box-2 span i,
			.icon-box-6 li i,
			.services-list li i {   
				background-color: <?php echo $colors_accent_02; ?>;
			}	

			.icon-box-1:hover i,
			.icon-box-2:hover i,
			.icon-box-6 li:hover i,
			.parallax .icon-box-2 > i,
			.parallax .icon-box-6 li i,
			.box-2,
			.icon-box-3 > i,
			.timeline-2 li i { background-color: <?php echo $colors_accent_02_hover; ?>; }	

			
			.sf-menu li ul li a:hover:before {
				color: <?php echo $colors_accent_01; ?>;
			}
			
			.sf-menu li ul li a:hover:after {
				border-bottom-color: <?php echo $colors_accent_01; ?>;
			}
				
			.sf-menu li ul {
				border-left: 1px solid <?php echo $colors_accent_01; ?>;
			}	
			
			.progress-bar,
			.team-member {
				background-color: <?php echo $colors_accent_03; ?>;
			}

			.progress-bar .progress-bar-outer .progress-bar-inner:after {
				border-bottom: 14px solid <?php echo $colors_accent_03; ?>;
			}

			#header-top .ewf_widget_social_media a.social-icon:hover i { color: <?php echo $colors_accent_03_hover; ?>; }	

			.commentlist .vcard img.avatar {
			border: 2px solid <?php echo $colors_accent_03_hover; ?>;
			}

			.google-map { 
			border-top: 5px solid <?php echo $colors_accent_03_hover; ?>;	
			}

			.btn-green-light:hover { 
				background: <?php echo $colors_accent_02; ?>;
				color: #fff;
			}

			.btn-green-dark:hover { 
				background: <?php echo $colors_accent_02; ?>;
				color: #fff !important;
			}

			.btn-black:hover { 
				background: <?php echo $colors_accent_02; ?>;
				color: #fff !important;
			}
			
			.sf-menu a {
			border-bottom: 1px dotted <?php echo $colors_accent_03_hover; ?>;
			color: #666;			
			}
			
			.blog-post-preview > img {
				border-left: 3px solid <?php echo $colors_accent_02_hover; ?>;
			}

			
			.widget_categories ul li:before,
			.widget_archive ul li:before {
				color: <?php echo $colors_accent_01; ?>;
			}	
			
			.sf-menu li ul li a:before {
			color: <?php echo $colors_accent_03_hover; ?>;
			}
			
			.sf-menu li ul li a:hover:before {
				color: <?php echo $colors_accent_01; ?>;
			}
			.sf-menu li ul li a:hover:after {
				border-bottom-color: <?php echo $colors_accent_01; ?>;
			}

			.sf-menu > li:hover > a, .sf-menu > li.sfHover > a {
				background-color: <?php echo $colors_accent_01; ?>;
				border-top: 2px solid <?php echo $colors_accent_01; ?>;
			}

			.portfolio-item-overlay-actions .portfolio-item-zoom, .portfolio-item-overlay-actions .portfolio-item-link {
				background-color: <?php echo $colors_accent_01; ?>;
			}

			.portfolio-item-overlay-actions .portfolio-item-zoom:hover, .portfolio-item-overlay-actions .portfolio-item-link:hover {
				background-color: <?php echo $colors_accent_02_hover; ?>;
			}

			.team-member:hover { 
			background-color: <?php echo $colors_accent_03_hover; ?>;
			}	

			.social-media a.social-icon {
			border: 10px solid <?php echo $colors_accent_03_hover; ?>;
			}

			#header-top {
				background-color: <?php echo $color_header_top; ?>;
				color: <?php echo $color_header_top_font; ?>;
			}
				
			#header { border-top: 2px solid <?php echo $color_header_top_border; ?>; }	

			#content { color: <?php echo $color_content; ?>; }

			#footer-top { 
				color: <?php echo $color_footer_top_font; ?>;
				background-color: <?php echo $color_footer_top; ?>; 
			}

			#footer-middle {
				color: <?php echo $color_footer_middle_font; ?>;
				background-color: <?php echo $color_footer_middle; ?>; 
			}

			#footer-bottom { 
				color: <?php echo $color_footer_bottom_font; ?>;
				background-color: <?php echo $color_footer_bottom; ?>; 
			}
				
			
		<?php	}	?>		
		
		
		
		
		<?php	
			
			echo '/*';
				$custom_typography = get_option(EWF_SETUP_THNAME."_fonts_custom");
				$_body_background = ewf_hlp_font_decode(EWF_SETUP_THNAME."_background");
			echo '*/';

			echo "body { ".$_body_background."\n }" ;
			
		
		
			if ($custom_typography == 'true'){
				echo "\n/*	###	EWF Custom Typography $custom_typography */ \n";
				 
				
				
				//	Body Font
				//
				
				$_body_font = ewf_hlp_font_decode( EWF_SETUP_THNAME."_body_font", true);
			
				// echo '<pre>FONT';
					// print_r($_body_font);
					// print_r($_body_font_variants);
					// echo ewf_hlp_font_googleurl($_body_font['font-family']);
				// echo '</pre>';
				
				$_body_font_size = 'font-size:'.get_option(EWF_SETUP_THNAME."_body_font_size", '13px')."; \n";
				$_body_font_lineheight = 'line-height:'.get_option(EWF_SETUP_THNAME."_body_font_lineheight", '21px')."; \n";
				
				echo "body { ".$_body_font['css'].$_body_font_size.$_body_font_lineheight."\n }" ;
	
			}	
		?>

		
			
		<?php
		
		return ob_get_clean();
	
	}
	
	
	
	
	
		
	function ewf_admin_ui_font_generateList($selection = null){
		global $_ewf_google_fonts_families;

		ob_start();

		foreach($_ewf_google_fonts_families as $index => $font){
			echo '<li>'.$font.'</li>';
		}	

		return ob_get_clean();
	}
	
	function ewf_admin_ui_font_os() {
		$os_faces = array(
			'Arial, sans-serif' => 'Arial',
			'"Avant Garde", sans-serif' => 'Avant Garde',
			'Cambria, Georgia, serif' => 'Cambria',
			'Copse, sans-serif' => 'Copse',
			'Garamond, "Hoefler Text", Times New Roman, Times, serif' => 'Garamond',
			'Georgia, serif' => 'Georgia',
			'"Helvetica Neue", Helvetica, sans-serif' => 'Helvetica Neue',
			'Tahoma, Geneva, sans-serif' => 'Tahoma'
		);
		return $os_faces;
	}
	
	
	function ajax_ewf_admin_ui_selectTab(){
		$response = array();
		
		if (array_key_exists('admin_tab', $_POST)){
		
			$admin_tab = filter_var($_POST['admin_tab'] , FILTER_SANITIZE_SPECIAL_CHARS);
			if (update_option(EWF_SETUP_THNAME."_admin_tab_active", $admin_tab)){
				echo wp_send_json_success($response);
				exit;
			}else{
				echo wp_send_json_error('Error saving data!');
				exit;					
			}
			
		}else{
			echo wp_send_json_error('Error data check!');
			exit;		
		}
		
	}
	
	function ajax_ewf_admin_ui_font_variants(){
		$response = array();
		
		if (array_key_exists('font', $_POST)){
			$font = $_POST['font'];
			// $fonts_array = json_decode($_ewf_google_fonts, true);
			
			$font_data = ewf_admin_ui_font_getVariants($font);
					
			$response['state'] = 1;
			$response['variants'] = $font_data['variants'];
			$response['subsets'] = $font_data['subsets'];
		
			echo wp_send_json_success($response);
		
		}else{
			echo wp_send_json_error('Error data check!');
			exit;
		} 
	
	}	
	
	function ewf_admin_ui_font_getVariants($font){
		global $_ewf_google_fonts;
		$font_data = array();
		
		$fonts_array = json_decode($_ewf_google_fonts, true);
		
		// echo '<br/>Fonts Count:'.count($fonts_array);
		
		foreach($fonts_array as $item_index => $item_font){
			if ($item_font['family'] == $font){
				$font_data = $item_font;
			}
		}
		
		
		// $styles = array(
			// '-'      => __( 'Font Styles', NECTAR_THEME_NAME ),
			// '100'      => __( '100', NECTAR_THEME_NAME ),
			// '200'      => __( '200', NECTAR_THEME_NAME ),
			// '200italic'      => __( '200 Italic', NECTAR_THEME_NAME ),
			// '300'      => __( '300', NECTAR_THEME_NAME ),
			// '300italic'      => __( '300 Italic', NECTAR_THEME_NAME ),
			// 'regular'      => __( 'Regular', NECTAR_THEME_NAME ),
			// 'italic'      => __( 'Italic', NECTAR_THEME_NAME ),
			// '600'    => __( '600', NECTAR_THEME_NAME ),
			// '600italic' => __( '600 Italic', NECTAR_THEME_NAME ),
			// '700'      => __( '700', NECTAR_THEME_NAME ),
			// '700italic'      => __( '700 Italic', NECTAR_THEME_NAME ),
			// '800'      => __( '800', NECTAR_THEME_NAME ),
			// '800italic'      => __( '800 Italic', NECTAR_THEME_NAME ),
			// '900'      => __( '900', NECTAR_THEME_NAME ),
			// '900italic'      => __( '900 Italic', NECTAR_THEME_NAME ),
		// );
		
		
		return $font_data;
	}
	
	function ajax_ewf_admin_ui_image(){
		$response = array();
		
		if (array_key_exists('image_id', $_POST)){
			$image_id = filter_var($_POST['image_id'] , FILTER_SANITIZE_NUMBER_INT);
			$image_size = $_POST['image_size'];
		
			if ($image_id){
				$ewf_ui_image_preview = wp_get_attachment_image_src( $image_id, 'ewf-logo-size');
					
					$response['image_id'] = $image_id;
					$response['image_url'] = $ewf_ui_image_preview[0];
					$response['state'] = '1'; 
					
					echo wp_send_json_success($response);
					exit;
			}else{
				echo wp_send_json_error('Error image id!');
				exit;
			}
			
		}else{
			echo wp_send_json_error('Error data check!');
			exit;
		} 
	
	}
	
	
	
	
	
?>