<?php

	add_shortcode( 'ewf_processh_group', 'ewf_vc_process_horizontal_group' );
	add_shortcode( 'ewf_processh_item', 'ewf_vc_process_horizontal_item' );


	function ewf_vc_process_horizontal_group( $atts, $content ) {
		return '<div class="process-builder"><ul class="fixed">'.do_shortcode($content).'</ul></div>';
	}

	function ewf_vc_process_horizontal_item( $atts, $content ) {
		extract( shortcode_atts( array(
			'title' => __('Sample title', EWF_SETUP_THEME_DOMAIN),
			'icon' => null,
			'color' => null,
		), $atts ) );
	 
		ob_start();
		
		echo '<li>';
		
			$style_title_color = null;
			$style_icon_color = null;
			
			if ($color){
				$style_title_color = ' style="color:'.$color.'" ';
				$style_icon_color = ' style="background-color:'.$color.'"; ';
			}
		
			if ($icon){
				echo '<span><i '.$style_icon_color.'class="fa '.$icon.'"></i></span>';
			}
			
			echo '<div class="process-description">';
				echo '<h3'.$style_title_color.'>'.$title.'</h3> ';
			echo '</div><!-- end .process-scription -->';
		echo '</li>';
		
		return ob_get_clean();
	}

	
	
	vc_map( array(
		"name" => __("Process Horizontal", EWF_SETUP_THEME_DOMAIN),
		"base" => "ewf_processh_group",
		"as_parent" => array('only' => 'ewf_processh_item'),
		"content_element" => true,
		"icon" => "icon-wpb-ewf-process-horizontal",
		"description" => __("Create a horizontal list with items", EWF_SETUP_THEME_DOMAIN),  
		"show_settings_on_create" => true,
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
		"base" => "ewf_processh_item",
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
			 "type" => "colorpicker",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Color", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "color",
			 "value" => null,
			 "description" => __("The color of the title", EWF_SETUP_THEME_DOMAIN)
		  ),
		)
	) );
	
	
	
	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_ewf_processh_group extends WPBakeryShortCodesContainer {
		}
	}
	
	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCodeewf_processh_item extends WPBakeryShortCode {
		}
	}

?>