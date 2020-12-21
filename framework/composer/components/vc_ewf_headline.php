<?php

	add_shortcode( 'ewf-headline', 'ewf_vc_headline' );
	
	function ewf_vc_headline( $atts, $content ) {
	   extract( shortcode_atts( array(
		  'title' => __('Sample title', EWF_SETUP_THEME_DOMAIN),
		  'align' => 'left'
	   ), $atts ) );
	 
		$src = null;
		$class_headline = 'headline';
		
		if ($align == 'center'){
			$class_headline = 'headline-2';
		}
		
		
		$src .= '<h3 class="'.$class_headline.'"><span>';
			$src .= $title;
		$src .= '</span></h3>';
		
		return $src;
	}
		

	vc_map( array(
	   "name" => __("Headline", EWF_SETUP_THEME_DOMAIN),
	   "base" => "ewf-headline",
	   "class" => "",
	   "icon" => "icon-wpb-ewf-headline",
	   // "description" => __("Use normal and accent color on headline", EWF_SETUP_THEME_DOMAIN),  
	   "category" => __('Typography', EWF_SETUP_THEME_DOMAIN),
	   "params" => array(
		  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Title", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "title",
			 "value" => __("Sample title", EWF_SETUP_THEME_DOMAIN),
			 "description" => __("Specify the text of the headline", EWF_SETUP_THEME_DOMAIN)
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Title align", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "align",
			 "value" =>  array( __("Left", EWF_SETUP_THEME_DOMAIN) => 'left', __("Center", EWF_SETUP_THEME_DOMAIN) => 'center'),
			 "description" => __("Specify the way the title should be aligned inside the headline", EWF_SETUP_THEME_DOMAIN)
		  )
	   )
	));

?>