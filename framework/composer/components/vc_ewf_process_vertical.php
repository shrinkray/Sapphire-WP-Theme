<?php

	add_shortcode( 'ewf_processv_group', 'ewf_vc_process_vertical_group' );
	add_shortcode( 'ewf_processv_item', 'ewf_vc_process_vertical_item' );


	function ewf_vc_process_vertical_group( $atts, $content ) {
		return '<ul class="icon-box-6">'.do_shortcode($content).'</ul>';
	}

	function ewf_vc_process_vertical_item( $atts, $content ) {
		extract( shortcode_atts( array(
			'title' => __('Sample title', EWF_SETUP_THEME_DOMAIN),
			'icon' => null
		), $atts ) );
	 
		ob_start();
		
		echo '<li>';
		
			if ($icon){
				echo '<i class="fa '.$icon.'"></i>';
				// echo '<i class="ifc-user_male"></i>';
			}
			
			echo '<div class="icon-box-content">';
				echo '<h3><a href="#">'.$title.'</a></h3>';
				echo $content;
			echo '</div><!-- end .process-builder-1-content -->';
		echo '</li>';
		
		return ob_get_clean();
	}
	
	
	
	
	
	
	vc_map( array(
		"name" => __("Process Vertical", EWF_SETUP_THEME_DOMAIN),
		"base" => "ewf_processv_group",
		"as_parent" => array('only' => 'ewf_processv_item'),
		"content_element" => true,
		"icon" => "icon-wpb-ewf-process-vertical",
		"description" => __("Create a vertical list with items", EWF_SETUP_THEME_DOMAIN),  
		"show_settings_on_create" => false,
		"params" => array(
			
			array(
				"type" => "textfield",
				"heading" => __("Extra class name", EWF_SETUP_THEME_DOMAIN),
				"param_name" => "el_class",
				"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
			)
		),
		"js_view" => 'VcColumnView'
	) );
	
	
	
	vc_map( array(
		"name" => __("Process Item", EWF_SETUP_THEME_DOMAIN),
		"base" => "ewf_processv_item",
		"icon" => "icon-wpb-ewf-process-item",
		"content_element" => true,
		"as_child" => array('only' => 'ewf_processh_group'),
		"show_settings_on_create" => true, 
		"params" => array(
			
		  array(
			 "type" => "ewf-icon",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Select Icon", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "icon",
			 "value" => null,
			 "description" => __("Select the icon you want to have on the left side of the section", EWF_SETUP_THEME_DOMAIN)
		  ),
		  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Title", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "title",
			 "value" => __("Title", EWF_SETUP_THEME_DOMAIN),
			 "description" => __("The title of the progress bar", EWF_SETUP_THEME_DOMAIN)
		  ),
		  array(
			 "type" => "textarea",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Details", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "content",
			 "value" => null,
			 "description" => __("The content of progress", EWF_SETUP_THEME_DOMAIN)
		  ),
		)
	) );
	
	// vc_map( array(
		// "name" => __("Process Item V", EWF_SETUP_THEME_DOMAIN),
		// "base" => "ewf_processv_item",
		// "icon" => "icon-wpb-ewf-process-item",
		// "content_element" => true,
		// "as_child" => array('only' => 'ewf_processv_group'),
		// "show_settings_on_create" => true, 
		// "params" => array(
			
		  // array(
			 // "type" => "ewf-icon",
			 // "holder" => "div",
			 // "class" => "",
			 // "heading" => __("Select Icon", EWF_SETUP_THEME_DOMAIN),
			 // "param_name" => "icon",
			 // "value" => null,
			 // "description" => __("Select the icon you want to have on the left side of the section", EWF_SETUP_THEME_DOMAIN)
		  // ),
		  // array(
			 // "type" => "textfield",
			 // "holder" => "div",
			 // "class" => "",
			 // "heading" => __("Title", EWF_SETUP_THEME_DOMAIN),
			 // "param_name" => "title",
			 // "value" => __("Title", EWF_SETUP_THEME_DOMAIN),
			 // "description" => __("The title of the progress bar", EWF_SETUP_THEME_DOMAIN)
		  // ),
		  // array(
			 // "type" => "textarea_html",
			 // "holder" => "div",
			 // "class" => "",
			 // "heading" => __("Details", EWF_SETUP_THEME_DOMAIN),
			 // "param_name" => "content",
			 // "value" => null,
			 // "description" => __("The content of progress", EWF_SETUP_THEME_DOMAIN)
		  // ),
		// )
	// ) );
	
	
	
	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_ewf_processv_group extends WPBakeryShortCodesContainer {
		}
	}
	
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCodeewf_processv_item extends WPBakeryShortCode {
		}
	}

?>