<?php

	add_shortcode( 'ewf-map', 'ewf_vc_map' );
	
	
	function ewf_vc_map( $atts, $content ) {
	   extract( shortcode_atts( array(
		  'caption' => __('Google Map', EWF_SETUP_THEME_DOMAIN),
		  'zoom' => '16',
		  'address' => 'Empire State Building, 5th Avenue, New York, Statele Unite ale Americii'
	   ), $atts ) );
	 
		ob_start();

		echo '<div class="google-map map" data-address="'.$address.'" data-zoom="'.$zoom.'" data-caption="'.$caption.'"></div><!-- end .google-map -->'; 
		
		return ob_get_clean();
	}

	
	vc_map( array(
	   "name" => __("Google Map", EWF_SETUP_THEME_DOMAIN),
	   "base" => "ewf-map",
	   "icon" => "icon-wpb-ewf-map",
	   "description" => __("Add Google Map section", EWF_SETUP_THEME_DOMAIN), 
	   "class" => "",
	   "category" => __('Typography', EWF_SETUP_THEME_DOMAIN),
	   "params" => array(
		  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Address", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "address",
			 "value" => '',
			 "description" => __("The address where the map is centered", EWF_SETUP_THEME_DOMAIN)
		  ),
		  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Pinpoint caption", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "caption",
			 "value" => __("Sample caption here", EWF_SETUP_THEME_DOMAIN),
			 "description" => __("Specify text that will appear when you click on the pin", EWF_SETUP_THEME_DOMAIN)
		  ),
		  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Zoom", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "zoom",
			 "value" => 16,
			 "description" => __("Specify a zoom value between 5 and 20", EWF_SETUP_THEME_DOMAIN)
		  )
	   )
	));


?>