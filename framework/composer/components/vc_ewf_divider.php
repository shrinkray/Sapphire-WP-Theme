<?php

	add_shortcode( 'ewf-divider', 'ewf_vc_divider' );
	
	function ewf_vc_divider( $atts, $content ) {
		extract( shortcode_atts( array(
			'height' => 10,
			'separator' => null,
		), $atts ) );
	 		
		$height = intval($height);
		$style_class = $separator;
		
		if ($height){
			return '<div class="divider '.$style_class.'" style="clear:both;padding:'.$height.'px;">&nbsp;</div>';
		}else{
			return null;
		}
	}

	
	vc_map( array(
	   "name" => __("Divider", EWF_SETUP_THEME_DOMAIN),
	   "base" => "ewf-divider",
	   "class" => "",
	   "icon" => "icon-wpb-ewf-divider",
	   "description" => __("Use it to divide content", EWF_SETUP_THEME_DOMAIN),  
	   "category" => __('Typography', EWF_SETUP_THEME_DOMAIN),
	   "params" => array(
	   
		  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Dividing Height", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "height",
			 "value" => 10,
			 "description" => __("Specify the height this block should have", EWF_SETUP_THEME_DOMAIN)
		  ),
		  
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Divider Style", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "separator",
			 "value" => array(__('Single line', EWF_SETUP_THEME_DOMAIN) => 'single-line', __('Double line', EWF_SETUP_THEME_DOMAIN) => 'double-line', __('Dotted line', EWF_SETUP_THEME_DOMAIN) => 'single-dotted', __('Double dotted line', EWF_SETUP_THEME_DOMAIN) => 'double-dotted'),
			 "description" => __("Specify the type of the line", EWF_SETUP_THEME_DOMAIN)
		  ),
		  
	   )
	));

?>