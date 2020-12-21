<?php

	add_shortcode( 'ewf_slider_testimonials', 'ewf_vc_slider_testimonials' );

	
	function ewf_vc_slider_testimonials( $atts, $content ) {
		extract( shortcode_atts( array(
			'background' => '#F6F1ED'
		), $atts ) ); 
		
		return '<div class="testimonial-slider" style="background-color:'.$background.'"><div class="slides">'.do_shortcode($content).'</div></div>';
	}
	
	
	vc_map( array(
		"name" => __("Slider Testimonials", EWF_SETUP_THEME_DOMAIN),
		"base" => "ewf_slider_testimonials",
		"as_parent" => array('only' => 'ewf-testimonial, ewf-testimonial-adv'),
		"content_element" => true,
		"icon" => "icon-wpb-ewf-slider-testimonials",
		"description" => __("Create a slider with testimonials", EWF_SETUP_THEME_DOMAIN),  
		"show_settings_on_create" => false,
		"params" => array(
			
			array(
				"type" => "textfield",
				"heading" => __("Extra class name", EWF_SETUP_THEME_DOMAIN),
				"param_name" => "el_class",
				"description" => __("If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.", "js_composer")
			),
			array(
				"type" => "colorpicker",
				"holder" => "div",
				"class" => "",
				"heading" => __("Background Color", EWF_SETUP_THEME_DOMAIN),
				"param_name" => "background",
				"value" => '#F6F1ED',
				"description" => __("Background color of the slider", EWF_SETUP_THEME_DOMAIN)
			),
		),
		"js_view" => 'VcColumnView'
	) );
	
	
	
	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_ewf_slider_testimonials extends WPBakeryShortCodesContainer {
		}
	}


?>